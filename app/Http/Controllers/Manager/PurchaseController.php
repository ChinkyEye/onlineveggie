<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;

use App\Category;
use App\Purchase;
use App\Purchase_has_out;
use App\Order;
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
        $date = date('Y/m/d');
        $purchases = Purchase::where('date',$date)->where('created_by', Auth::user()->id)->orderBy('id','DESC')->paginate(50);
        $sum = Purchase::where('date',date('Y/m/d'))->sum('total');
        $purchase_users = User::where('user_type','0')->where('type','2')->where('is_active','1')->pluck('id','email');
        // var_dump($purchase_users); die();
        $categories = Category::where('is_active','1')->pluck('id','name');
        return view('manager.purchase-view', compact('purchases','sum','purchase_users','categories','date'));
    }

    public function show(){
        $date = date('Y/m/d');
        $purchase_users = User::where('user_type','0')->where('type','2')->where('is_active','1')->pluck('id','email');
        $categories = Category::where('is_active','1')->pluck('id','name');
        // var_dump($categories); die();
        $units = Unit::where('is_active','1')->pluck('id','name');
        $purchases = Purchase::where('date',$date)->where('created_by', Auth::user()->id)->orderBy('id','DESC')->get();
        return view('manager.purchase-entry', compact('purchase_users','categories','units','purchases','date'));
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
        $date = date('Y/m/d', strtotime($from_date));
        // logical part here
        $purchases = Purchase::where('date',date('Y/m/d'))->where('created_by', Auth::user()->id)->orderBy('id','DESC');
        // $purchases = Purchase::where('date',date('Y/m/d'))->where('created_by', Auth::user()->id)->orderBy('id','DESC')->paginate(10);

        $sum = Purchase::where('date',date('Y/m/d'))->sum('total');

        $purchase_users = User::where('user_type','0')->where('type','2')->where('is_active','1')->pluck('id','email');
        // var_dump($purchase_users); die();
        $categories = Category::where('is_active','1')->pluck('id','name');
        $query = Purchase::orderBy('id','DESC')->where('created_by', Auth::user()->id);
            if($purchase_user_id != ""){
                $query->where('purchase_user_id', $purchase_user_id);
            }
            if($category_id != ""){
                $query->where('category_id', $category_id);
            }
            if($from_date !=''){
                $query->where('date','=',$date);
            }
            // var_dump($query); die();
            // $purchases = $query->get();
            $purchases = $query->paginate(10);
            // $count=count($purchases);
            // $purchases = Purchase::where('date',date('Y/m/d'))->where('created_by', Auth::user()->id)->orderBy('id','DESC')->paginate(10);
        return view('manager.purchase-view', compact('purchases','sum','purchase_users','categories','date'));
    }

    public function getCatVeg(){
        $category_id = Input::get('category_id');
        $display = Vegetable::where('category_id', $category_id)->get();
        return Response::json($display);
    }

    public function dateDetail(){
        $date = Input::get('dateseach');
        $name = Input::get('name');
        // $date = date('Y/m/d', strtotime($date));
        // var_dump($date, $name); die();
        $purchase_query = Purchase::where('created_by', Auth::user()->id)->orderBy('id','DESC');
        if($date != NULL){
            $purchase_query = $purchase_query->where('date',$date);
        }
        if($name != NULL){
            $purchase_query = $purchase_query->where('purchase_id','like','%'.$name.'%');
        }
        $purchases = $purchase_query->paginate(50);
        $sum = Purchase::where('date',date('Y/m/d'))->sum('total');
        $purchase_users = User::where('user_type','0')->where('type','2')->where('is_active','1')->pluck('id','email');
        // var_dump($purchase_users); die();
        $categories = Category::where('is_active','1')->pluck('id','name');
        return view('manager.purchase-view', compact('purchases','sum','purchase_users','categories','date'));
    }

    public function dateentryDetail(){
        $date = Input::get('dateseach');
        $date = date('Y/m/d', strtotime($date));
        $purchase_users = User::where('user_type','0')->where('type','2')->where('is_active','1')->pluck('id','email');
        $categories = Category::where('is_active','1')->pluck('id','name');
        $units = Unit::where('is_active','1')->pluck('id','name');
        $purchases = Purchase::where('date',$date)->where('created_by', Auth::user()->id)->orderBy('id','DESC')->get();
        return view('manager.purchase-entry', compact('purchase_users','categories','units','purchases','date'));
    }

    public function make_out(){
        $id = Input::get('id');
        // var_dump($id); die();
        $current_date = date("Y-m-d H:i:s");
        $user_id = Auth::user()->id;
        $purchase_out = Purchase::find($id);
        $purchase_out->is_out = '1';
        if($purchase_out->save()){
            $punit = Purchase::where('id', $id)->value('unit_id');
            $pweight = Purchase::where('id', $id)->value('weight');
            $pout = new Purchase_has_out;
            $pout->purchase_id = $id;
            $pout->unit_id = $punit;
            $pout->is_active = '1';
            $stock_wt = Order::where('purchase_id',$id)->where('created_by', Auth::user()->id)->where('is_cancle','0')->sum('quantity');
            // var_dump($id,$stock_wt); die();
            $out_val = round($pweight-$stock_wt,2);
            $pout->weight = $out_val;
            $pout->created_by = $user_id;
            $pout->created_at = $current_date;
            if($pout->save()){
                $response = array(
                                'status' => 'success',
                                'msg' => 'Successfully Changed',
                            );
            }
            else{
                $purchase_out->is_out = '0';
                $purchase_out->save();
                    $response = array(
                        'status' => 'failure',
                        'msg' => 'Change Unsuccessful',
                    );
                }
            }
            else{
                $response = array(
                        'status' => 'failure',
                        'msg' => 'Change Unsuccessful',
                    );
            }
        return Response::json($response);
    }
}
