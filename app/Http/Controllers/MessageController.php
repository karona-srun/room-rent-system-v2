<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use App\Models\RoomRent;
use App\Services\MadelineService;
use App\Services\TelegramBot;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Exceptions\TelegramOtherException;
use Telegram\Bot\Laravel\Facades\Telegram;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::orderBy('created_at', 'asc')->get();
        return view('message.index', ['messages' => $messages]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::where('status', 'Free')->whereIn('id', $roomRents)->orderBy('name')->get();
        return view('message.create', ['rooms' => $rooms]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_rent' => 'required',
            'message' => 'required',
        ], [
            'room_rent.required' => __('app.label_choose_room') . __('app.label_required'),
            'message.required' => __('app.label_write_message') . __('app.label_required'),
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $room = new Message();
        $room->room_rent_id = json_encode($request->room_rent);
        $room->message = $request->message;
        $room->telegram_message = "";
        $room->telegram_message_at = "";
        $room->apartment_id = Auth::user()->apartment_id;
        $room->user_id = Auth::user()->id;
        $room->save();

        if ($request->saveAndCreate == "new") {
            return redirect('/message/create')->with('success', __('app.label_created_successfully'));
        } else {
            return redirect('/message')->with('success', __('app.label_created_successfully'));
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
        $rooms = Room::where('status', 'Free')->whereIn('id', $roomRents)->orderBy('name')->get();
        return view('message.edit', ['rooms' => $rooms, 'message' => $message]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        $validator = Validator::make($request->all(), [
            'room_rent' => 'required',
            'message' => 'required',
        ], [
            'room_rent.required' => __('app.label_choose_room') . __('app.label_required'),
            'message.required' => __('app.label_write_message') . __('app.label_required'),
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $room = Message::find($message->id);
        $room->room_rent_id = json_encode($request->room_rent);
        $room->message = $request->message;
        $room->telegram_message = "";
        $room->telegram_message_at = "";
        $room->apartment_id = Auth::user()->apartment_id;
        $room->user_id = Auth::user()->id;
        $room->save();

        return redirect('/message')->with('success', __('app.label_updated_successfully'));
    }

    public function sendMessage($id)
    {
        try {
            $roomRentIds = Message::find($id);
            $roomRentIdsArray = json_decode($roomRentIds->room_rent_id, true);
            $roomRents = RoomRent::whereIn("room_id", $roomRentIdsArray)->pluck('telegram_id');

            $telegramBot = new TelegramBot();
            $messageId = "";
            foreach ($roomRents as $id) {
                $messageId = $telegramBot->sendMessageText($id, $roomRentIds->message);
            }

            $roomRentIds->telegram_message = "done";
            $roomRentIds->telegram_message_at = now();
            $roomRentIds->save();
        } catch (TelegramOtherException $e) {
            Log::error("Error ** Send Invoice ** " . $e->getMessage());
        }
        return redirect('/message')->with('success', __('app.label_sent_successfully'));
    }

    public function sendMessageAll(Request $request)
    {
        foreach ($request->select_room_id as $id) {
            $this->sendMessage($id);
        }

        return redirect('/message')->with('success', __('app.label_sent_successfully'));
    }

    public function messageList($id)
    {
        dd($id);
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
