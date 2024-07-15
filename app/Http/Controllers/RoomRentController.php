<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomRent;
use App\Services\TelegramBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomRentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomRents = RoomRent::with('room')->where('room_rents.apartment_id',Auth::user()->apartment_id)
            ->join('rooms', 'room_rents.room_id', '=', 'rooms.id')
            ->select('room_rents.*', 'room_rents.id as room_rent_id')
            ->orderBy('rooms.name', 'asc') 
            ->get();

        return view('room_rent.index', ['roomRents' => $roomRents]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomRents = RoomRent::pluck('room_id')->toArray();
        $rooms = Room::where('status', 'Free')->where('apartment_id',Auth::user()->apartment_id)->whereNotIn('id',$roomRents)->orderBy('name')->get();
        
        $telegramBot = new TelegramBot();
        $listGroups = $telegramBot->listGroup();

        return view('room_rent.create',['rooms' => $rooms,'listGroups' => $listGroups]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roomRent = new RoomRent();
        $roomRent->room_id = $request->room;
        $roomRent->price = $request->price;
        $roomRent->customer_name = $request->customer_name;
        $roomRent->phone = $request->phone;
        $roomRent->telegram_id = $request->telegram_id;
        $roomRent->address = $request->address;
        $roomRent->noted = $request->noted;
        $roomRent->apartment_id = Auth::user()->apartment_id;
        $roomRent->user_id = Auth::user()->id;

        if ($request->file('photo_front')) {
            $file = $request->file('photo_front');
            $filename = $request->phone . '_' . date('YmdHi') . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('images/card/'), $filename);
            $roomRent->image_front = 'images/card/' . $filename;
        }

        if ($request->file('photo_back')) {
            $file = $request->file('photo_back');
            $filename =  $request->phone . '_' . date('YmdHi') . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('images/card'), $filename);
            $roomRent->image_back = 'images/card/' . $filename;
        }

        $room = Room::find($request->room);
        $room->status = 'Rented';
        $room->save();

        $roomRent->save();

        return redirect('/room-rent/create')->with('success', __('app.label_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomRent $roomRent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomRent $roomRent)
    {
        $rooms = Room::where('status', 'Free')->where('apartment_id',Auth::user()->apartment_id)->orderBy('name')->get();
        $data = RoomRent::find($roomRent->id);
        $telegramBot = new TelegramBot();
        $listGroups = $telegramBot->listGroup();
        return view('room_rent.edit',['data' => $data,'rooms' => $rooms, 'listGroups' => $listGroups]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $roomRent = RoomRent::find($id);
        $roomRent->room_id = $request->room;
        $roomRent->price = $request->price;
        $roomRent->customer_name = $request->customer_name;
        $roomRent->phone = $request->phone;
        $roomRent->telegram_id = $request->telegram_id;
        $roomRent->address = $request->address;
        $roomRent->noted = $request->noted;
        $roomRent->apartment_id = Auth::user()->apartment_id;
        $roomRent->user_id = Auth::user()->id;

        if ($request->file('photo_front')) {
            $file = $request->file('photo_front');
            $filename = $request->phone . '_' . date('YmdHi') . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('images/card_id/'), $filename);
            $roomRent->photo_front = 'images/card_id/' . $filename;
        }

        if ($request->file('photo_back')) {
            $file = $request->file('photo_back');
            $filename =  $request->phone . '_' . date('YmdHi') . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('images/card_id'), $filename);
            $roomRent->photo_back = 'images/card_id/' . $filename;
        }

        $roomRent->save();

        return redirect('/room-rent')->with('success', __('app.label_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $roomRent = RoomRent::find($id);
        $roomRent->delete();

        return redirect('/room-rent')->with('delete', __('app.label_deleted_successfully'));
    }
}
