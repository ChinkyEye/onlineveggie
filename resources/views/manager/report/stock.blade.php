@extends('manager.app')
@section('css')
<link rel="stylesheet" href="{{url('/')}}/backend/css/alertify.min.css">
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Stock Report</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
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
                        <label for="item_id">Choose Item:</label>
                        <select class="form-control" name="item_id" id="item_id">
                            <option value="">--Please select--</option>
                        </select>
                    </div>
                </div>
                    <!-- /.card-body -->
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-sm btn-primary" id="stockSearch">Search</button>
            </div>
        </div>
        <div class="card">
            <div id="replaceTable">
                
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
    $("body").on("change","#category_id", function(event){
        Pace.start();
        var category_id = $(event.target).val(),
        token = $('.token').val();
        $.ajax({
            type:"POST",
            dataType:"json",
            url:"{{route('vegetable-getVegetable')}}",
            data:{
                _token: token,
                category_id: category_id
            },
            success: function(response){
                Pace.stop();
                $('#vegetable_id').html('');
                $('#vegetable_id').append('<option value="">Please Select</option>');
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
<script type="text/javascript">
    $("body").on("change","#vegetable_id", function(event){
        Pace.start();
        var category_id = $("#category_id").val(),
        vegetable_id = $(event.target).val(),
        token = $('.token').val();
        $.ajax({
            type:"POST",
            dataType:"json",
            url:"{{route('vegetable-getItem')}}",
            data:{
                _token: token,
                vegetable_id: vegetable_id,
                category_id: category_id,
            },
            success: function(response){
                Pace.stop();
                $('#item_id').html('');
                $.each( response, function( i, val ) {
                $('#item_id').append('<option value='+val+'>'+i+'</option>');
                });
            },
            error: function(event){
                alertify.alert("Sorry");
            }
        });
    });
</script>
<script type="text/javascript">
    $("body").on("click","#stockSearch", function(event){
    Pace.start();
    var token = $('.token').val(),
    category_id = $('#category_id').val(),
    vegetable_id = $('#vegetable_id').val(),
    item_id = $('#item_id').val(),
    date = $('#date').val();
    $.ajax({
        type : "POST",
        dataType : "html",
        url : "{{URL::route('stock-search')}}",
        data:{
            _token:token,
            category_id:category_id,
            vegetable_id:vegetable_id,
            item_id:item_id,
            date:date,
        },
        success:function(respone){
            Pace.stop();
            $('#replaceTable').html('');
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