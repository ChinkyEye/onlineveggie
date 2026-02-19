<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;
use Hash;

use App\User;

class HomeController extends Controller
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
        return view('backend.home');
    }

    public function changePassword(){
        return view('backend.changepassword');
    }

    public function changePasswordStore(){
        $rules = array(
           'old_password' => 'required',
           'new_password' => 'required|min:8',
           'confirm_password' => 'required|same:new_password',
       );

       $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
        return back()->withInput()
        ->withErrors($validator)
        ->withInput();
        }
        if (Auth::check()) 
        {
            $current_date = date("Y-m-d H:i:s");
            $user_id = Auth::user()->id;
            $user_p_id = User::find($user_id);
            $curr_user_pass = $user_p_id['password'];
            $old_password = Input::get('old_password');
            $new_password = Input::get('new_password');
            if (Hash::check($old_password, $curr_user_pass)) {
                       $user_p_id->fill([
                           'password' => Hash::make($new_password)
                       ])->save();
            $this->request->session()->flash('alert-success', 'Password changed successfully!');
            }
            else{
            $this->request->session()->flash('alert-danger', 'Password couldnot successfully!');
            }
            return back();
        }
    }
}
