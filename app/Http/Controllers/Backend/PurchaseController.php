<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;

use App\Category;
use App\Purchase;
use App\Vegetable;
use App\User;
use App\Unit;

class PurchaseController extends Controller
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
        $purchases = Purchase::where('date',date('Y/m/d'))->orderBy('id','DESC')->paginate(10);
        $sum = Purchase::where('date',date('Y/m/d'))->sum('amount');
        $purchase_users = User::where('user_type','0')->where('type','2')->where('is_active','1')->pluck('id','email');
        // var_dump($purchase_users); die();
        $categories = Category::where('is_active','1')->pluck('id','name');
        return view('backend.purchase-view', compact('purchases','sum','purchase_users','categories'));
    }

    public function show(){
        $purchase_users = User::where('user_type','0')->where('type','2')->where('is_active','1')->pluck('id','email');
        // var_dump($purchase_users); die();
        $categories = Category::where('is_active','1')->pluck('id','name');
        $units = Unit::where('is_active','1')->pluck('id','name');
        $purchases = Purchase::where('date',date('Y/m/d'))->orderBy('id','DESC')->get();
        return view('backend.purchase-entry', compact('purchase_users','categories','units','purchases'));
    }

    public function store(Request $request){
        $rules = array(
            'purchase_user_id' => 'required',
            'category_id' => 'required',
            'vegetable_id' => 'required',
            'date' => 'required',
            'purchase_id' => 'required',
            'weight' => 'required',
            'amount' => 'required',
            'unit_id' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $current_date = date("Y-m-d H:i:s");
        $user_id = Auth::user()->id;
        $purchase = new Purchase;
        $purchase->purchase_id = Input::get('purchase_id');
        $purchase->date = Input::get('date');
        $purchase->weight = Input::get('weight');
        $purchase->amount = Input::get('amount');
        $purchase->total = Input::get('total');
        $purchase->vegetable_id = Input::get('vegetable_id');
        $purchase->purchase_user_id = Input::get('purchase_user_id');
        $purchase->category_id = Input::get('category_id');
        $purchase->unit_id = Input::get('unit_id');
        $purchase->is_active = '1';
        $purchase->created_by = $user_id;
        $purchase->created_at = $current_date;
    if ($purchase->save()){
            $this->request->session()->flash('alert-success', 'Purchase saved successfully!');
        }
    else{
        $this->request->session()->flash('alert-warning', 'Purchase could not add!');
    }
    return back()->withInput();
    }

    public function search(){
        // var_dump("expression"); die();
        $purchase_user_id = Input::get('purchase_user_id');
        $category_id = Input::get('category_id');
        $from_date = Input::get('from_date');
        $to_date = Input::get('to_date');
        // logical part here
        $purchases = Purchase::where('date',date('Y/m/d'))->orderBy('id','DESC')->get();
        $sum = Purchase::where('date',date('Y/m/d'))->sum('amount');
        $purchase_users = User::where('user_type','0')->where('type','2')->where('is_active','1')->pluck('id','email');
        $categories = Category::where('is_active','1')->pluck('id','name');
        return view('backend.purchase-view', compact('purchases','sum','purchase_users','categories'));
    }

    public function getCatVeg(){
        $category_id = Input::get('category_id');
        $display = Vegetable::where('category_id', $category_id)->get();
        return Response::json($display);
    }
}
