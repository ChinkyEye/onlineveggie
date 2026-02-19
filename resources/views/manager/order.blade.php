@extends('manager.app')
@section('css')
<link rel="stylesheet" href="{{url('/')}}/backend/css/alertify.min.css">
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Billing</h3>
                <div class="card-tools">
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
                            <label>Customer ID</label>
                            <select class="form-control select2" id="customer_name">
                                <option>--Please select--</option>
                                @foreach($users as $use=>$user)
                                <option value="{{$user}}">{{$use}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label>Item</label>
                            <select class="form-control select2" id="item_id">
                                <option>-Please select-</option>
                                @foreach($items as $ite=>$item)
                                <option value="{{$item}}">{{$ite}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" class="form-control" placeholder="Enter Quantity" id="quantity" >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="d-block mb-3">Unit</label>
                            <span id="unit_id" class="text-danger text-bold"></span>
                            <input type="hidden" class="form-control" id="unit_ids">
                            <!-- <select class="form-control" id="unit_id">
                            <option>--Please select--</option>
                            @foreach($units as $ute=>$unit)
                            <option value="{{$unit}}">{{$ute}}</option>
                            @endforeach
                            </select> -->
                        </div>
                    </div>
                    <div class="col-md-2 my-auto">
                            <button class="mt-3 btn btn-block btn-success disabled" id="add_items">Add</button>
                    </div>
                </div>
                <div class="row">
                    <div id="ratebox"></div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Order</h3>
                <div class="card-tools">
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button> -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('order-store') }}" method="POST">
                    <input type="hidden" name="customer_id" id="customer_id">
                    <div class="append_customer">

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Item</label>
                        </div>
                        <div class="col-md-3">
                            <label>Quantity</label>
                        </div>
                        <div class="col-md-2">
                            <label>Rate</label>
                        </div>
                        <div class="col-md-2">
                            <label class="text-right">Total</label>
                        </div>
                    </div>

                    <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                    <div class="append_items">

                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right container-pd">
                            <a href="javascript:void(0);" id="calculate-item" class="btn btn-info btn-sm calculate">Calculate</a>
                        </div>                          
                    </div>
                    <div class="append_calculations">
                        <!-- append calculations here -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
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
    $("body").on("change", "#customer_name", function(event){
        customer_name = $(event.target).val();
        // customer_name = $('#customer_name').val();
        // $(this).find("#quantity").val(customer_name);
        $("#customer_id").val(customer_name);
        $('#add_items').removeClass('disabled').attr('disabled',false);
    });
</script>
<script type="text/javascript">
    $("body").on("change","#item_id", function(event){
        item_id = $(event.target).val(),
        token = $('.token').val();
        $.ajax({
            type:"POST",
            dataType:"json",
            url:"{{route('getItemUnit')}}",
            data:{
                _token: token,
                item_id: item_id
            },
            success: function(response){
                $('#unit_id').html('');
                // $('#unit_id').append('<option value="">Please Select Unit</option>');
                $('#unit_id').append(response[0].get_unit.name);
                $('#unit_ids').val(response[0].get_unit.id);
                // $.each( response, function( i, val ) {
                // $('#unit_id').append('<option value='+val.get_unit.id+'>'+val.get_unit.name+'</option>');
                // });
            },
            error: function(event){
                alertify.alert("Sorry");
            }
        });
    });
