@extends('backend.app')
@section('css')
<link rel="stylesheet" href="{{url('/')}}/backend/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/backend/css/alertify.min.css">
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<div class="card">
    <div class="card-header">
        <div class="user-block">
          <span class="username ml-0"><a href="javascript:void(0);">{{$name}}</a></span>
          <span class="description ml-0">{{$branch}} | {{$address}}</span>
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <form role="form" method="POST" action="{{route('manager-sales-search',['id'=>$id])}}" enctype="multipart/form-data">
    <div class="card-body pb-1">
        <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
        <div class="row">
            <div class="form-group col-md">
                <label for="category_id">Category:</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">--Plese select one--</option>
                    @foreach($categories as $cat=>$category)
                    <option value="{{$category}}">{{$cat}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md">
                <label for="vegetable_id">Choose Vegetable:</label>
                <select class="form-control" name="vegetable_id" id="vegetable_id">
                    <option value="">--Please select--</option>
                </select>
            </div>
            <div class="form-group col-md">
                <label for="date">Date from:</label>
                <input type="text" class="form-control" autocomplete="off" name="from_date" id="date">
            </div>
            <div class="form-group col-md">
                <label for="date">Date to:</label>
                <input type="text" class="form-control" autocomplete="off" name="to_date" id="date1">
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-sm btn-primary">Search</button>
    </div>
    </form>
</div>
<div class="card">
    <div class="card-body">
        <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped w-100 my-table">
                <thead class="bg-secondary">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>                 
                </thead>
                <tbody>
                    @foreach($orders as $index=>$order)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$order->getName->getCategory->name}}</td>
                        <td>{{$order->getName->display_name}}</td>
                        <td>{{$order->getItem->purchase_id}}</td>
                        <td>{{$order->calc_qty}}({{$order->getCalcUnit->name}})</td>
                        <td>Rs: {{$order->total}}</td>
                        <td>{{$order->date}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
          <li class="page-item">{{ $orders->links("pagination::bootstrap-4") }}</li>
        </ul>
      </div>
    <!-- /.card-body -->
</div>
<!-- /.row -->
@endsection
@section('javascript')
<script src="{{url('/')}}/backend/js/jquery.dataTables.js"></script>
<script src="{{url('/')}}/backend/js/dataTables.bootstrap4.js"></script>
<script src="{{url('/')}}/backend/js/select2.full.min.js"></script>
<script src="{{url('/')}}/backend/js/alertify.min.js"></script>
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
<script type="text/javascript">
    $("body").on("change","#category_id", function(event){
        category_id = $(event.target).val(),
        token = $('.token').val();
        $.ajax({
            type:"POST",
            dataType:"json",
            url:"{{route('admin-getSale')}}",
            data:{
                _token: token,
                category_id: category_id
            },
            success: function(response){
                $('#vegetable_id').html('');
                $.each( response, function( i, val ) {
                $('#vegetable_id').append('<option value='+val+'>'+i+'</option>');
                });
            },
            error: function(event){
                alertify.alert("Sorry");
            }
        });
    });
</script>
@endsection