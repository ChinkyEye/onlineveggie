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

class CategoryController extends Controller
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
        return view('manager.category');
    }

    public function getAllCategory(Request $request){
        $columns = array(
                        0 =>'id', 
                        1 =>'name',
                        2 =>'created_by',
                        3 =>'created_at',
                        4 =>'action',
                    );
        $totalData = Category::where('is_active','1')->orderBy('id','desc')->count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = Category::where('is_active','1')
                        ->orderBy('id','desc')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 
            $posts =  Category::where('name', 'LIKE',"%{$search}%")
                            ->where('is_active','1')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Category::where('is_active','1')
                            ->where('name', 'LIKE',"%{$search}%")
                            ->count();
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $index=>$post)
            {
                $nestedData['id'] = $index+1;
                $nestedData['name'] = "<a href='category/$post->slug'>$post->name</a>".' '.'('.$post->getCategoryCount()->count().')';
                $nestedData['created_by'] = $post->getUser->name;
                $nestedData['created_at'] = date("D, j M Y", strtotime($post->created_at)).' '.'<span class="text-primary badge badge-warning">'.$post->created_at->diffForHumans().'</span>';
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

    public function store(){
        $rules = array(
            'name' => 'required|unique:categories',
        );
        $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $current_date = date("Y-m-d H:i:s");
        $user_id = Auth::user()->id;
        $category = new Category;
        $category->name = Input::get('name');
        $category->slug = strtolower(Input::get('name'));
        $category->is_active = '1';
        $category->created_by = $user_id;
        $category->created_at = $current_date;
    if ($category->save()){
            $this->request->session()->flash('alert-success', 'Category saved successfully!');
        }
    else{
        $this->request->session()->flash('alert-warning', 'Category could not add!');
    }
    return back()->withInput();
    }

    public function detail($slug){
        $cat_id = Category::where('slug',$slug)->value('id');
        $category = Category::where('slug',$slug)->value('name');
        return view('manager.category-detail', compact('cat_id','slug','category'));
    }

    public function getAllCategoryDetail(Request $request){
        $cat_id = Input::get('cat_id');
        $columns = array(
                        0 =>'id', 
                        1 =>'display_name',
                        2 =>'date',
                        3 =>'weight',
                        4 =>'amount',
                        5 =>'total',
                        6 =>'created_by',
                    );
        $totalData = Purchase::where('is_active','1')->where('category_id', $cat_id)->orderBy('id','asc')->count();
        // var_dump($totalData); die();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = Purchase::where('is_active','1')
                        ->where('category_id', $cat_id)
                        ->orderBy('id','desc')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 
            $posts =  Purchase::where('name', 'LIKE',"%{$search}%")
                            ->where('is_active','1')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Purchase::where('is_active','1')
                            ->where('name', 'LIKE',"%{$search}%")
                            ->where('category_id', $cat_id)
                            ->count();
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $index=>$post)
            {
                $nestedData['id'] = $index+1;
                $nestedData['display_name'] = $post->getName->display_name;
                $nestedData['date'] = date("D, j M Y", strtotime($post->date)).' '.'<span class="text-primary badge badge-warning">'.$post->created_at->diffForHumans().'</span>';
                $nestedData['weight'] = $post->weight .'('.$post->getUnit->name.')';
                $nestedData['amount'] = 'Rs: '.$post->amount;
                $nestedData['total'] = 'Rs: '.$post->total;
                $nestedData['created_by'] = $post->getUser->name;
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
}
