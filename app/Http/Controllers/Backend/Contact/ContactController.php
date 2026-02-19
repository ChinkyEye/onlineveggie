<?php

namespace App\Http\Controllers\Backend\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Contact;
use Auth;
use Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts =Contact::get();
        return view('backend.contact.index',compact('contacts'));
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

     public function isActive($id){
        $contacts = Contact::find($id);
        // var_dump($sliders); die();
        $check = Contact::where('id',$id)->value('is_active');
        if($check == '1'){
            $contacts->is_active ="0";
        }
        else{
            $contacts->is_active ="1";
        }
        $contacts->update();
        return back()->withInput();
    }


    public function isSort()
    {
        $id = Input::get('id');
        $value = Input::get('value');
        $sort_ids = Contact::find($id);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contacts =new Contact;
        $contacts->phone_no = Input::get('phone_no');
        $contacts->address = Input::get('address');
        $contacts->open_time = Input::get('open_time');
        $contacts->email = Input::get('email');
        $contacts->iframe = Input::get('iframe');
        $contacts->created_by = Auth::user()->id;
        $contacts->save();
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
        $contacts = Contact::where('id',$id)->get();
        return view('backend.contact.edit',compact('contacts'));
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
        $contacts = Contact::find($id);
        $contacts->phone_no = Input::get('phone_no');
        $contacts->address = Input::get('address');
        $contacts->open_time = Input::get('open_time');
        $contacts->email = Input::get('email');
        $contacts->iframe = Input::get('iframe');
        $contacts->created_by = Auth::user()->id;
        $contacts->update();
        return redirect('/home/contact');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contacts = Contact::find($is);
        $contacts->delete();
        return back()->withInput();
    }
}
