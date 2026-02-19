<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Slider;
use App\Category;
use App\Vegetable;
use App\Purchase;
use App\Cart;
use App\Order_total;
use App\Order;
use App\User;
use Auth;
use Hash;
use Response;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::where('created_by',Auth::user() ? Auth::user()->id : null)->where('status','1')->get();
        $vegetables = Vegetable::get();
        $categories = Category::get();
        $sliders = Slider::where('is_active','1')->get();
        $data_lists = Purchase::where('is_active','1')
                    ->whereHas('getPurchaseMin', function($query){
                           $query->where('is_active','1');
                    })
                    ->where('is_out','0')
            ->orderBy('category_id','DESC')
            ->get();
        return view('frontend.welcome',compact('sliders','categories','vegetables','data_lists','carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function myOrder()
    {
        $carts = Cart::where('created_by',Auth::user()->id)->where('status','1')->get();
        $orders = Order_total::where('order_by',Auth::user()->id)->orderBy('id','DESC')->get();
        return view('frontend.my-order', compact('carts','orders'));
    }

    public function orderShow($id){
        $carts = Cart::where('created_by',Auth::user()->id)->get();
        $orders = Order::where('bill_id',$id)->get();
        return view('frontend.ordershow',compact('carts','orders'));
    }




    public function changePassword(){
        $carts = Cart::get();
        return view('frontend.changepassword',compact('carts'));
    }



    public function changePasswordStore(){
        $rules = array(
           'old_password' => 'required',
           'new_password' => 'required|min:8',
           'confirm_password' => 'required|same:new_password',
       );

       $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
        return back()->withInput()
        ->withErrors($validator)
        ->withInput();
        }
        if (Auth::check()) 
        {
            $current_date = date("Y-m-d H:i:s");
            $user_id = Auth::user()->id;
            $user_p_id = User::find($user_id);
            $curr_user_pass = $user_p_id['password'];
            $old_password = Input::get('old_password');
            $new_password = Input::get('new_password');
            if (Hash::check($old_password, $curr_user_pass)) {
                       $user_p_id->fill([
                           'password' => Hash::make($new_password)
                       ])->save();
            $this->request->session()->flash('alert-success', 'Password changed successfully!');
            }
            else{
            $this->request->session()->flash('alert-danger', 'Password couldnot successfully!');
            }
            return back();
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
