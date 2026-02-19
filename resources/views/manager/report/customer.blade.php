@extends('manager.app')
@section('css')
<link rel="stylesheet" href="{{url('/')}}/backend/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/backend/css/select2.min.css">
<link rel="stylesheet" href="{{url('/')}}/backend/css/alertify.min.css">
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Report</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body pb-1">
                <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
                <div class="row">
                    <div class="form-group col-md">
                        <label for="customer_type">Customer Type:</label>
                        <select class="form-control" name="customer_type" id="customer_type">
                            <option value="">--Plese select one--</option>
                            <option value="1">Creditor</option>
                            <option value="2">Debitor</option>
                        </select>
                    </div>
                    <div class="form-group col-md">
                        <label for="display_name">Choose Customer:</label>
                        <select class="form-control" name="customer_id" id="customer_id">
                            <option value="">--Please select--</option>
                        </select>
                    </div>
                    <div class="form-group col-md">
                        <label for="date">Date:</label>
                        <input type="text" class="form-control" autocomplete="off" name="date" id="date">
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-sm btn-primary" id="customerSearch">Search</button>
            </div>
        </div>
        <div class="card">
            <div id="replaceTable">
                
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
            "url": "{{route('getAllVegetable')}}",
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
    $("body").on("change","#customer_type", function(event){
        customer_type = $(event.target).val(),
        token = $('.token').val();
        $.ajax({
            type:"POST",
            dataType:"json",
            url:"{{route('customer-getCustomer')}}",
            data:{
                _token: token,
                customer_type: customer_type
            },
            success: function(response){
                $('#customer_id').html('');
                $.each( response, function( i, val ) {
                $('#customer_id').append('<option value='+val+'>'+i+'</option>');
                });
            },
            error: function(event){
                alertify.alert("Sorry");
            }
        });
    });
</script>
<script type="text/javascript">
    $("body").on("click","#customerSearch", function(event){
    $('#loader').show();
    var token = $('.token').val(),
    customer_type = $('#customer_type').val(),
    customer_id = $('#customer_id').val(),
    date = $('#date').val();
    $.ajax({
        type : "POST",
        dataType : "html",
        url : "{{URL::route('customer-search')}}",
        data:{
            _token:token,
            customer_type:customer_type,
            customer_id:customer_id,
            date:date,
        },
        success:function(respone){
            $('#replaceTable').html('');
            $('#loader').hide('slow');
            $("#replaceTable").html(respone);
        },
        error:function(respone){
            alert("Sorry! we cannot load data this time");
            return false;
        }
    });
    });
</script>
@endsection