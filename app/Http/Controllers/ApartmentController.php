<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartment = Apartment::orderBy('name','asc')->get();
        return view('apartment.index', ['apartment'=>$apartment]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('apartment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'exchange_riel' => 'required',
            'water_cost' => 'required',
            'trash_cost' => 'required',
        ],[
            'name.required' => __('app.label_apartment_name').__('app.label_required'),
            'exchange_riel.required' => __('app.label_exchange_riel').__('app.label_required'),
            'water_cost.required' => __('app.label_water_cost').__('app.label_required'),
            'trash_cost.required' => __('app.label_trash_cost').__('app.label_required'),
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $apartment = new Apartment();
        $apartment->name = $request->name;

        if ($request->file('logo')) {
            $file = $request->file('logo');
            $filename = $request->name . '_' . date('YmdHi') . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('/assets/img/logo/'), $filename);
            $apartment->logo = '/logo/' . $filename;
        }else{
            $apartment->logo = '/logo/apartment.png';
        }
        
        $apartment->exchange_riel = $request->exchange_riel;
        $apartment->water_module = $request->water_module;
        $apartment->token = $request->token;
        $apartment->water_cost = $request->water_cost;
        $apartment->trash_cost = $request->trash_cost;
        $apartment->address = $request->address;
        $apartment->noted = $request->noted;
        $apartment->start_date = $request->start_date;
        $apartment->end_date = $request->end_date;
        $apartment->terms_and_conditions = $request->terms_and_conditions;
        $apartment->save();

        if($request->saveAndCreate == "new"){
            return redirect('/apartment/create')->with('success',__('app.label_created_successfully'));
        }else{
            return redirect('/apartment')->with('success',__('app.label_created_successfully'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $apart = Apartment::find($id);
        return view('apartment.edit', ['apart' => $apart]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'exchange_riel' => 'required',
            'water_cost' => 'required',
            'trash_cost' => 'required',
        ],[
            'name.required' => __('app.label_apartment_name').__('app.label_required'),
            'exchange_riel.required' => __('app.label_exchange_riel').__('app.label_required'),
            'water_cost.required' => __('app.label_water_cost').__('app.label_required'),
            'trash_cost.required' => __('app.label_trash_cost').__('app.label_required'),
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $apartment = Apartment::find($apartment->id);
        $apartment->name = $request->name;

        if ($request->file('logo')) {
            $file = $request->file('logo');
            $filename = $request->name . '_' . date('YmdHi') . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('/assets/img/logo/'), $filename);
            $apartment->logo = '/logo/' . $filename;
        }
        
        $apartment->exchange_riel = $request->exchange_riel;
        $apartment->water_module = $request->water_module;
        $apartment->token = $request->token;
        $apartment->water_cost = $request->water_cost;
        $apartment->trash_cost = $request->trash_cost;
        $apartment->address = $request->address;
        $apartment->noted = $request->noted;
        $apartment->start_date = $request->start_date;
        $apartment->end_date = $request->end_date;
        $apartment->terms_and_conditions = $request->terms_and_conditions;
        $apartment->save();
            
        return redirect('/apartment')->with('success',__('app.label_updated_successfully'));
    
    }

    public function waterModule($id)
    {
        $apartment = Apartment::findOrFail($id);
        $apartment->water_module = $apartment->water_module ? false : true;
        $apartment->save();
        $data = [
            'success' => true
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apart = Apartment::find($apartment->id);
        $apart->delete();
        
        return redirect('/apartment')->with('danger',__('app.label_deleted_successfully'));
    }
}
