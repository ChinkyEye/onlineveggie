@extends('backend.app')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			@foreach($blogs as $data)
			<form role="form" method="POST" action="{{URL::to('/')}}/home/blog/{{$data->id}}/update" enctype="multipart/form-data">
				{{csrf_field()}}
				<div class="modal-body">
					<div class="form-group">
						<label for="title">Title: </label>
						<input type="text" class="form-control" name="title" id="title" value="{{$data->title}}">
					</div>
					<div class="form-group">
						<label for="st_paragraph">Short Paragraph</label>
						<input type="text" name="st_paragraph" class="form-control" id="st_paragraph" value="{{$data->st_paragraph}}">
					</div>
					<div class="form-group">
						<label for="lg_paragraph"> Long Paragraph</label>
						<input type="text" class="form-control" name="lg_paragraph" id="description" value="lg_paragraph">
					</div>
					<div class="form-group">
						<label for="image">Image</label>
						<div class="row">
							<div class="col-md-6">
								<img id="blah" src="{{URL::to('/')}}/images/blog/{{$data->image}}" onclick="document.getElementById('imgInp').click();" alt="your image" class="img-thumbnail" style="width: 175px;height: 140px"/>
							</div>
							<div class="col-md-6">
								<div class="input-group my-3">
									<input type='file' class="d-none" id="imgInp" name="image" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
			@endforeach
		</div>
	</div>
</div>
@endsection