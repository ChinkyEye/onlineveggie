<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;

use App\User;
use App\Order_total;
use App\Address;

class CustomerCreditController extends Controller
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
        $addresses = Address::pluck('id','name');
        // var_dump($addresses); die();
        return view('manager.customer-creditor', compact('addresses'));
    }

    public function getAllCreditor(Request $request){
        $columns = array(
                        0 =>'id', 
                        1 =>'name',
                        2 =>'email',
                        3 =>'phone_no',
                        4 =>'created_at',
                        5 =>'created_by',
                        6 =>'action',
                    );
        $totalData = User::where('user_type','0')
                        ->where('type','1')->orderBy('id','asc')->count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = User::where('user_type','0')
                        ->where('type','1')
                        ->where('is_active','1')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 
            $posts =  User::where('name', 'LIKE',"%{$search}%")
                            ->where('user_type','0')
                            ->where('type','1')
                            ->where('is_active','1')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = User::where('user_type','0')
                            ->where('type','1')
                            ->where('is_active','1')
                            ->where('name', 'LIKE',"%{$search}%")
                            ->count();
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $index=>$post)
            {
                $nestedData['id'] = $index+1;
                $nestedData['name'] = "<a href='customer-creditor/$post->id'>$post->name</a>";
                $nestedData['email'] = $post->email;
                $nestedData['phone_no'] = $post->phone_no;
                $nestedData['created_at'] = date("D, j M Y", strtotime($post->created_at)).' '.'<span class="text-primary badge badge-info">'.$post->created_at->diffForHumans().'</span>';
                $nestedData['created_by'] = " ";
                // $nestedData['created_by'] = $post->getUser->name;
                $nestedData['action'] = "<a href='javascript:void(0);' class='edit_category' data-target='#edit_category' data-toggle='modal'><span><i class='fa fa-pencil-square-o edit_category' id='$post->id'></i></span></a> 
                    | 
                    <a class='delete_category' id='category' href='javascript:void(0)'><span class='delete_category' id='category'><i class='fa fa-times' id='$post->id'></i></span></a>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        echo json_encode($json_data); 
    }

    public function creditor_store(){
        $rules = array(
            'name' => 'required',
            // 'email' => 'required|string|email|max:255|unique:users',
            'phone_no' => 'required|unique:users',
            'address' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $current_date = date("Y-m-d H:i:s");
        $user_id = Auth::user()->id;
        $user = new User;
        $user->name = Input::get('name');
        $email = Input::get('email');
        $phone = Input::get('phone_no');
        if($email){
            $user->email = $email;
        }
        else{
            $user->email = $phone;
        }
        $user->password = bcrypt(Input::get('phone_no'));
        $user->phone_no = Input::get('phone_no');
        $user->address_id = Input::get('address');
        $user->branch_id = '1';
        $user->user_type = '0';
        $user->type = '1';
        $user->is_active = '1';
        $user->created_by = $user_id;
        $user->created_at = $current_date;
        if ($user->save()){
            $this->request->session()->flash('alert-success', 'Creditor Customer saved successfully!');
            }
        else{
            $this->request->session()->flash('alert-warning', 'Creditor Customer could not add!');
        }
        return back()->withInput();
    }

    public function customer_creditor_detail($id){
        $user_details = Order_total::where('customer_id', $id)->orderBy('id','DESC')->get();
        $name = User::where('id', $id)->select('name','phone_no')->get();
        return view('manager.customer-creditor-detail', compact('user_details','name'));
    }
}
