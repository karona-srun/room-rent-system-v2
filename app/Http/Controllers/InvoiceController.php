<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\RoomRent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoice = Invoice::with('room')
            ->join('rooms', 'invoices.room_rent_id', '=', 'rooms.id')
            ->select('invoices.*', 'rooms.name as room_name','rooms.id as room_id')
            ->orderBy('rooms.name', 'asc') 
            ->get();
        return view('invoice.index', ['invoice' => $invoice]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::whereIn('id',$roomRents)->orderBy('name')->get();
        $apart = Apartment::find(Auth::user()->apartment_id);
        return view('invoice.create',['rooms' => $rooms,'apart' => $apart]);
    }

    public function invoiceNo()
    {
        $latest = Invoice::latest()->first();
        if (!$latest) {
            return 'INV'.now()->format('dmy').'-'.'0001';
        }
        $string = preg_replace("/[^0-9\.]/", '', $latest->invoice_no);
        return 'INV'.now()->format('dmy').'-'. sprintf('%04d', $string + 1);
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
        ],[
            'room_cost.required' => __('app.label_choose_room').__('app.label_required'),
            'electric_cost.required' => __('app.invoice_eletrotic_cost').__('app.label_required'),
            'sub_total_amount.required' => __('app.label_calculator')
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $invoice = new Invoice();
        $invoice->is_paid = 0;
        $invoice->is_screenshot = 0;
        $invoice->invoice_no = $this->invoiceNo();
        $invoice->invoice_date = $request->day.'-'.$request->month.'-'.$request->year;
        $invoice->room_rent_id = $request->room;
        $invoice->room_cost = $request->room_cost;
        $invoice->electric_cost = $request->electric_cost;
        $invoice->water_old_number = $request->old_number;
        $invoice->water_new_number = $request->new_number;
        $invoice->water_cost = $request->water_cost;
        $invoice->other = $request->other;
        $invoice->sub_total_amount = $request->sub_total_amount;
        $invoice->total_amount = $request->total_amount;
        $invoice->user_id = Auth::user()->id;
        $invoice->terms_and_conditions = $request->terms_and_conditions;
        $invoice->save();

        if($request->saveAndCreate == "new"){
            return redirect('/invoice/create')->with('success',__('app.label_created_successfully'));
        }else{
            return redirect('/invoice')->with('success',__('app.label_created_successfully'));
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
        $rooms = Room::whereIn('id',$roomRents)->orderBy('name')->get();
        $apart = Apartment::find(Auth::user()->apartment_id);
        return view('invoice.edit',['rooms' => $rooms,'apart' => $apart, 'invoice' => $invoice]);
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
        ],[
            'room_cost.required' => __('app.label_choose_room').__('app.label_required'),
            'electric_cost.required' => __('app.invoice_eletrotic_cost').__('app.label_required'),
            'sub_total_amount.required' => __('app.label_calculator')
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $invoice = Invoice::find($id);
        $invoice->is_screenshot = 0;
        $invoice->invoice_no = $this->invoiceNo();
        $invoice->invoice_date = $request->day.'-'.$request->month.'-'.$request->year;
        $invoice->room_rent_id = $request->room;
        $invoice->room_cost = $request->room_cost;
        $invoice->electric_cost = $request->electric_cost;
        $invoice->water_old_number = $request->old_number;
        $invoice->water_new_number = $request->new_number;
        $invoice->water_cost = $request->water_cost;
        $invoice->other = $request->other;
        $invoice->sub_total_amount = $request->sub_total_amount;
        $invoice->total_amount = $request->total_amount;
        $invoice->user_id = Auth::user()->id;
        $invoice->terms_and_conditions = $request->terms_and_conditions;
        $invoice->save();

        return redirect('/invoice')->with('success',__('app.label_updated_successfully'));
    }

    public function pay($id)
    {
        $invoice = Invoice::find($id);
        $invoice->is_paid = $invoice->is_paid == 0 ? 1:0;
        $invoice->save();
        return redirect('/invoice');
    }

    public function print($id)
    {
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::whereIn('id',$roomRents)->orderBy('name')->get();
        $apart = Apartment::find(Auth::user()->apartment_id);
        $invoice = Invoice::find($id);
        return view('invoice.print',['invoice' => $invoice, 'rooms' => $rooms,'apart' => $apart]);
    }

    public function screenshot($id)
    {
        $invoice = Invoice::find($id);
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::whereIn('id',$roomRents)->orderBy('name')->get();
        $apart = Apartment::find(Auth::user()->apartment_id);
        return view('invoice.screenshot',['rooms' => $rooms,'apart' => $apart, 'invoice' => $invoice]);
    }

    public function saveScreenshot(Request $request, $id)
    {
        
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
