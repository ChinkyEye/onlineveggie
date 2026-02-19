@extends('backend.app')
@section('css')
<link rel="stylesheet" href="{{url('/')}}/backend/css/alertify.min.css">
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Purchase Entry</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form role="form" method="POST" action="{{route('admin-purchase-store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Purchase From:</label>
                                    <select class="form-control select2" name="purchase_user_id">
                                        <option value="">--Please select--</option>
                                        @foreach($purchase_users as $agent=>$purchase)
                                        <option value="{{$purchase}}" {{old("purchase_user_id") == $purchase ?"selected":''}}>{{$agent}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Category:</label>
                                    <select class="form-control select2" name="category_id" id="category_id">
                                        <option value="">--Please select--</option>
                                        @foreach($categories as $cat=>$category)
                                        <option value="{{$category}}" {{old('category_id') == $category ?'selected':''}}>{{$cat}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Date:</label>
                                    <input type="text" class="form-control" name="date" id="date" placeholder="Enter date..." autocomplete="off"  value="{{old('date')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Display Name:</label>
                                    <select class="form-control" id="display_id" name="vegetable_id">
                                        <option>--Please choose--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Code:</label>
                                    <input type="text" class="form-control" id="display_code" placeholder="Enter code..." name="purchase_id">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Quantity:</label>
                                    <input type="text" class="form-control" id="quantity" placeholder="Enter Quantity..." name="weight">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Unit:</label>
                                    <select class="form-control" name="unit_id">
                                        <option value="">--Please select--</option>
                                        @foreach($units as $ut=>$unit)
                                        <option value="{{$unit}}">{{$ut}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Amount:</label>
                                    <input type="text" class="form-control" id="amount" placeholder="Enter Amount..." name="amount">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Total:</label>
                                    <input type="text" class="form-control" id="total" placeholder="Enter Total..." name="total">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Enter Now!</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead> 
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Weight</th>
                            <th>Amount</th>
                            <th>Total</th>
                            <th>Category</th>
                            <th>From</th>
                        </tr>                 
                    </thead>
                    <tbody>
                        @foreach($purchases as $index=>$unit)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$unit->getName->display_name}}</td>
                            <td>{{$unit->purchase_id}}</td>
                            <td>{{$unit->weight}} ({{$unit->getUnit->name}})</td>
                            <td>Rs: {{$unit->amount}}</td>
                            <td>Rs: {{$unit->total}}</td>
                            <td>{{$unit->getCategory->name}}</td>
                            <td>{{$unit->getPurchase->name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script src="{{url('/')}}/backend/js/select2.full.min.js"></script>
<script src="{{url('/')}}/backend/js/alertify.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.select2').select2()
    });
</script>
<script type="text/javascript">
    $("body").on("change","#category_id", function(event){
        category_id = $(event.target).val(),
        token = $('.token').val();
        $.ajax({
            type:"POST",
            dataType:"json",
            url:"{{route('admin-getCatVeg')}}",
            data:{
                _token: token,
                category_id: category_id
            },
            success: function(response){
                $('#display_id').html('');
                $('#display_id').append('<option value="">--Choose Vege--</option>');
                $.each( response, function( i, val ) {
                $('#display_id').append('<option value='+val.id+'>'+val.display_name+'</option>');
                });
            },
            error: function(event){
                alertify.alert("Sorry");
            }
        });
    });
</script>
<script type="text/javascript">
    $("body").on("change","#display_id", function(event){
        $("#display_code").html("");
        display_id = $("#display_id option:selected").text();
        var date = $("#date").val();
        var res = display_id.toLowerCase();
        $("#display_code").val(res+'-'+date);
        // alertify.alert(res);
    });
</script>
<script type="text/javascript">
    $( "#amount" ).keyup(function(event) {
      var quantity = $("#quantity").val();
      var amount = $("#amount").val();
      $("#total").val(quantity*amount);
    });
</script>
@endsection