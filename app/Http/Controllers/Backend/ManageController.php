<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;

use App\Unit;
use App\Purchase;
use App\Purchase_has_manage;

class ManageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $units = Unit::where('is_active','1')->orderBy('id','DESC')->pluck('id','name');
        $manages = Purchase_has_manage::where('purchase_id', $id)->get();
        $item_details = Purchase::where('id', $id)->get();
        return view('backend.purchase-manage', compact('units','manages','id','item_details'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id){
        $rules = array(
            'quantity' => 'required',
            'unit_id' => 'required',
            'price' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $current_date = date("Y-m-d H:i:s");
        $date = date("Y/m/d");
        $user_id = Auth::user()->id;
        $manage = new Purchase_has_manage;
        $manage->purchase_id = $id;
        $manage->weight = Input::get('quantity');
        $manage->unit_id = Input::get('unit_id');
        $manage->rate = Input::get('price');
        $manage->date = $date;
        $manage->is_active = '1';
        $manage->created_by = $user_id;
        $manage->created_at = $current_date;
    if ($manage->save()){
            $this->request->session()->flash('alert-success', 'Manage saved successfully!');
        }
    else{
        $this->request->session()->flash('alert-warning', 'Manage could not add!');
    }
    return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }
}