<?php

namespace App\Http\Controllers\Backend\Slider;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Validator;
use Auth;
use App\Slider;
use Response;


class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Slider::orderby('sort_id','asc')->get();
        return view('backend.slider.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function isActive($id){
        $sliders = Slider::find($id);
        // var_dump($sliders); die();
        $check = Slider::where('id',$id)->value('is_active');
        if($check == '1'){
            $sliders->is_active ="0";
        }
        else{
            $sliders->is_active ="1";
        }
        $sliders->update();
        return back()->withInput();
    }

    public function isSort()
    {
        $id = Input::get('id');
        $value = Input::get('value');
        $sort_ids = Slider::find($id);
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

    public function inApp($id){
        $sliders = Slider::find($id);
        $check = Slider::where('id',$id)->value('is_app');
        if($check == '0'){
            $sliders->is_app = "1";
        }
        else{
            $sliders->is_app = '0';
        }
        $sliders->update();
        return back()->withInput();
    }

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
            'title' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator)
            ->withInput();
        }
        $sliders = new Slider;
        $sliders->title = Input::get('title');
        $sliders->slug = Input::get('title');
        $image = Input::file('image');
        if($image != ""){

         $destinationPath = 'images/slider/'; // upload path
         $extension = $image->getClientOriginalExtension(); // getting image extension
         $fileName = md5(mt_rand()).'.'.$extension; // renameing image

         $image->move($destinationPath, $fileName); /*move file on destination*/
         $file_path = $destinationPath.'/'.$fileName;
         $sliders->image = $fileName;
         // $sliders->image = $image->getClientOriginalName();
        }
        $sliders->created_by = Auth::user()->id;
        $sliders->updated_by = Auth::user()->id;
        if ($sliders->save()){
            $this->request->session()->flash('alert-success', 'Slider saved successfully!');
        }
        else{
            $this->request->session()->flash('alert-warning', 'Slider could not add!');
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
        $sliders = Slider::where('id',$id)->get();
        return view('backend.slider.edit',compact('sliders'));
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
        $sliders = Slider::find($id);
        $sliders->title = Input::get('title');
        $sliders->slug = Input::get('title');
        $image = Input::file('image');
        if($image != ""){

         $destinationPath = 'images/slider/'; // upload path
         $extension = $image->getClientOriginalExtension(); // getting image extension
         $fileName = md5(mt_rand()).'.'.$extension; // renameing image

         $image->move($destinationPath, $fileName); /*move file on destination*/
         $file_path = $destinationPath.'/'.$fileName;
         $sliders->image = $fileName;
         // $sliders->image = $image->getClientOriginalName();
        }
        $sliders->created_by = Auth::user()->id;
        $sliders->updated_by = Auth::user()->id;
        if ($sliders->update()){
            $this->request->session()->flash('alert-success', 'Slider updated successfully!');
        }
        else{
            $this->request->session()->flash('alert-warning', 'Slider could not update!');
        }
        return redirect('home/slider');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sliders = Slider::find($id);
        $sliders->delete();
        return back()->withInput();
    }
}
