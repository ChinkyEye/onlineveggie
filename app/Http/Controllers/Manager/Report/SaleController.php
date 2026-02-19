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
use App\Order;
use DB;

class SaleController extends Controller
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
        return view('manager.report.sale', compact('categories'));
    }

    public function search()
    {
        $rules = array(
                'category_id' => 'required',
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $category_id = Input::get('category_id');
        $vegetable_id = Input::get('vegetable_id');
        $date = Input::get('date');
        // var_dump($category_id, $customer_id, $date); die();
        $req_to = date('Y/m/d', strtotime($date));

        if($category_id != ''){
            if($vegetable_id != ''){
                $query = Order::select(DB::raw('sum(`orders`.`calc_qty`) as qty_sum,orders.*'))
                ->where('vegetable_id',$vegetable_id)
                ->orderBy('id','DESC')->where('created_by', Auth::user()->id)
                ->groupBy('vegetable_id')
                ->get();
            }else{
                $query = Order::orderBy('id','DESC')->where('created_by', Auth::user()->id);
            }
            if($date !=''){
                $query = Order::select(DB::raw('sum(`orders`.`calc_qty`) as qty_sum,orders.*'))
                ->where('vegetable_id',$vegetable_id)
                ->orderBy('id','DESC')->where('created_by', Auth::user()->id)
                ->where('date','=',$req_to)
                ->groupBy('vegetable_id')
                ->get();
            }
            $customerquery = $query;
            $count=count($customerquery);
            return view('manager.report.sale-search', compact(['customerquery','req_to','count','date']));
        }
    }

    public function getSale()
    {
        $category_id = Input::get('category_id');
        $vegetables = Vegetable::where('category_id', $category_id)->pluck('id','display_name');
        return Response::json($vegetables);
    }

}