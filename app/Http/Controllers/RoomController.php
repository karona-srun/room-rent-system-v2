<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::orderBy('name','asc')->get();
        foreach ($rooms as $key => $room) {
            if ($room->status == 'Free') {
                $rooms[$key]->status = __('app.status_free');
            } else if ($room->status == 'Rented') {
                $rooms[$key]->status = __('app.status_rented');
            } else if ($room->status == 'Fixing') {
                $rooms[$key]->status = __('app.status_fixing');
            }
        }
        return view('room.index', ['rooms' => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:rooms',
            'price' => 'required',
            'status' => 'required',
        ],[
            'name.unique' => __('app.label_name').__('app.label_room').__('app.label_unique'),
            'name.required' => __('app.label_room').__('app.label_required'),
            'price.required' => __('app.label_price').__('app.label_required'),
            'status.required' => __('app.label_status_room').__('app.label_required'),
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $room = new Room();
        $room->name = $request->name;
        $room->price = $request->price;
        $room->status = $request->status;
        $room->noted = $request->noted;
        $room->apartment_id = Auth::user()->apartment_id;
        $room->user_id = Auth::user()->id;
        $room->save();

        return redirect('/room')->with('success',__('app.label_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $room = Room::find($id);
        return view('room.edit', ['room' => $room]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:rooms,name,'. $id,
            'price' => 'required',
            'status' => 'required',
        ],[
            'name.unique' => __('app.label_name').__('app.label_room').__('app.label_unique'),
            'name.required' => __('app.label_room').__('app.label_required'),
            'price.required' => __('app.label_price').__('app.label_required'),
            'status.required' => __('app.label_status_room').__('app.label_required'),
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $room = Room::find($id);
        $room->name = $request->name;
        $room->price = $request->price;
        $room->status = $request->status;
        $room->noted = $request->noted;
        $room->apartment_id = Auth::user()->apartment_id;
        $room->user_id = Auth::user()->id;
        $room->save();

        return redirect('/room')->with('success', __('app.label_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        $room->delete();

        return redirect('/room')->with('delete', __('app.label_deleted_successfully'));
    }
}
