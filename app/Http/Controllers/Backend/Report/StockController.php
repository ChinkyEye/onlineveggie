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
use App\Category;
use App\Vegetable;
use App\Order;
use DB;

class StockController extends Controller
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
        return view('backend.report.stock', compact('categories'));
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

        if($category_id != ''){
            if($vegetable_id != ''){
                $query = Order::select(DB::raw('sum(`orders`.`calc_qty`) as qty_sum,orders.*'))
                ->where('vegetable_id',$vegetable_id)
                ->where('is_cancle','0')
                ->orderBy('id','DESC')
                ->groupBy('vegetable_id','created_by')
                ->get();
                // var_dump($query); die();
            }else{
                $query = Order::orderBy('id','DESC')->where('is_cancle','0');
            }
            $customerquery = $query;
            $count=count($customerquery);
            return view('backend.report.stock-search', compact(['customerquery','count']));
        }
    }

    public function getVegetable()
    {
        $category_id = Input::get('category_id');
        $vegetables = Vegetable::where('category_id', $category_id)->pluck('id','display_name');
        return Response::json($vegetables);
    }

}