@extends('backend.app')
@section('css')
<link rel="stylesheet" href="{{url('/')}}/backend/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/backend/css/alertify.min.css">
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Bill Report</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
        <div class="row">
            <div class="form-group col-md">
                <label for="bill_no">Bill No:</label>
                <input type="text" class="form-control" name="bill_no" id="bill_no">
            </div>
            <div class="form-group col-md">
                <label for="date">Date:</label>
                <input type="text" class="form-control" autocomplete="off" name="date" id="date">
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-sm btn-primary" id="billSearch">Search</button>
    </div>
</div>
<div class="card">
    <div id="replaceTable">
        
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
    $("body").on("click","#billSearch", function(event){
    $('#loader').show();
    var token = $('.token').val(),
    bill_no = $('#bill_no').val(),
    date = $('#date').val();
    $.ajax({
        type : "POST",
        dataType : "html",
        url : "{{URL::route('admin-bill-search')}}",
        data:{
            _token:token,
            bill_no:bill_no,
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