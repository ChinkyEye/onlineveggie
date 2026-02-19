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
    <form role="form" method="POST" action="{{route('manager-stock-search',['id'=>$id])}}" enctype="multipart/form-data">
    <div class="card-body pb-1">
        <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
        <div class="row">
            <div class="col-md-4 row">
                <label for="vegetable_id" class="col-md-4 mt-md-1">Vegetable:</label>
                <div class="form-group col-md-8">
                    <select class="form-control" name="vegetable_id" id="vegetable_id">
                        <option value="">--Plese select one--</option>
                        @foreach($veggies as $veg=>$vegi)
                        <option value="{{$vegi}}">{{$veg}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    </form>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped w-100 my-table">
                <thead class="bg-secondary">                 
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Purchase</th>
                    <th>Sold</th>
                    <th>Stock</th>
                    <th>Unit</th>
                </thead>
                <tbody>
                    @foreach($query as $index=>$customer)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$customer->getName->display_name}}</td>
                        <td>{{$customer->getName->getCategory->name}}</td>
                        <td>{{$customer->getItem->weight}}</td>
                        <td>{{$customer->getItem->weight - $customer->qty_sum}}</td>
                        <td>{{$customer->qty_sum}}</td>
                        <td>{{$customer->getCalcUnit->name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.row -->
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
            url:"{{route('admin-vegetable-getVegetable')}}",
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