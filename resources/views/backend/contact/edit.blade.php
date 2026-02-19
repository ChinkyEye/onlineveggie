@extends('backend.app')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			@foreach($contacts as $data)
			<form role="form" method="POST" action="{{URL::to('/')}}/home/contact/{{$data->id}}/update">
				{{csrf_field()}}
				<div class="card-body">
					<div class="form-group">
						<label for="phone_no">Phone No: </label>
						<input type="text" class="form-control" name="phone_no" id="phone_no" value="{{$data->phone_no}}" >
					</div>
					<div class="form-group">
						<label for="address">Address</label>
						<input type="text" name="address" class="form-control" id="address" value="{{$data->address}}">
					</div>
					<div class="form-group">
						<label for="open_time"> Open Time: </label>
						<input type="text" class="form-control" name="open_time" id="open_time" value="{{$data->open_time}}" >
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" name="email" class="form-control" id="email" value="{{$data->email}}" >
					</div>
					<div class="form-group">
						<label for="title">Iframe</label>
						<input type="text" name="iframe" class="form-control" id="iframe" value="{{$data->iframe}}" >
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