</script>
<script type="text/javascript">
    var cal = [];
    var x = 0;
    $("body").on("click","#add_items", function(event){
    // $('.add_items').click(function(event){
        var item_id = $('#item_id').val(),
        unit_id = $('#unit_ids').val(),
        quantity = $('#quantity').val(),
        token =$('.token').val();
        if(item_id == "" || unit_id == "" || quantity == ""){
            alertify.alert ("Please some field are missing, please check again");
            return false;
        }
        var grand_total = 0;
        $.ajax({
            type:"POST",
            dataType:"html",
            url: "{{URL::route('getItemList')}}",
            data: {
                _token: token,
                item_id: item_id,
                quantity: quantity,
                unit_id: unit_id,
                num_x : x+1
            },
            success: function(response){
                $("#item_id").focus();
                x++;
                $('.append_items').prepend(response);
                $('#delete_row').attr('id','delete_row'+x);
                $('#delete_row'+x).append('<a href="javascript:void(0);"><span class="text-danger mt-md-2 fa fa-times crossclose remove-field-'+x+'" aria-hidden="true"></span></a>');

                $(".remove-field-"+x).click(function(event){
                    event.preventDefault();
                    $(event.target).closest('.row').remove();
                });

                $('.rest_category').select2("val", "");
                $('.quantity').val('');
                $('#rest_items').val("");
                $('.rate_id').val("");
               
                $('.calculate').removeClass('disabled').attr('disabled',false);

                $(document).on("keyup",'#new_rate_'+x,function(event) {
                    var xn = event.currentTarget.id.replace(/[^\d\.]*/g,'');
                    var new_rate = $('#new_rate_'+xn).val();
                    var rate_id = $('#rate_id_'+xn).val();
                    var quantity_id = $('#quantity_id_'+xn).val();
                    if(new_rate == '0' || new_rate == ''){
                        $('#total_id_'+xn).val(rate_id*quantity_id);
                        $('.calculate').addClass('disabled');
                    }
                    else{
                        $('.calculate').removeClass('disabled').attr('disabled',false);
                        $('#total_id_'+xn).val(new_rate*quantity_id);
                    }
                });

            },
            error: function (event) {
                alertify.alert('Item quantity exceeded than stock');
                return false;
            }
        })
    });
    $('#table').change(function(event){
        var table_id = $('#table[name="customer_name"]').val(),
        customer_name = $("#table option:selected").html();
        $('.selected_table').val(customer_name);
        $('.table_id').val(table_id);
    });
</script>
<script type="text/javascript">
    $('#calculate-item').click(function(event){
        $('#loader').show();
        var total_length = $('.total').length,
        table_id = $('.table_id').val(),
        token =$('.token').val();
        if(table_id == ""){
            alertify.alert ("Please some field are missing, please check again");
            return false;
        }
        var total = [];
        $.each($('.total'),function(val) {
            var tot = $('.total')[val].value;
            total.push(tot);
        });
        $.ajax({
            type:"POST",
            dataType:"html",
            url: "{{URL::route('getItemCalculation')}}",
            data: {
                _token: token,
                total: total,
            },
            success: function(response){
                $('#loader').hide('slow');
                if(response){
                    $('.append_calculations').html(response);
                    $("#discount").focus();
                }
                $('.print').addClass('disabled');
            },
            error: function (e) {
                alertify.alert('Sorry! we cannot load data this time');
                return false;
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).on("keyup","#back_return",function() {
        var grand_total = $('#grand_total').val();
        var paid = $('#paid').val();
        $('#back_return').val(grand_total-paid);
        if(paid == '0'){
            $('.print').addClass('disabled');
        }
        else{
            $('.print').removeClass('disabled').attr('disabled',false);
        }
    });
</script>
<script type="text/javascript">
    $(document).on("keyup","#discount",function() {
        // debugger;
        // var paid = $('#paid').val();
        var discount = $('#discount').val();
        var amount = $('#amount').val();
        $('#paid').val(amount-discount);
    });
</script>
<!-- <script type="text/javascript">
    $(document).on("keyup","#due",function() {
        var due = $('#due').val();
        var due = $('#due').val();
        $('#due').val();
        if(due == '0' || due == ""){
            $('.aging').addClass('hidden');
        }
        else{
            $('.aging').removeClass('hidden');
        }
    });
</script> -->
<script type="text/javascript">
    $("body").on("keypress", "#quantity", function(event){
       if (event.keyCode == 13) {
           event.preventDefault();
           $("#add_items").click();
       }
   });
</script>
@endsection