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
use App\Vegetable;

class VegetableController extends Controller
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
        return view('backend.vegetable', compact('categories'));
    }

    public function getAllVegetable(Request $request){
        $columns = array(
                        0 =>'id', 
                        1 =>'display_name',
                        2 => 'category_id',
                        3 => 'image',
                        4 =>'created_by',
                        5 =>'created_at',
                        6 =>'action',
                    );
        $totalData = Vegetable::where('is_active','1')->orderBy('id','desc')->count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = Vegetable::where('is_active','1')
                        ->orderBy('id','desc')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 
            $posts =  Vegetable::where('display_name', 'LIKE',"%{$search}%")
                            ->where('is_active','1')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Vegetable::where('is_active','1')
                            ->where('display_name', 'LIKE',"%{$search}%")
                            ->count();
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $index=>$post)
            {
                $nestedData['id'] = $index+1;
                $nestedData['display_name'] = "<a href='vegetable/$post->slug'>$post->display_name</a>".' '.'('.$post->getVegetableCountAdmin()->count().')';
                $nestedData['category_id'] = $post->getCategory->name;
                $nestedData['image'] = $post->image;
                $nestedData['created_by'] = $post->getUser->name;
                $nestedData['created_at'] = date("Y/M/D H:i", strtotime($post->created_at)).' '.'<span class="text-primary badge badge-warning">'.$post->created_at->diffForHumans().'</span>';
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

    public function store(Request $request){
        $rules = array(
            'display_name' => 'required|unique:vegetables',
            'category_id' => 'required',
            'image' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $current_date = date("Y-m-d H:i:s");
        $user_id = Auth::user()->id;
        $category = new Vegetable;
        $category->display_name = Input::get('display_name');
        $category->slug = strtolower(Input::get('display_name'));
        $category->category_id = Input::get('category_id');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/vegetable');
            $image->move($destinationPath, $name);
            $category->image = $name;
        }
        $category->is_active = '1';
        $category->created_by = $user_id;
        $category->created_at = $current_date;
    if ($category->save()){
            $this->request->session()->flash('alert-success', 'Vegetable saved successfully!');
        }
    else{
        $this->request->session()->flash('alert-warning', 'Vegetable could not add!');
    }
    return back()->withInput();
    }
}