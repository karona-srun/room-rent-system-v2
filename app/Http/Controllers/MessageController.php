<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use App\Models\RoomRent;
use App\Services\MadelineService;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::orderBy('created_at','asc')->get();
        return view('message.index', ['messages' => $messages]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::where('status', 'Free')->whereIn('id',$roomRents)->orderBy('name')->get();
        return view('message.create',['rooms' => $rooms]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_rent' => 'required',
            'message' => 'required',
        ],[
            'room_rent.required' => __('app.label_choose_room').__('app.label_required'),
            'message.required' => __('app.label_write_message').__('app.label_required'),
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $room = new Message();
        $room->room_rent_id = json_encode($request->room_rent);
        $room->message = $request->message;
        $room->apartment_id = Auth::user()->apartment_id;
        $room->user_id = Auth::user()->id;
        $room->save();
        
        if($request->saveAndCreate == "new"){
            return redirect('/message/create')->with('success',__('app.label_created_successfully'));
        }else{
            return redirect('/message')->with('success',__('app.label_created_successfully'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        $message = Message::find($message->id);
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::where('status', 'Free')->whereIn('id',$roomRents)->orderBy('name')->get();
        return view('message.edit', ['rooms' => $rooms,'message' => $message]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        $validator = Validator::make($request->all(), [
            'room_rent' => 'required',
            'message' => 'required',
        ],[
            'room_rent.required' => __('app.label_choose_room').__('app.label_required'),
            'message.required' => __('app.label_write_message').__('app.label_required'),
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $room = Message::find($message->id);
        $room->room_rent_id = json_encode($request->room_rent);
        $room->message = $request->message;
        $room->apartment_id = Auth::user()->apartment_id;
        $room->user_id = Auth::user()->id;
        $room->save();

        return redirect('/message')->with('success',__('app.label_updated_successfully'));
    }

    public function sendMessage($request)
    {
        $peer = "+85585773007";
        $message = "សួស្តី! ខ្ញុំគឺជាម៉ូឌែលអភិវឌ្ឍន៍ដែលអាចជួយអ្នកបាន។ តើមានអ្វីដែលអ្នកចង់សិក្សាទេ? ខ្ញុំអាចជួយបានក្នុងបញ្ហា​ច្បាស់លាស់ ឬការសរសេរឯកសារដែលអ្នកចង់មើលវិញ។ អ្នកអាចចូលទៅក្នុងកម្មវិធីដែលបានបង្កើតដើម្បីបង្ហាញភាសាដែលអ្នកចង់ប្រើ។ សូមជួយខ្ញុំដើម្បីសិក្សាបន្ថែម!";

        $madelineService = new MadelineService();

        // $madelineService->OTP('42020');
        // $madelineService->Login($peer);
        
        //$result = $madelineService->sendMessage($peer, $message);
        
        //return response()->json(['result' => $result]);

        $apiId = env('APP_API_ID');
        $apiHash = env('APP_API_HASH');
        $phoneNumber = $peer;
         
        try {
            $madelineService->sendMessageToTelegramUser($apiId, $apiHash, $phoneNumber, $message);
            echo "Message sent successfully!";
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function sendMessageAll($id) 
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function messageDestroy($id)
    {
        $message = Message::find($id);
        $message->delete();

        return redirect('/message')->with('delete', __('app.label_deleted_successfully'));
    }
}
