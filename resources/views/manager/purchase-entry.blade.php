@extends('manager.app')
@section('css')
<link rel="stylesheet" href="{{url('/')}}/backend/css/alertify.min.css">
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <form role="form" method="POST" action="{{route('purchase-store')}}" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Purchase Entry</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
                <div class="card-body">
                    <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-md">
                            <!-- text input -->
                            <div class="form-group">
                                <label class="w-100">Purchase From:</label>
                                <select class="form-control select2" name="purchase_user_id">
                                    <option value="">--Please select--</option>
                                    @foreach($purchase_users as $agent=>$purchase)
                                    <option value="{{$purchase}}" {{old("purchase_user_id") == $purchase ?"selected":''}}>{{$agent}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label class="w-100">Category:</label>
                                <select class="form-control select2" name="category_id" id="category_id">
                                    <option value="">--Please select--</option>
                                    @foreach($categories as $cat=>$category)
                                    <option value="{{$category}}" {{old('category_id') == $category ?'selected':''}}>{{$cat}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
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
                                <select class="form-control" id="unit_change_id" name="unit_id">
                                    <option value="">--Please select--</option>
                                    @foreach($units as $ut=>$unit)
                                    <option value="{{$unit}}">{{$ut}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Amount Per <span id="units_ids"></span>:</label>
                                <input type="text" class="form-control" id="amount" placeholder="Enter Amount..." name="amount">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Total:</label>
                                <input type="text" class="form-control" id="total" placeholder="Enter Total..." name="total" readonly="true">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Enter Now!</button>
                </div>
            <!-- /.card-body -->
        </div>
        </form>
        <div class="card">
            <div class="card-header">
                <form method="GET" action="{{route('purchase-entry-date')}}">
                <div class="row">
                <h3 class="card-title col-md-3 mt-2">Purchase list of {{$date}}</h3>
                <div class="col-md">
                    <div class="form-group">
                        <input type="text" class="form-control" name="dateseach" id="dateseach1" placeholder="Enter date..." autocomplete="off"  value="{{old('dateseach')}}" required="true">
                    </div>
                </div>
                <div class="col-md">
                    <button type="submit" class="btn btn-info">Search Now!</button>
                </div>
                </div>
                </form>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
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
                                <td><a href="{{url('/')}}/manager/purchase/entry/manage/{{$purchase->id}}"><i class="fas fa-check"></i></a>({{$purchase->getPurchaseCount()->count()}})</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
            url:"{{route('getCatVeg')}}",
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
<script type="text/javascript">
    $("body").on("change","#unit_change_id", function(event){
        $("#units_ids").html("");
        display_id = $("#unit_change_id option:selected").text();
        var res = display_id.toLowerCase();
        $("#units_ids").append(res);
        // alertify.alert(res);
    });
</script>
@endsection