<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use App\Models\RoomRent;
use Illuminate\Http\Request;
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

        return redirect('/message')->with('success',__('app.label_created_successfully'));
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

    public function sendMessage($id) 
    {
        
    }

    public function sendMessageAll($id) 
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message = Message::find($message->id);
        $message->delete();

        return redirect('/message')->with('delete', __('app.label_deleted_successfully'));
    }
}
