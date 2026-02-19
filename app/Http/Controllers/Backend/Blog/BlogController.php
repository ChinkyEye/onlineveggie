<?php

namespace App\Http\Controllers\Backend\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Blog;
use App\Category;
use Auth;
use Response;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::get();
        return view('backend.blog.index',compact('blog'));
    }

    public function isActive($id){
        $blogs = Blog::find($id);
        // var_dump($blogs); die();
        $check = Blog::where('id',$id)->value('is_active');
        if($check == '1'){
            $blogs->is_active ="0";
        }
        else{
            $blogs->is_active ="1";
        }
        $blogs->update();
        return back()->withInput();
    }

    public function isSort()
    {
        $id = Input::get('id');
        $value = Input::get('value');
        $sort_ids = Blog::find($id);
        $sort_ids->sort_id = $value;
        if($sort_ids->save()){
          $response = array(
            'status' => 'success',
            'msg' => 'Successfully change',
          );
        }else{
          $response = array(
            'status' => 'failure',
            'msg' => 'Sorry the data could not be change',
          );
        }
        return Response::json($response);
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
        $blogs = new Blog;
        $blogs->title = Input::get('title');
        $blogs->st_paragraph = Input::get('st_paragraph');
        $blogs->lg_paragraph = Input::get('lg_paragraph');
        $image = Input::file('image');
        if($image != ""){

         $destinationPath = 'images/blog/'; // upload path
         $extension = $image->getClientOriginalExtension(); // getting image extension
         $fileName = md5(mt_rand()).'.'.$extension; // renameing image

         $image->move($destinationPath, $fileName); /*move file on destination*/
         $file_path = $destinationPath.'/'.$fileName;
         $blogs->image = $fileName;
        }
        $blogs->created_by = Auth::user()->id;
        if ($blogs->save()){
            $this->request->session()->flash('alert-success', 'Blog saved successfully!');
        }
        else{
            $this->request->session()->flash('alert-warning', 'Blog could not add!');
        }
        return back()->withInput();
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
        $blogs = Blog::where('id',$id)->get();
        return view('backend.blog.edit', compact('blogs'));
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
        $blogs = Blog::find($id);
        $blogs->title = Input::get('title');
        $blogs->st_paragraph = Input::get('st_paragraph');
        $blogs->lg_paragraph = Input::get('lg_paragraph');
        $image = Input::file('image');
        if($image != ""){

         $destinationPath = 'images/blog/'; // upload path
         $extension = $image->getClientOriginalExtension(); // getting image extension
         $fileName = md5(mt_rand()).'.'.$extension; // renameing image

         $image->move($destinationPath, $fileName); /*move file on destination*/
         $file_path = $destinationPath.'/'.$fileName;
         $blogs->image = $fileName;
        }
        $blogs->created_by = Auth::user()->id;
        $blogs->update();
        return redirect('/home/blog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogs = Blog::find($id);
        $blogs->delete();
        return redirect('home/blog');
    }
}
