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
                <h3 class="card-title">{{$category}}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                <input type="hidden" name="cat_id" class="cat_id" value="{{$cat_id}}">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped w-100 my-table" id="category_detail_ajax">
                        <thead class="bg-secondary">                  
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Weight</th>
                            <th>Amount</th>
                            <th>Total</th>
                            <th>Created By</th>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
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
    $('#category_detail_ajax').DataTable({
        "processing": true,
        "language": {
            processing: '<i class="nav-icon fas fa-tachometer-alt"></i><span class="sr-only">Techware Inventory......</span> '
        },
        "serverSide": true,
        "ajax":{
            "url": "{{route('admin-getAllCategoryDetail')}}",
            "dataType": "json",
            "type": "POST",
            "data":{ 
                _token: $(".token").val(),
                cat_id: $(".cat_id").val(),
            }
        },
        "columns": [
        { "data": "id" },
        { "data": "display_name" },
        { "data": "date" },
        { "data": "weight" },
        { "data": "amount" },
        { "data": "total" },
        { "data": "created_by" },
        ],
        "order": [[ 0 ,"asc" ]],
        "columnDefs": [
        { "orderable": false, "targets": 2 }
        ]  

    });
</script>
@endsection