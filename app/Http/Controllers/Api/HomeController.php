<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Auth;
use Response;
use App\User;


class HomeController extends Controller
{
    public function login()
    {
        $email = Input::get('email');
        $password = Input::get('password');
        if(Auth::attempt(['email'=>$email,'password'=>$password,'type'=>'1','user_type'=>'0'], true)){
            return Response::json(['success'=>true,'message'=>'Successfully logged in','user'=>Auth::user()]);
        }
        else{
            return Response::json(['success'=>false,'message'=>'Invalid username or password']);
        }
    }
    
    public function register(Request $request)
    {
		$data = $request->getContent();
        $data = json_decode($data);
        
        $output = array("success"=>false, "message"=>"Registration failed");
        if(trim($data->fname) == ""){
			$output["message"] = "Name cannot be blank";
			return Response::json($output);
		}
        if(trim($data->phone_no) == "" && strlen($data->phone_no) < 6){
			$output["message"] = "Phone number cannot be blank and must be atleast 6 numbers";
			return Response::json($output);
		}
		if(strlen(trim($data->password)) < 8){
			$output["message"] = "Password cannot be blank";
			return Response::json($output);
		}
		if(trim($data->password) != trim($data->cpassword)){
			$output["message"] = "Confirm password must match";
			return Response::json($output);
		}
		if(trim($data->email) == "") $data->email = trim($data->phone_no);
		try{
			$user = new User;
			$user->name = $data->fname;
			$user->email = $data->email;
			$user->password = bcrypt($data->password);
			$user->phone_no = $data->phone_no;
			$user->address_id = $data->address;
			$user->branch_id = '1';
			$user->user_type = '0';
			$user->type = '1';
			$user->is_active = '1';
			$user->created_by = '1';
			$user->save();
			Auth::login($user, true);
			$output = array("success"=>true, "message"=>"Registration success", "user"=>Auth::user());
			return Response::json($output);
		} catch(\Exception $e){
			$output["message"] = $e->getMessage();
			return Response::json($output);
		}
    }

    public function auth(){
        if(Auth::user() == NULL){
        	if(Auth::viaRemember()){
                return Response::json(['success'=>true,'message'=>'Successfully logged in','user'=>Auth::user()]);
            }
            return Response::json(['success'=>false,'message'=>'Please logged in']);
        }
            return Response::json(['success'=>true,'message'=>'Successfully logged in','user'=>Auth::user()]);
        
    }

    public function authy(){
        var_dump(Auth::user());
        return Response::json(Auth::user());

    }

    public function getLogout(){
        Auth::logout();
        var_dump("logout");
    }
}
