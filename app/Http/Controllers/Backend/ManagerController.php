<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;

use App\User;
use App\Address;
use App\Branch;

class ManagerController extends Controller
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
    public function index()
    {
        $managers = User::where('user_type','2')->where('type','0')->get();
        $addresses = Address::pluck('id','name');
        $branches = Branch::pluck('id','name');
        return view('backend.manager', compact('managers','addresses','branches'));
    }

    public function store(){
        $rules = array(
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_no' => 'required|unique:users',
        );
        $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $current_date = date("Y-m-d H:i:s");
        $user_id = Auth::user()->id;
        $user = new User;
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        $user->password = bcrypt(Input::get('phone_no'));
        $user->phone_no = Input::get('phone_no');
        $user->address_id = Input::get('address_id');
        $user->branch_id = Input::get('branch_id'); // note very important steps
        $user->user_type = '2';
        $user->type = '0';
        $user->is_active = '1';
        $user->created_by = Auth::user()->id;
        $user->created_at = $current_date;
        if ($user->save()){
            $this->request->session()->flash('alert-success', 'Branch saved successfully!');
            }
        else{
            $this->request->session()->flash('alert-warning', 'Branch could not add!');
        }
        return back()->withInput();
    }
}
