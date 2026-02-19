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
use App\User;
use App\Order;
use App\Order_total;
use App\Vegetable;
use Redirect;
use View;

class ReviewController extends Controller
{
    public function index()
    {
        $items = Order_total::where('is_seen','0')->where('is_confirmed','0')->where('is_confirmed','0')->orderBy('id','DESC')->get();
        return view('manager.review', compact('items'));
    }

    public function getDetail($bill_id){
        $main_id = Order_total::where('bill_id', $bill_id)->value('id');
        $category_status = Order_total::find($main_id);
        $category_status->is_seen = 1;
        $category_status->save();
        $customer_bills = Order_total::where('bill_id',$bill_id)->get();
        $confirmed_status = Order_total::where('bill_id', $bill_id)->value('is_confirmed');
        $deliver_status = Order_total::where('bill_id', $bill_id)->value('is_deliverd');
        return view('manager.review-bill_print',compact(['customer_bills','bill_id','confirmed_status','deliver_status']));
    }

    public function reviewConfirm(){
        $id = Input::get('id');
        $main_id = Order_total::where('bill_id', $id)->value('id');
        $order_id = Order::where('bill_id', $id)->get();
        foreach($order_id as $oid){
            $orid = Order::find($oid->id);
            // var_dump($oid->id);
            $orid->created_by = Auth::user()->id;
            $orid->save();
        }
        // die();
        $category_status = Order_total::find($main_id);
        $category_status->is_confirmed = 1;
        $category_status->created_by = Auth::user()->id;
        $category_status->confirmed_at = date('Y/m/d H:i:s');
        
        if($category_status->save()){
            $response = array(
                'status' => 'success',
                'msg' => 'Successfully Changed',
            );
        }else{
            $response = array(
                'status' => 'failure',
                'msg' => 'Change Unsuccessful',
            );
        }
        return Response::json($response);
    }
    public function reviewCancle(){
        $id = Input::get('id');
        $main_id = Order_total::where('bill_id', $id)->value('id');
        $category_status = Order_total::find($main_id);
        $category_status->is_confirmed = 2;
        $category_status->created_by = Auth::user()->id;
        $category_status->confirmed_at = date('Y/m/d H:i:s');
        
        if($category_status->save()){
            $response = array(
                'status' => 'success',
                'msg' => 'Successfully Changed',
            );
        }else{
            $response = array(
                'status' => 'failure',
                'msg' => 'Change Unsuccessful',
            );
        }
        return Response::json($response);
    }

    public function reviewDeliver(){
        $id = Input::get('id');
        $main_id = Order_total::where('bill_id', $id)->value('id');
        $category_status = Order_total::find($main_id);
        $category_status->is_deliverd = 1;
        
        if($category_status->save()){
            $response = array(
                'status' => 'success',
                'msg' => 'Successfully Changed',
            );
        }else{
            $response = array(
                'status' => 'failure',
                'msg' => 'Change Unsuccessful',
            );
        }
        return Response::json($response);
    }
    public function bill_print($bill_id){
        if (Auth::check()) 
        {
            $order_total = new Order_total;
            $cat_id =['bill_id' => $bill_id,];
            $customer_bills = Order_total::where($cat_id)->get();
            return view('manager.bill_print',compact(['customer_bills','bill_id']));
        }
    }
}