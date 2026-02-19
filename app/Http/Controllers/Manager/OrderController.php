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
use App\Unit_has_convert;
use App\User;
use App\Purchase;
use App\Purchase_has_manage;
use App\Order;
use App\Order_total;
use App\Vegetable;
use Redirect;
use View;

class OrderController extends Controller
{
    public function index()
    {
        $units = Unit::where('is_active','1')->orderBy('id','DESC')->pluck('id','name');
        $users = User::where('is_active','1')->where('type','1')->where('user_type','0')->orderBy('id','DESC')->pluck('id','email');
        $items = Purchase::where('is_active','1')->where('is_out','0')->where('created_by', Auth::user()->id)
            ->whereHas('getPurchaseMinLatest', function($query){
                   $query->where('is_active','1');
            })->pluck('id','purchase_id');
        return view('manager.order', compact('units','users','items'));
    }

    public function store(Request $request){
            $current_date = date("Y/m/d");
            $current_y = date("Y");
            $current_m = date("m");
            $current_d = date("d");
            // var_dump($current_date, $current_y, $current_m, $current_d);
        $rules = array(
                'customer_id' => 'required',
                'grand_total' => 'required',
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }

        $data = Input::all();

        $current_user_id = Auth::user()->id;

        $customer_id = Input::get('customer_id');
        
        $item_id = Input::get('item_id');
        $unit_id = Input::get('unit_id');
        $veg_id = Input::get('veg_id');
        $convert_qty = Input::get('convert_qty');


        $quantity_name = Input::get('quantity_name');
        $new_rate = Input::get('new_rate');
        $total_name = Input::get('total_name');
        

        $total = Input::get('total');
        $discount = Input::get('discount');
        $paid = Input::get('paid');
        $due = Input::get('due');
        $grand_total = Input::get('grand_total');
        $back_return = Input::get('back_return');
        $bill_id = strtotime(date("Y-m-d H:i:s"));
        // var_dump($bill_id); die();

        $order_total = new Order_total;
        $order_total->bill_id = $bill_id;
        $order_total->total = $total;
        $order_total->paid = $paid;
        $order_total->return_back = $back_return;
        $order_total->grand_total = $grand_total;
        $order_total->customer_id = $customer_id;
        $order_total->date = $current_date;

        if($due == '' || $due == '0'){
            $order_total->due = '0';
            $order_total->is_due = '0';
        }
        else{
            $order_total->due = $due;
            $order_total->is_due = '1';
        }
        if($discount == '' || $discount == '0'){
            $order_total->discount = '0';
        }
        else{
            $order_total->discount = $discount;
        }
        $order_total->created_by = $current_user_id;
        $order_total->order_by = $current_user_id;
        $order_total->is_seen = '1';
        $order_total->is_confirmed = '1';
        $order_total->is_deliverd = '1';
        $order_total->bill_type = '0';
        if($order_total->save()){
            foreach ($item_id as $key => $item) {
                    $order = new Order;
                    $order->purchase_id = $item_id[$key];
                    $purchase_manage_id = Purchase_has_manage::where('purchase_id', $item_id[$key])->where('unit_id', $unit_id[$key])->value('id');

                    $calc_unit = Purchase::where('id',$item_id[$key])->value('unit_id');
                    $getUnit_id = $unit_id[$key];
                    
                    $order->calc_qty = $quantity_name[$key];
                    // $convert_qty[$key];
                    $order->calc_unit_id = $calc_unit;

                    $order->order_total_id = $order_total->id;
                    $order->bill_id = $bill_id;
                    $order->user_id = $customer_id;
                    $order->quantity = $quantity_name[$key];
                    $order->rate = $new_rate[$key];
                    $order->total = $total_name[$key];
                    $order->unit_id = $unit_id[$key];
                    $order->vegetable_id = $veg_id[$key];
                    $order->purchase_manage_id = '1';
                    $order->created_by = $current_user_id;
                    $order->order_by = $current_user_id;
                    $order->date = $current_date;
                    if ($order->save()){
                            $this->request->session()->flash('alert-success', 'Order confirmed successfully!');
                        }
                    else{
                        $this->request->session()->flash('alert-warning', 'Order could not confirmed!');
                    }
            }
            return Redirect::route('print_bill', ['id' => $bill_id]);
        }
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

    public function getItemList(){
        $item_id = Input::get('item_id');
        // var_dump($item_id); die();
        $quantity = Input::get('quantity');
        $num_x = Input::get('num_x');
        $unit_id= Input::get('unit_id');
        $customer_id = Input::get('customer_id');
        // var_dump($item_id, $unit_id); die();
        $new_rate = Purchase_has_manage::orderBy('id','DESC')->where('purchase_id', $item_id)->where('created_by', Auth::user()->id)->where('unit_id', $unit_id)->value('rate');
        $veg_id = Purchase::where('id', $item_id)->value('vegetable_id');
        $display_name = Vegetable::where('id', $veg_id)->value('display_name');
        $unit_name = Unit::where('id', $unit_id)->value('name');

        $calc_unit = Purchase::where('id',$item_id)->value('unit_id');
        $convert_rate = Unit_has_convert::where('unit_id', $unit_id)->where('convert_unit_id', $calc_unit)->value('convert_rate');
        $convert_qty = $quantity*$convert_rate;
        
        $total_items = $quantity * $new_rate;
        
        $data = array('rest' => $display_name,'new_rate' => $new_rate,'quantity' => $quantity,'total_items' => $total_items,'num_x'=>$num_x,'unit' => $unit_name,'customer_id' => $customer_id,'item_id' => $item_id,'unit_id' => $unit_id,'veg_id' => $veg_id,'convert_qty'=>$convert_qty);

        return View::make('manager.order_row', $data);
    }

    public function getItemCalculation(){
        $response= array();
        $total = Input::get('total');
        if(!empty($total)){
            $total = array_sum($total);
            $response['total'] = $total;
            return View::make('manager.order_calculation')->with('calc_data',$response);          
        }
    }

    public function getItemUnit(){
        $item_id = Input::get('item_id');
        // var_dump($item_id); die();
        $units = Purchase_has_manage::where('purchase_id', $item_id)->groupBy('unit_id')->with('getUnit')->get();
        return Response::json($units);
    }
}