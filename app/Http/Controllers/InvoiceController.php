<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceCollection;
use App\Models\Apartment;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\RoomRent;
use App\Services\TelegramBot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use KhmerDateTime\KhmerDateTime;
use Telegram\Bot\Exceptions\TelegramOtherException;
use Telegram\Bot\FileUpload\InputMedia;
use Telegram\Bot\Laravel\Facades\Telegram;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $start = $request->start_date == '' ? Carbon::parse(date('y-m-d'))->startOfMonth() : $request->start_date . ' 00:00:00';
        $end = $request->end_date == '' ? Carbon::parse(date('y-m-d'))->endOfMonth() : $request->end_date . ' 23:59:59';

        $apartmentId = Auth::user()->apartment->id;

        $invoiceQuery = Invoice::with('room')
            ->join('rooms', 'invoices.room_rent_id', '=', 'rooms.id')
            ->select(
                'invoices.*',
                'rooms.name as room_name',
                'rooms.id as room_id',
                'rooms.created_at as rCreated_at',
                'rooms.updated_at as rUpdatedAt'
            )
            ->where('invoices.apartment_id', $apartmentId)
            ->orderBy('rooms.name', 'asc');

        if ($start && $end) {
            $invoiceQuery->whereBetween('invoices.created_at', [$start, $end]);
        }

        if ($keyword) {
            $invoiceQuery->where(function ($query) use ($keyword) {
                $query->where('rooms.name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('invoices.invoice_no', 'LIKE', '%' . $keyword . '%');
            });
        }

        $invoices = $invoiceQuery->get();
        $apart = Apartment::find($apartmentId);

        return view('invoice.index', ['invoice' => $invoices, 'apart' => $apart]);
    }

    public function invoiceSearch(Request $request)
    {
        $keyword = $request->keyword;
        $start = $request->start_date == '' ? Carbon::parse(date('y-m-d'))->startOfMonth() : $request->start_date .' 00:00:00';
        $end = $request->end_date == '' ? Carbon::parse(date('y-m-d'))->endOfMonth() : $request->end_date .' 23:59:59';
        $send = $request->send_noted;
        $screenshot = $request->screenshot;
        $paid = $request->is_paid;
        $apartmentId = Auth::user()->apartment->id;

        $invoiceQuery = Invoice::with('room')
            ->join('rooms', 'invoices.room_rent_id', '=', 'rooms.id')
            ->select(
                'invoices.*',
                'rooms.name as room_name',
                'rooms.id as room_id',
                'rooms.created_at as rCreated_at',
                'rooms.updated_at as rUpdatedAt'
            )
            ->where('invoices.apartment_id', $apartmentId)
            ->orderBy('rooms.name', 'asc');

        if ($start && $end) {
            $invoiceQuery->whereBetween('invoices.created_at', [$start, $end]);
        }

        if ($keyword) {
            $invoiceQuery->where(function ($query) use ($keyword) {
                $query->where('rooms.name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('invoices.invoice_no', 'LIKE', '%' . $keyword . '%');
            });
        }

        if ($paid !== null) {
            $invoiceQuery->where('invoices.is_paid', (bool) $paid);
        }

        if($screenshot !== null){
            $invoiceQuery->where('invoices.is_screenshot', (bool) $screenshot);
        }

        if($send == 1){
            $invoiceQuery->where('invoices.telegram_message','done');
        }else{
            $invoiceQuery->where('invoices.telegram_message');
        }

        $invoice = $invoiceQuery->get();
        $apart = Apartment::find($apartmentId);

        return view('invoice.search', ['invoice' => $invoice, 'apart' => $apart]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::whereIn('id', $roomRents)->orderBy('name')->get();
        $apart = Apartment::find(Auth::user()->apartment_id);
        return view('invoice.create', ['rooms' => $rooms, 'apart' => $apart]);
    }

    public function invoiceNo()
    {
        $invoiceCount = Invoice::count();
        $nextInvoiceNumber = $invoiceCount + 1;
        $invoiceNo = 'INV-' . str_pad($nextInvoiceNumber, 6, '0', STR_PAD_LEFT);
        return $invoiceNo;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_cost' => 'required',
            'electric_cost' => 'required',
            'sub_total_amount' => 'required',
        ], [
            'room_cost.required' => __('app.label_choose_room') . __('app.label_required'),
            'electric_cost.required' => __('app.invoice_eletrotic_cost') . __('app.label_required'),
            'sub_total_amount.required' => __('app.label_calculator')
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $invoice = new Invoice();
        $invoice->is_paid = 0;
        $invoice->is_screenshot = 0; // Not yet
        $invoice->invoice_no = $this->invoiceNo();
        $invoice->apartment_id = Auth::user()->apartment_id;
        $invoice->invoice_date = $request->day . '-' . $request->month . '-' . $request->year;
        $invoice->room_rent_id = $request->room;
        $invoice->room_cost = $request->room_cost;
        $invoice->electric_cost = $request->electric_cost;
        $invoice->water_old_number = $request->old_number;
        $invoice->water_new_number = $request->new_number;
        $invoice->water_cost = $request->water_cost;
        $invoice->trash_cost = $request->trash_cost;
        $invoice->other = $request->other;
        $invoice->sub_total_amount = $request->sub_total_amount;
        $invoice->total_amount = $request->total_amount;
        $invoice->user_id = Auth::user()->id;
        $invoice->terms_and_conditions = $request->terms_and_conditions;
        $invoice->save();

        if ($request->saveAndCreate == "new") {
            return redirect('/invoice/create')->with('success', __('app.label_created_successfully'));
        } else {
            return redirect('/invoice')->with('success', __('app.label_created_successfully'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice = Invoice::find($invoice->id);
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::whereIn('id', $roomRents)->orderBy('name')->get();
        $apart = Apartment::find(Auth::user()->apartment_id);
        return view('invoice.edit', ['rooms' => $rooms, 'apart' => $apart, 'invoice' => $invoice]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'room_cost' => 'required',
            'electric_cost' => 'required',
            'sub_total_amount' => 'required',
        ], [
            'room_cost.required' => __('app.label_choose_room') . __('app.label_required'),
            'electric_cost.required' => __('app.invoice_eletrotic_cost') . __('app.label_required'),
            'sub_total_amount.required' => __('app.label_calculator')
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $invoice = Invoice::find($id);
        $invoice->is_screenshot = 0; // Not yet
        $invoice->invoice_no = $this->invoiceNo();
        $invoice->invoice_date = $request->day . '-' . $request->month . '-' . $request->year;
        $invoice->room_rent_id = $request->room;
        $invoice->room_cost = $request->room_cost;
        $invoice->electric_cost = $request->electric_cost;
        $invoice->water_old_number = $request->old_number;
        $invoice->water_new_number = $request->new_number;
        $invoice->water_cost = $request->water_cost;
        $invoice->trash_cost = $request->trash_cost;
        $invoice->other = $request->other;
        $invoice->sub_total_amount = $request->sub_total_amount;
        $invoice->total_amount = $request->total_amount;
        $invoice->user_id = Auth::user()->id;
        $invoice->terms_and_conditions = $request->terms_and_conditions;
        $invoice->save();

        return redirect('/invoice')->with('success', __('app.label_updated_successfully'));
    }

    public function pay($id)
    {
        $invoice = Invoice::find($id);
        $invoice->is_paid = $invoice->is_paid == 0 ? 1 : 0;
        $invoice->save();
        return redirect('/invoice');
    }

    public function print($id)
    {
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::whereIn('id', $roomRents)->orderBy('name')->get();
        $apart = Apartment::find(Auth::user()->apartment_id);
        $invoice = Invoice::find($id);
        return view('invoice.print', ['invoice' => $invoice, 'rooms' => $rooms, 'apart' => $apart]);
    }

    public function screenshot($id)
    {
        $invoice = Invoice::find($id);
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::whereIn('id', $roomRents)->orderBy('name')->get();
        $apart = Apartment::find(Auth::user()->apartment_id);
        View::share(['rooms' => $rooms, 'apart' => $apart, 'invoice' => $invoice]);
        return view('invoice.screenshot', ['rooms' => $rooms, 'apart' => $apart, 'invoice' => $invoice]);
    }

    public function saveScreenshot(Request $request)
    {
        Log::info($request->base64data);
        $image = $request->base64data;
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $filename = $request->invoice_no . ".jpg";
        $file = $filename;

        Storage::disk('invoices')->put($file, $image_base64);

        $invoice = Invoice::find($request->id);
        $invoice->is_screenshot = 1; // Done
        $invoice->save();

        return redirect('/invoice')->with('success', __('app.label_screenshot_successfully'));
    }

    public function send($id)
    {
        try {
            $invoice = Invoice::find($id);
            $telegramBot = new TelegramBot();

            $groupId = RoomRent::where("room_id", $invoice->room_rent_id)->pluck('telegram_id');
            $message = $invoice->invoice_no . ', ' . KhmerDateTime::parse(now())->format("LLLLT");
            $telegramBot->sendMessagePhoto($groupId, $invoice->invoice_no, $message);

            $invoice->telegram_message = "done";
            $invoice->telegram_message_at = now();
            $invoice->save();
        } catch (TelegramOtherException $e) {
            Log::error("Error ** Send Invoice ** " . $e->getMessage());
        }

        return redirect('/invoice')->with('success', __('app.label_sent_successfully'));
    }

    public function sendAll(Request $request)
    {
        foreach ($request->select_room_id as $id) {
            $this->send($id);
        }

        return redirect('/invoice')->with('success', __('app.label_sent_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function invoiceDestroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();

        return redirect('/invoice')->with('delete', __('app.label_deleted_successfully'));
    }
}
