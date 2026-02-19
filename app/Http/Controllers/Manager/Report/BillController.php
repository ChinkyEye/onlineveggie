<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Auth;
use Response;
use Hash;

use App\User;
use App\Category;
use App\Vegetable;
use App\Order_total;

class BillController extends Controller
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
        $categories = Category::where('is_active','1')->pluck('id','name');
        return view('manager.report.bill', compact('categories'));
    }

    public function search()
    {
        $bill_no = Input::get('bill_no');
        $date = Input::get('date');
        $req_to = date('Y/m/d', strtotime($date));
        // var_dump($bill_no, $req_to); die();
            $query = Order_total::orderBy('id','DESC');
//->where('created_by', Auth::user()->id)
            if($bill_no != ""){
                $query->where('bill_id', $bill_no);
            }
            if($date !=''){
                $query->where('date','=',$req_to);
            }
            // var_dump($query); die();
            $customerquery = $query->get();
            $count=count($customerquery);
            return view('manager.report.bill-search', compact(['customerquery','req_to','count','date']));
    }

}