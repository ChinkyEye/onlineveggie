<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Auth;
use Response;
use App\Purchase;
use App\Purchase_has_manage;
use App\Vegetable;
use App\Cart;
use App\Order;
use App\Order_total;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $carts = Cart::where('created_by',$user_id)->where('status','1')->get();
        return view('frontend.cart.show',compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'purchase_manage_id' => 'required',
            'quantity' => 'required',
        );
        $validator = Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $user_id = Auth::user()->id;
        $carts = new Cart;
        // $carts->purchase_id = Input::get('purchase_id');
        $purchase_manage_id = Input::get('purchase_manage_id');
        $carts->purchase_manage_id = $purchase_manage_id;
        $purchase_id = Purchase_has_manage::where('id', $purchase_manage_id)->value('purchase_id');
        // var_dump($id); die();
        $carts->purchase_id = $purchase_id;
        $carts->quantity = Input::get('quantity');
        $carts->created_by = $user_id;
        $carts->save();
        return response()->json($carts);
        // return back()->withInput();
    }



    public function proceed(Request $request){

        $carts = Cart::where('created_by',Auth::user()->id)
                ->where('status','1')->get();

        $date = date("Y-m-d");
        $bill_id = strtotime(date(("Y-m-d H:i:s")));
        $auth = Auth::user()->id;


        // var_dump($carts);
        // die();


        $total = 0;
        foreach ($carts as $key => $ordtotval) {
                    $purchase_id = $ordtotval->purchase_id;
                    $purchase_manage_id = $ordtotval->purchase_manage_id;
                    $vegetable_id = Purchase::where('id', $purchase_id)->value('vegetable_id');
                    $quantity = $ordtotval->quantity;
                    $rate = Purchase_has_manage::where('id', $purchase_manage_id)->value('rate');
                    $total += $quantity * $rate;
                } 


                $order_total = new Order_total;
                $order_total->bill_id = $bill_id;
                $order_total->total = $total;
                $order_total->paid = $total;
                $order_total->customer_id = $auth;
                $order_total->date = $date;
                $order_total->created_by = $auth;
                $order_total->order_by = $auth;
                $order_total->raw_data = NULL;
                $order_total->bill_type = '2'; // 0 for manager, 1 for app, 2 website
                $order_total->save();

        foreach ($carts as $key => $ordval) {
                    $purchase_id = $ordval->purchase_id;
                    $purchase_manage_id = $ordval->purchase_manage_id;
                    $vegetable_id = Purchase::where('id', $purchase_id)->value('vegetable_id');
                    $quantity = $ordval->quantity;
                    $rate = Purchase_has_manage::where('id', $purchase_manage_id)->value('rate');
                    $total=$quantity * $rate;

                    $unit_id = Purchase_has_manage::where('id',$purchase_manage_id)->value('unit_id');

                    $order = new Order;
                    $order->purchase_id = $purchase_id;
                    $order->purchase_manage_id = $ordval->purchase_manage_id;
                    $order->order_total_id = $order_total->id;
                    $order->vegetable_id = $vegetable_id;
                    $order->user_id = $auth;
                    $order->bill_id = $bill_id;
                    $order->quantity = $quantity;
                    $order->rate = $rate;
                    $order->total =$total;
                    $order->unit_id = $unit_id;
                    $order->calc_qty = $quantity;
                    $order->calc_unit_id = $unit_id;
                    $order->date = $date;
                    $order->created_by = $auth;
                    $order->order_by = $auth;
                    $order->updated_by = $auth;
                    if ($order->save()){
                        Cart::where('created_by',Auth::user()->id)->where('status','1')->update(['status' => '0']);
                            // $this->request->session()->flash('alert-success', 'Order confirmed successfully!');
                        }
                    else{
                        $this->request->session()->flash('alert-warning', 'Order could not confirmed!');
                    }
                }
                    return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carts = Cart::find($id);
        $carts->delete();
        return response()->json($carts);
        // return back()->withInput();
    }
}
