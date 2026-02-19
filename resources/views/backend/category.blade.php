@extends('backend.app')
@section('css')
<link rel="stylesheet" href="{{url('/')}}/backend/css/dataTables.bootstrap4.css">
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
                <button type="button" class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#exampleModal">
                    Add Category
                </button>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped w-100 my-table" id="category_ajax">
                        <thead class="bg-secondary">                  
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h4 class="modal-title text-capitalize">{{str_replace('-',' ',Route::currentRouteName())}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form role="form" method="POST" action="{{route('admin-category-store')}}">
                        <div class="modal-body">
                            <!-- form start -->
                            <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="name" class="form-control" name="name" id="name" placeholder="Enter name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Now!</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->


@endsection
@section('javascript')
<script src="{{url('/')}}/backend/js/jquery.dataTables.js"></script>
<script src="{{url('/')}}/backend/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
// $(function () {
    $('.modal').modal({
        show:false,
        keyboard: true,
        backdrop: 'static'
    });
});
</script>
<script type="text/javascript">
    $('#category_ajax').DataTable({
        "processing": true,
        "language": {
            processing: '<i class="nav-icon fas fa-tachometer-alt"></i><span class="sr-only">Techware Inventory......</span> '
        },
        "serverSide": true,
        "ajax":{
            "url": "{{route('admin-getAllCategory')}}",
            "dataType": "json",
            "type": "POST",
            "data":{ 
                _token: $(".token").val(),
            }
        },
        "columns": [
        { "data": "id" },
        { "data": "name" },
        { "data": "created_by" },
        { "data": "created_at" },
        { "data": "action" },
        ],
        "order": [[ 0 ,"asc" ]]

    });
</script>
@endsection