<?php

namespace App\Http\Controllers\Backend\Manager;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;
use App\User;
use App\Branch;
use App\Address;
use App\Purchase;
use App\Category;
use App\Order;
use App\Vegetable;
use DB;

class HomeController extends Controller
{
    public function index($id)
    {
        $name = User::where('id', $id)->value('name');
        $branch_id = User::where('id', $id)->value('branch_id');
        $address_id = User::where('id', $id)->value('address_id');
        $branch = Branch::where('id', $branch_id)->value('name');
        $address = Address::where('id', $address_id)->value('name');
        return view('backend.manager.home', compact('id','name','branch','address'));
    }

    public function purchase($id){
        $name = User::where('id', $id)->value('name');
        $branch_id = User::where('id', $id)->value('branch_id');
        $address_id = User::where('id', $id)->value('address_id');
        $branch = Branch::where('id', $branch_id)->value('name');
        $address = Address::where('id', $address_id)->value('name');

        $purchases = Purchase::where('date',date('Y/m/d'))->orderBy('id','DESC')->where('created_by', $id)->paginate(50);
        $sum = Purchase::where('date',date('Y/m/d'))->where('created_by', $id)->sum('amount');
        $categories = Category::where('is_active','1')->pluck('id','name');

        return view('backend.manager.purchase', compact('id','name','branch','address','purchases','sum','categories'));
    }

    public function purchase_search($id)
    {
        $name = User::where('id', $id)->value('name');
        $branch_id = User::where('id', $id)->value('branch_id');
        $address_id = User::where('id', $id)->value('address_id');
        $branch = Branch::where('id', $branch_id)->value('name');
        $address = Address::where('id', $address_id)->value('name');

        $categories = Category::where('is_active','1')->pluck('id','name');

        $category_id = Input::get('category_id');
        $vegetable_id = Input::get('vegetable_id');
        $from_date = Input::get('from_date');
        $to_date = Input::get('to_date');
        // $sum = Purchase::where('date',date('Y/m/d'))->where('created_by', $id)->sum('amount');
        $sum = 20;
        $query = Purchase::orderBy('id','DESC')->where('created_by', $id);

        if($category_id != ""){
            $query->where('category_id', $category_id);
        }
        if($vegetable_id != ""){
            $query->where('vegetable_id', $vegetable_id);
        }
        if($from_date != ""){
            $query->where('date','>=', $from_date);
        }
        if($to_date != ""){
            $query->where('date','<=', $to_date);
        }

        $purchases = $query->paginate(50);
        return view('backend.manager.purchase-search', compact('id','name','branch','address','purchases','sum','categories'));
    }

    public function sales($id){
        $name = User::where('id', $id)->value('name');
        $branch_id = User::where('id', $id)->value('branch_id');
        $address_id = User::where('id', $id)->value('address_id');
        $branch = Branch::where('id', $branch_id)->value('name');
        $address = Address::where('id', $address_id)->value('name');
        $categories = Category::where('is_active','1')->pluck('id','name');

        $orders = Order::where('date',date('Y/m/d'))->orderBy('id','DESC')->where('created_by', $id)->paginate(50);

        return view('backend.manager.sales', compact('id','name','branch','address','categories','orders'));
    }

    public function sales_search($id){
        // var_dump($id); die();
        $name = User::where('id', $id)->value('name');
        $branch_id = User::where('id', $id)->value('branch_id');
        $address_id = User::where('id', $id)->value('address_id');
        $branch = Branch::where('id', $branch_id)->value('name');
        $address = Address::where('id', $address_id)->value('name');
        $categories = Category::where('is_active','1')->pluck('id','name');

        $category_id = Input::get('category_id');
        $vegetable_id = Input::get('vegetable_id');
        $from_date = Input::get('from_date');
        $to_date = Input::get('to_date');
        // $sum = Purchase::where('date',date('Y/m/d'))->where('created_by', $id)->sum('amount');
        $sum = 20;
        $query = Order::orderBy('id','DESC')->where('created_by', $id);
// var_dump($query->get()); die();
        // if($category_id != ""){
        //     $query->where('category_id', $category_id);
        // }
        if($vegetable_id != ""){
            $query->where('vegetable_id', $vegetable_id);
        }
        if($from_date != ""){
            $query->where('date','>=', $from_date);
        }
        if($to_date != ""){
            $query->where('date','<=', $to_date);
        }

        $orders = $query->paginate(50);
        // var_dump($orders); die();
        return view('backend.manager.sales-search', compact('id','name','branch','address','categories','orders'));
    }

    public function stock($id){
        $name = User::where('id', $id)->value('name');
        $branch_id = User::where('id', $id)->value('branch_id');
        $address_id = User::where('id', $id)->value('address_id');
        $branch = Branch::where('id', $branch_id)->value('name');
        $address = Address::where('id', $address_id)->value('name');
        $veggies = Vegetable::where('is_active','1')->pluck('id','display_name');
        return view('backend.manager.stock', compact('id','name','branch','address','veggies'));
    }

    public function stock_search($id){
        $name = User::where('id', $id)->value('name');
        $branch_id = User::where('id', $id)->value('branch_id');
        $address_id = User::where('id', $id)->value('address_id');
        $branch = Branch::where('id', $branch_id)->value('name');
        $address = Address::where('id', $address_id)->value('name');
        $veggies = Vegetable::where('is_active','1')->pluck('id','display_name');

        $vegetable_id = Input::get('vegetable_id');
        if($vegetable_id != ""){
            $query = Order::select(DB::raw('sum(`orders`.`calc_qty`) as qty_sum,orders.*'))
                ->where('vegetable_id',$vegetable_id)
                ->where('is_cancle','0')
                ->orderBy('id','DESC')->where('created_by', $id)
                ->groupBy('vegetable_id')
                ->get();
        }
        else{
            $query = Order::select(DB::raw('sum(`orders`.`calc_qty`) as qty_sum,orders.*'))
                ->orderBy('id','DESC')->where('created_by', $id)
                ->where('is_cancle','0')
                ->groupBy('vegetable_id')
                ->get();
        }
// var_dump($query); die();
        return view('backend.manager.stock-search', compact('id','name','branch','address','veggies','query'));
    }
}