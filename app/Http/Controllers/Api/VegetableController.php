<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Purchase;
use App\Purchase_has_manage;
use App\Category;
use App\Unit;
use App\Order;
use App\Order_total;
use App\Address;

class VegetableController extends Controller
{

	public function index(Request $request){
        $columns = array(
                        0 =>'id', 
                        1 =>'name',
                        2 =>'amount',
                        3 =>'image',
                        4 =>'category_id',
                    );
        $totalData = Purchase::where('is_active','1')->orderBy('id','asc')->count();
        $totalFiltered = $totalData; 
        $limit = empty($request->input('length'))?10:intval($request->input('length'));
        $start = empty($request->input('start'))?0:intval($request->input('start'));
        //$start = $request->input('start');
        //$limit = 2;
        //$start = 0;
        // $order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');
        $postsQ = Purchase::where('is_active','1')
                    ->whereHas('getPurchaseMin', function($query){
                           $query->where('is_active','1');
                    })
                    ->where('is_out','0')
                    ->offset($start)
                    ->limit($limit);

        if(!empty($request->input('q')))
        {
            $search = $request->input('q'); 
            $postsQ->where('purchase_id', 'LIKE',"%{$search}%");
        }
        if(!empty($request->input('cq')))
        {
            $cq = $request->input('cq'); 
            $postsQ->where('category_id',"=" ,$cq);
        }
        $posts = $postsQ->latest()->get();
        $totalFiltered = Purchase::where('is_active','1')
                            ->count();
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $index=>$post)
            {
                $nestedData['id'] = $post->id;
                $nestedData['vegetable_id'] = $post->vegetable_id;
                $nestedData['name'] = $post->getName->display_name;
                $nestedData['amount'] = $post->amount;
                $nestedData['image'] = $post->getName->image;
                $nestedData['category_id'] = $post->category_id;
                $nestedData['rates'] = [$post->getPurchaseMinLatest()->first(['id','unit_id','rate'])];
                $data[] = $nestedData;
            }
        }
        $json_data = array(
					"success" => true,
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        return response()->json($json_data); 
    }
	public function test(Request $request){
        $columns = array(
                        0 =>'id', 
                        1 =>'name',
                        2 =>'amount',
                        3 =>'image',
                        4 =>'category_id',
                    );
        $totalData = Purchase::where('is_active','1')->orderBy('id','asc')->count();
        $totalFiltered = $totalData; 
        $limit = empty($request->input('length'))?10:intval($request->input('length'));
        $start = empty($request->input('start'))?0:intval($request->input('start'));
        //$start = $request->input('start');
        //$limit = 2;
        //$start = 0;
        // $order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');
        $postsQ = Purchase::where('is_active','1')
                    ->whereHas('getPurchaseMin', function($query){
                           $query->where('is_active','1');
                    })
                    ->where('is_out','0')
                    ->offset($start)
                    ->limit($limit);

        if(!empty($request->input('q')))
        {
            $search = $request->input('q'); 
            $postsQ->where('purchase_id', 'LIKE',"%{$search}%");
        }
        if(!empty($request->input('cq')))
        {
            $cq = $request->input('cq'); 
            $postsQ->where('category_id',"=" ,$cq);
        }
        $posts = $postsQ->latest()->get();
        $totalFiltered = Purchase::where('is_active','1')
                            ->count();
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $index=>$post)
            {
                $nestedData['id'] = $post->id;
                $nestedData['vegetable_id'] = $post->vegetable_id;
                $nestedData['name'] = $post->getName->display_name;
                $nestedData['amount'] = $post->amount;
                $nestedData['image'] = $post->getName->image;
                $nestedData['category_id'] = $post->category_id;
                $nestedData['rates'] = [$post->getPurchaseMinLatest()->first(['id','unit_id','rate'])];
                $data[] = $nestedData;
            }
        }
        $json_data = array(
					"success" => true,
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        return response()->json($json_data); 
    }
    public function address(Request $request){
		$json_data = array(
			"success" => true,
			"addresses" => Address::select(['id','name'])->where('is_active',1)->get(),
		);
		return response()->json($json_data);
	}
    public function initialize(Request $request){
		$json_data = array(
			"success" => true,
			"units" => Unit::select(['id','name','parent_id'])->where('is_active',1)->get(),
			"categories" => Category::select(['id','name'])->where('is_active',1)->get(),
			"addresses" => Address::select(['id','name'])->where('is_active',1)->get(),
		);
		return response()->json($json_data);
	}
	
    public function orders(Request $request){
		$limit = empty($request->input('length'))?10:intval($request->input('length'));
        $start = empty($request->input('start'))?0:intval($request->input('start'));
		$current_user_id = Auth::user()->id;
		$orders = Order_total::select(['id','bill_id','total','discount','due','paid','date','raw_data','confirmed_at','bill_type','is_confirmed','is_deliverd','created_at','confirmed_at'])
					->where('customer_id',$current_user_id)
					//->where('order_by',$current_user_id)
					// ->where('bill_type',1)
					->offset($start)
                    ->limit($limit)
                    ->latest()->get();
		$json_data = array(
			"success" => true,
			"orders" => array(),
		);
		foreach($orders as $v){
			$order = $v->toArray();
			$order["orders"] = $v->orderDetail()->get();
			$json_data["orders"][] = $order;
		}
		return response()->json($json_data);
	}
	
    public function checkout(Request $request){
		$data = $request->getContent();
		//$data ='[{"vegetable":{"id":1,"name":"Aalu","amount":"20","image":"1578551398.png","category_id":1,"rates":[{"id":4,"unit_id":1,"rate":"18"}]},"phm_id":4,"unit_id":"1","total":1},{"vegetable":{"id":2,"name":"Saag","amount":"8","image":"1578551446.png","category_id":1,"rates":[{"id":3,"unit_id":2,"rate":"15"}]},"phm_id":3,"unit_id":"2","total":1}]';
		$data = json_decode($data);
		$current_date = date("Y/m/d");
		$bill_id = strtotime(date("Y-m-d H:i:s")); // may need to add few more bits?
		$total = 0;
		$processed_order = [];
		$processed_status = "Your order was processed and you will get a call for confirmation";
		foreach($data as $order){
			if($order->total < 0){
				// not all orders were processed correctly
				$processed_status = "Your order was processed with some failure, you will get a call for confirmation!!";
				continue;
			}
			$phm_id = $order->phm_id;
			$phm = Purchase_has_manage::find($phm_id); // yesari nai hola ni khojne?
			// check if this phm exists? and is active
			$order->total = ceil($order->total * 100)/100;
			$rate = $phm->rate;
			$yesko_total = $rate * $order->total;
			$total += $yesko_total;
			
			$processed_order[] = $order;
		}
		if(count($processed_order) == 0){
			$processed_status = "Your order had impurities so cannot be processed!!!";
		}
		if(count($processed_order)>0){
			$current_user_id = Auth::user()->id;
			// both user and customer is same
			// we now have
			// bill_id, total, discount=0, due=0, grand_total = $total,customer_id,date,created_by
			// store new ORDER_TOTAL
			$order_total = new Order_total;
			$order_total->bill_id = $bill_id;
			$order_total->total = $total;
			$order_total->paid = $total;
			$order_total->customer_id = $current_user_id;
			$order_total->date = $current_date;
			$order_total->created_by = $current_user_id;
			$order_total->order_by = $current_user_id;
			$order_total->raw_data = json_encode($processed_order);
			$order_total->bill_type = '1';
			$order_total->save();
			
			foreach($processed_order as $order){
				$phm_id = $order->phm_id;
				$phm = Purchase_has_manage::find($phm_id); // yesari nai hola ni khojne?
				$rate = $phm->rate;
				$yesko_total = $rate * $order->total;
				$unit_id = intval($order->unit_id);
				$purchase_id = $phm->purchase_id;
				$vegetable_id = intval($order->vegetable->vegetable_id);
				// purchase_id, purchase_manage_id, ORDER_TOTAL_ID = ID after we save, vegetable_id, user_id, bill_id, quantity = $order->total, rate, total = yesko_total, unit_id,date, create_by, order_by [missing: calc_qty, calc_unit_id, must be same as unit_id and qty]
				$orderO = new Order;
				$orderO->purchase_id = $purchase_id;
				$orderO->purchase_manage_id = $phm_id;
				$orderO->order_total_id = $order_total->id;
				$orderO->vegetable_id = $vegetable_id;
				$orderO->user_id = $current_user_id;
				$orderO->bill_id = $bill_id;
				$orderO->quantity = $order->total;
				$orderO->rate = $rate;
				$orderO->total = $yesko_total;
				$orderO->unit_id = $order->unit_id;
				$orderO->calc_qty = $order->total;
				$orderO->calc_unit_id = $order->unit_id;
				$orderO->date = $current_date;
				$orderO->created_by = $current_user_id;
				$orderO->order_by = $current_user_id;
				$orderO->save();
			}
		}
		// now we have an array
		$json_data = array(
			"success" => true,
			"message" => $processed_status
		);
		return response()->json($json_data);
	}
}
