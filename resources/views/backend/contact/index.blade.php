@extends('backend.app')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<button type="button" class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#contact" >
					Add Contact
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
							<th style="width: 10px" class="text-center">SN</th>
							<th width="200px" class="text-center">Email</th>
							<th width="100px" class="text-center">Sort</th>
							<th width="100px" class="text-center">Publish</th>
							<th width="100px" class="text-center">Action</th>
						</thead>
						<tbody>
							@foreach($contacts as $key => $data)
							<tr>
								<td class="text-center">{{$key + 1}}</td>
								<td class="text-center">{{$data->email}}</td>
								<td class="text-center">
									<input type="text" name="" id="{{$data->id}}" ids="{{$data->id}}" class="col text-center sort" page="contact" contenteditable="true" value="{{$data->sort_id}}">
								</td>
								<td class="text-center">
									<a href="{{URL::to('/')}}/home/contact/{{$data->id}}/isActive" class=" {{$data->is_active == '0' ? 'text-danger' : 'text-success'}}"><i class="fas {{ $data->is_active == '1' ? 'fa-check':'fa-times'}}"></i></a>
								</td>
								<td class="text-center">
									<a href="{{URL::to('/')}}/home/contact/{{$data->id}}/edit" class="mr-2" title="View Detail"><i class="fa fa-edit"></i></a>
									<a href="{{URL::to('/')}}/home/contact/{{$data->id}}/delete" title="Delete"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<!-- /.card-body -->
			<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-gradient-primary">
							<h4 class="modal-title text-capitalize">{{str_replace('-',' ',Route::currentRouteName())}} Register</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form role="form" method="POST" action="{{URL::to('/')}}/home/contact/store">
							{{csrf_field()}}
							<div class="modal-body">
								<div class="form-group">
									<label for="phone_no">Phone No: </label>
									<input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Enter number" autocomplete="off">
								</div>
								<div class="form-group">
									<label for="address">Address</label>
									<input type="text" name="address" class="form-control" id="address" placeholder="Enter address">
								</div>
								<div class="form-group">
									<label for="open_time"> Open Time: </label>
									<input type="text" class="form-control" name="open_time" id="open_time" autocomplete="off">
								</div>
								<div class="form-group">
									<label for="email">Email</label>
									<input type="text" name="email" class="form-control" id="email" placeholder="Enter your email" autocomplete="off">
								</div>
								<div class="form-group">
									<label for="title">Iframe</label>
									<input type="text" name="iframe" class="form-control" id="iframe" placeholder="Enter the link" autocomplete="off">
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
@endsection