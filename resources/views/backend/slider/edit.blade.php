@extends('backend.app')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			@foreach($sliders as $key => $data)
			<form role="form" method="POST" action="{{URL::to('/')}}/home/slider/{{$data->id}}/update" enctype="multipart/form-data">
              <div class="card-body">
                <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
                <div class="form-group">
                  <label for="name">Title: </label>
                  <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" autocomplete="off" value="{{$data->title}}">
                </div>
                <div class="form-group">
                 <label for="image">Image</label>
                 <div class="row">
                   <div class="col-md-6">
                    <img id="blah" src="{{URL::to('/')}}/images/slider/{{$data->image}}" onclick="document.getElementById('imgInp').click();" alt="your image" class="img-thumbnail" style="width: 175px;height: 140px"/>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group my-3">
                     <input type='file' class="d-none" id="imgInp" name="image" />
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
			@endforeach
		</div>
	</div>
</div>
@endsection