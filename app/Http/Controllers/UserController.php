<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::orderBy('name','asc')->get();
        return view('user.index', ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apartment = Apartment::orderBy('name','asc')->get();
        return view('user.create', ['apartment' => $apartment]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed',
            'apartment' => 'required',
        ],[
            'email.unique' => __('app.label_user_email').__('app.label_unique'),
            'name.required' => __('app.label_user_name').__('app.label_required'),
            'email.required' => __('app.label_user_email').__('app.label_required'),
            'phone.required' => __('app.label_user_phone').__('app.label_required'),
            'phone.unique' => __('app.label_user_phone').__('app.label_unique'),
            'password.required' =>  __('app.label_password').__('app.label_required'),
            'apartment.required' =>  __('app.label_apartment_name').__('app.label_required')
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->apartment_id = $request->apartment;
        $user->is_active = $request->is_active;
        $user->password = Hash::make($request->password);
        
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = $request->phone . '_' . date('YmdHi') . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('/assets/img/faces/'), $filename);
            $user->image = '/img/faces/' . $filename;
        }else{
            $user->image = '/img/faces/user.gif';
        }

        $user->save();

        return redirect('/user')->with('success',__('app.label_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        $apartment = Apartment::orderBy('name','asc')->get();
        return view('user.edit',['user'=>$user,'apartment' => $apartment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,'. $id,
            'phone' => 'required|unique:users,email,'. $id,
            'apartment' => 'required',
        ],[
            'email.unique' => __('app.label_user_email').__('app.label_unique'),
            'name.required' => __('app.label_user_name').__('app.label_required'),
            'email.required' => __('app.label_user_email').__('app.label_required'),
            'phone.required' => __('app.label_user_phone').__('app.label_required'),
            'phone.unique' => __('app.label_user_phone').__('app.label_unique'),
            'apartment.required' =>  __('app.label_apartment_name').__('app.label_required')
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->apartment_id = $request->apartment;
        $user->is_active = $request->is_active;
        $user->password = $request->password == "" ? $user->password : Hash::make($request->password);
        
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = $request->phone . '_' . date('YmdHi') . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('/assets/img/faces/'), $filename);
            $user->image = '/img/faces/' . $filename;
        }

        $user->save();

        return redirect('/user')->with('success',__('app.label_updated_successfully'));
    }

    public function changePassword($id)
    {
        $user = User::find($id);
        return view('user.change_passowrd',['user'=>$user]);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed',
        ],[
            'password.required' =>  __('app.label_password').__('app.label_required')
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/user')->with('success',__('app.label_changed_password_successfully'));
    }
    public function userStatus($id)
    {
        $user = User::find($id);
        $user->is_active = $user->is_active == 0 ? 1 : 0;
        $user->save();
        if($user->is_active == 1){
            return redirect('/user')->with('success',__('app.label_unblocked_successfully'));
        }else{
            return redirect('/user')->with('delete',__('app.label_blocked_successfully'));
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function userDestroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/user')->with('danger',__('app.label_deleted_successfully'));
    }
}
