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
use App\Purchase;
use App\Purchase_has_out;
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
        return view('manager.report.stock', compact('categories'));
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
        $item_id = Input::get('item_id');
        // var_dump($category_id, $customer_id); die();

        if($category_id != ''){
            if($vegetable_id != ''){
                $query = Order::select(DB::raw('sum(`orders`.`calc_qty`) as qty_sum,orders.*'))
                ->where('vegetable_id',$vegetable_id)
                ->where('purchase_id',$item_id)
                ->where('is_cancle','0')
                ->orderBy('id','DESC')->where('created_by', Auth::user()->id)
                ->groupBy('vegetable_id','purchase_id')
                ->get();
                $out = Purchase_has_out::where('purchase_id', $item_id)->where('created_by', Auth::user()->id)->value('weight');
                // var_dump($query); die();
            }else{
                $query = Order::orderBy('id','DESC')->where('created_by', Auth::user()->id)->where('is_cancle','0');
                $out = False;
            }
            $customerquery = $query;
            $count=count($customerquery);
            return view('manager.report.stock-search', compact(['customerquery','count','out']));
        }
    }

    public function getVegetable()
    {
        $category_id = Input::get('category_id');
        $vegetables = Vegetable::where('category_id', $category_id)->pluck('id','display_name');
        return Response::json($vegetables);
    }
    public function getItem()
    {
        $category_id = Input::get('category_id');
        $vegetable_id = Input::get('vegetable_id');
        $items = Purchase::where('category_id', $category_id)->where('vegetable_id', $vegetable_id)->pluck('id','purchase_id');
        return Response::json($items);
    }

}