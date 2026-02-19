<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Auth;
use Response;
use Hash;

use App\User;
use App\Order_total;

class CustomerController extends Controller
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
        return view('backend.report.customer');
    }

    public function search()
    {
        $rules = array(
                'customer_type' => 'required',
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $customer_type = Input::get('customer_type');
        $customer_id = Input::get('customer_id');
        $date = Input::get('date');
        // var_dump($customer_type, $customer_id, $date); die();
        $req_to = date('Y/m/d', strtotime($date));
        if($customer_type == '1'){
            $query = Order_total::orderBy('id','DESC');
            if($customer_id != ''){
                $query->where('customer_id',$customer_id);
            }else{
                $query;
            }
            if($date !=''){
                $query->where('date','=',$req_to);
            }
            $customerquery = $query->get();
            $count=count($customerquery);
            return view('backend.report.customer-search', compact(['customerquery','req_to','count','date']));
        }
    }

    public function getCustomer()
    {
        $customer_type = Input::get('customer_type');
        $name = User::where('type', $customer_type)->pluck('id','email');
        return Response::json($name);
    }

}