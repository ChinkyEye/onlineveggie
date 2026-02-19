@extends('backend.app')
@section('css')
<link rel="stylesheet" href="{{url('/')}}/backend/css/dataTables.bootstrap4.css">
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<!-- <div class="card">
    <div class="card-header">
        <h3 class="card-title">Vegetable Entry</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <form role="form" method="POST" action="{{route('admin-vegetable-store')}}" enctype="multipart/form-data">
        <div class="card-body">
            <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
            <div class="card-body row">
                <div class="form-group col-md">
                    <label for="category_id">Category</label>
                    <select class="form-control" name="category_id" id="category_id">
                        <option>--Please select--</option>
                        @foreach($categories as $cat=>$category)
                        <option value="{{$category}}" {{old("category_id") == $category ?"selected":''}}>{{$cat}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md">
                    <label for="display_name">Display Name</label>
                    <input type="text" class="form-control" name="display_name" id="display_name" placeholder="Enter display_name" value="{{old('display_name')}}">
                </div>
                <div class="form-group col-md">
                    <label for="image">Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="image">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save Now!</button>
        </div>
    </form>
</div> -->
<div class="card">
    <div class="card-body">
        <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped w-100 my-table" id="vegetable_ajax">
                <thead class="bg-secondary">                  
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Action</th>
                </thead>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
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
    $('#vegetable_ajax').DataTable({
        "processing": true,
        "language": {
            processing: '<i class="nav-icon fas fa-tachometer-alt"></i><span class="sr-only">Techware Inventory......</span> '
        },
        "serverSide": true,
        "ajax":{
            "url": "{{route('admin-getAllVegetable')}}",
            "dataType": "json",
            "type": "POST",
            "data":{ 
                _token: $(".token").val(),
            }
        },
        "columns": [
        { "data": "id" },
        { "data": "display_name" },
        { "data": "category_id" },
        { "data": "image" },
        { "data": "created_by" },
        { "data": "created_at" },
        { "data": "action" },
        ],
        "order": [[ 0 ,"asc" ]]

    });
</script>
@endsection