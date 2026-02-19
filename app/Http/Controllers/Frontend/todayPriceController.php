<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Purchase;
use App\Purchase_has_manage;
use App\Cart;
use Auth;

class todayPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct(Request $request)
    // {
    //     $this->middleware('auth');
    //     $this->request = $request;
    // }

    public function index()
    {
        //
    }

     public function todayPrice(){
        $carts = Cart::get();
        // $carts = Cart::where('created_by',Auth::user()->id)->get();
        $carts = Cart::where('created_by',Auth::user() ? Auth::user()->id : null)->get();
        $data_lists = Purchase::where('is_active','1')
                    ->whereHas('getPurchaseMin', function($query){
                           $query->where('is_active','1');
                    })
                    ->where('is_out','0')
            ->orderBy('category_id','DESC')
            ->paginate(42);
        return view('frontend.today-price.index',compact('data_lists','carts'));

//         if($lang == 'en'){
// // var_dump($data_lists); die();
//         return view('manager.stock.index',compact('data_lists'));
//         }
//         elseif ($lang == 'plain') {
//             return view('manager.stock.plain',compact('data_lists'));
//         }
//         else{
//         return view('manager.stock.index_np',compact('data_lists'));
//         }
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
