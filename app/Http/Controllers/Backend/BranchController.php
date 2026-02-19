<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;

use App\Branch;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::where('is_active','1')->orderBy('id','DESC')->get();
        return view('backend.branch', compact('branches'));
    }

    public function store(Request $request){
        $rules = array(
            'name' => 'required|unique:branches',
        );
        $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $current_date = date("Y-m-d H:i:s");
        $user_id = Auth::user()->id;
        $branch = new Branch;
        $branch->name = Input::get('name');
        $branch->is_active = '1';
    if ($branch->save()){
            $this->request->session()->flash('alert-success', 'Branch saved successfully!');
        }
    else{
        $this->request->session()->flash('alert-warning', 'Branch could not add!');
    }
    return back()->withInput();
    }
}