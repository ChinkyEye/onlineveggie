@extends('backend.app')
@section('css')
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
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" method="POST" action="{{route('manager-purchase-search',['id'=>$id])}}" enctype="multipart/form-data">
        <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
        <div class="card-body pb-1">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Category:</label>
                        <select class="form-control" name="category_id" id="category_id">
                            <option value="">--Please select--</option>
                            @foreach($categories as $cat=>$category)
                            <option value="{{$category}}" {{old('category_id') == $category ?'selected':''}}>{{$cat}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vegetable_id">Choose Vegetable:</label>
                        <select class="form-control" name="vegetable_id" id="vegetable_id">
                            <option value="">--Please select--</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Date From:</label>
                        <input type="text" class="form-control" name="from_date" id="date" placeholder="Enter date..." autocomplete="off"  value="{{old('from_date')}}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Date To:</label>
                        <input type="text" class="form-control" name="to_date" id="date1" placeholder="Enter date..." autocomplete="off"  value="{{old('to_date')}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-sm btn-info">Search Now!</button>
        </div>
    </form>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Purchase list {{date('Y/m/d')}} of amount Rs: {{$sum}}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped w-100 my-table">
                <thead class="bg-secondary">  
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Weight</th>
                        <th>Amount</th>
                        <th>Total</th>
                        <th>Category</th>
                        <th>From</th>
                        <th>Manage</th>
                    </tr>                 
                </thead>
                <tbody>
                    @foreach($purchases as $index=>$purchase)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$purchase->getName->display_name}}</td>
                        <td>{{$purchase->purchase_id}}</td>
                        <td>{{$purchase->weight}} ({{$purchase->getUnit->name}})</td>
                        <td>Rs: {{$purchase->amount}}</td>
                        <td>Rs: {{$purchase->total}}</td>
                        <td>{{$purchase->getCategory->name}}</td>
                        <td>{{$purchase->getPurchase->name}}</td>
                        <td><a href="{{url('/')}}/home/purchase/view/manage/{{$purchase->id}}"><i class="fas fa-check"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
          <li class="page-item">{{ $purchases->links("pagination::bootstrap-4") }}</li>
        </ul>
      </div>
    <!-- /.card-body -->
</div>
@endsection
@section('javascript')
<script src="{{url('/')}}/backend/js/select2.full.min.js"></script>
<script src="{{url('/')}}/backend/js/alertify.min.js"></script>
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