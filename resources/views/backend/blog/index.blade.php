@extends('backend.app')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<button type="button" class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#blog" >
					Add Blog
				</button>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<input type="hidden" name="_token" class="token" value="">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped w-100 my-table" id="userTable">
						<thead class="bg-secondary">                  
							<th style="width: 10px">SN</th>
							<th width="700px" class="text-center">Title</th>
							<th class="text-center">Image</th>
							<th class="text-center">Sort</th>
							<th width="100px" class="text-center">Publish</th>
							<th width="100px" class="text-center">Action</th>
						</thead>
						<tbody>
							@foreach($blog as $key => $data)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$data->title}}</td>
								<td class="text-center">
									<img src="{{URL::to('/')}}/images/blog/{{$data->image}}" class="img-fluid" style="height:50px;width: 50px">
								</td>
								<td>
									<input type="text" name="" id="{{$data->id}}" ids="{{$data->id}}" class="col text-center sort" page="blog" contenteditable="true" value="{{$data->sort_id}}">
								</td>
								<td>
									<a href="{{URL::to('/')}}/home/blog/{{$data->id}}/isActive" class=" {{$data->is_active == '0' ? 'text-danger' : 'text-success'}}"><i class="fas {{ $data->is_active == '1' ? 'fa-check':'fa-times'}}"></i></a>
								</td>
								<td>
									<a href="{{URL::to('/')}}/home/blog/{{$data->id}}/edit" class="mr-2"><i class="fas fa-edit"></i></a>
									<a href="{{URL::to('/')}}/home/blog/{{$data->id}}/delete"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal fade" id="blog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-gradient-primary">
							<h4 class="modal-title text-capitalize">{{str_replace('-',' ',Route::currentRouteName())}} Register</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form role="form" method="POST" action="{{URL::to('/')}}/home/blog/store" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="modal-body">
								<div class="form-group">
									<label for="title">Title: </label>
									<input type="text" class="form-control" name="title" id="title" placeholder="Enter title" autocomplete="off">
								</div>
								<div class="form-group">
									<label for="st_paragraph">Short Paragraph</label>
									<input type="text" name="st_paragraph" class="form-control" id="st_paragraph">
								</div>
								<div class="form-group">
									<label for="lg_paragraph"> Long Paragraph</label>
									<input type="text" class="form-control" name="lg_paragraph" id="description" autocomplete="off">
								</div>
								<div class="form-group">
									<label for="image">Image</label>
									<div class="row">
										<div class="col-md-6">
											<img id="blah" src="{{URL::to('/')}}/backend/80x80.png" onclick="document.getElementById('imgInp').click();" alt="your image" class="img-thumbnail" style="width: 175px;height: 140px"/>
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
								<button type="submit" class="btn btn-primary">Register Now!</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
    $(".sort").keydown(function (e) {
        Pace.start();
        if (e.which == 9){
            var id = $(event.target).attr('ids'),
            page = $(event.target).attr('page'),
            value = document.getElementById(id).value,
            token = $('meta[name="csrf-token"]').attr('content');
            var url= "{{ URL::to('/')}}/home/sort/" +page;
            debugger;
            $.ajax({
                type:"POST",
                dataType:"JSON",
                url:url,
                data:{
                    _token:token,
                    id : id,
                    value : value,
                },
                success:function(e){
                    location.reload();
                },
                error: function (e) {
                    alert('Sorry! this data is used some where');
                    Pace.start();
                }
            });
        }
    });
</script>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script>
	$(function () {
		CKEDITOR.replace('description');
		// CKEDITOR.replace('st_paragraph');
	});
</script>
@endsection