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

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::where('is_active','1')->orderBy('id','DESC')->get();
        return view('backend.unit', compact('units'));
    }

    public function store(Request $request){
        $rules = array(
            'name' => 'required|unique:units',
        );
        $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $current_date = date("Y-m-d H:i:s");
        $user_id = Auth::user()->id;
        $unit = new Unit;
        $unit->name = Input::get('name');
        $unit->slug = strtolower(Input::get('name'));
        $unit->is_active = '1';
        $unit->created_by = $user_id;
        $unit->created_at = $current_date;
    if ($unit->save()){
            $this->request->session()->flash('alert-success', 'Unit saved successfully!');
        }
    else{
        $this->request->session()->flash('alert-warning', 'Unit could not add!');
    }
    return back()->withInput();
    }
}