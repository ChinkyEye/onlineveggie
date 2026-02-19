<?php

namespace App\Http\Controllers\Manager;

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
        // var_dump($id); die();
        // $units = Unit::where('is_active','1')->orderBy('id','DESC')->pluck('id','name');
        $unit_id = Purchase::where('is_active','1')->orderBy('id','DESC')->where('id',$id)->pluck('unit_id');
        $units = Unit::where('is_active','1')->where('id', $unit_id)->orderBy('id','DESC')->pluck('id','name');
        $manages = Purchase_has_manage::where('purchase_id', $id)->orderBy('id','DESC')->get();
        $item_details = Purchase::where('id', $id)->orderBy('id','DESC')->get();
        return view('manager.purchase-manage', compact('units','manages','id','item_details'));
    }

    public function pindex($id)
    {
        // var_dump($id); die();
        // $units = Unit::where('is_active','1')->orderBy('id','DESC')->pluck('id','name');
        $unit_id = Purchase::where('is_active','1')->orderBy('id','DESC')->where('id',$id)->pluck('unit_id');
        $units = Unit::where('is_active','1')->where('id', $unit_id)->orderBy('id','DESC')->pluck('id','name');
        $manages = Purchase_has_manage::where('purchase_id', $id)->orderBy('id','DESC')->get();
        $item_details = Purchase::where('id', $id)->orderBy('id','DESC')->get();
        return view('manager.purchase-manage-entry', compact('units','manages','id','item_details'));
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
    return redirect()->route('purchase-view');
    }

    public function store_entry(Request $request, $id){
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
    return redirect()->route('purchase-entry');
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