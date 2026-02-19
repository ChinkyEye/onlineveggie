@extends('manager.app')
@section('css')<link rel="stylesheet" href="{{url('/')}}/backend/css/print.css">
<link rel="stylesheet" href="{{url('/')}}/backend/css/alertify.min.css">@endsection
@section('content')
<!-- Small boxes (Stat box) -->

<div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center mt-md-2">Online order Bill</h3>
                    <div class="card-tools">
                        <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
                        @if($confirmed_status == '1' && $deliver_status == '0')
                        <button type="button" class="btn btn-sm btn-danger">Confirmed</button>
                        <a href="javascript:void(0);"><i class='fa fa-check delivered' title="Mark as delivered" id='{{$bill_id}}'></i></a>
                        <button type="button" class="btn btn-info btn-sm hidden-print" onclick="PrintDiv('printDiv')" style=" margin-bottom: 2px;" >PRINT<i class="fa fa-print"></i></button>
                        @elseif($confirmed_status == '2' && $deliver_status == '0')
                        <button type="button" class="btn btn-sm btn-danger">Cancle</button>
                        @elseif($confirmed_status && $deliver_status)
                        <button type="button" class="btn btn-sm btn-danger">Confirmed & Delivered</button>
                        <button type="button" class="btn btn-info btn-sm hidden-print" onclick="PrintDiv('printDiv')" style=" margin-bottom: 2px;" >PRINT<i class="fa fa-print"></i></button>
                        @else
                        <a href="javascript:void(0);"><i class='fa fa-check confirmed' title="Mark as confirmed" id='{{$bill_id}}'></i></a>
                        <a href="javascript:void(0);"><i class='fa fa-times cancle' title="Mark as cancle" id='{{$bill_id}}'></i></a>
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
        <div id="printDiv">
                <div class="card-body">
                    <div class="table-responsive">
                            @foreach($customer_bills as $customer)
                        <div class="print-header">
                            <h4 class="text-center m-0">Smart Veggies</h4>
                            <p class="text-center mt-0"><small>PAN No. : 611676535 | {{Auth::user()->getAddress->name}}</small></p>
                        </div>
                        <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                        <table class="table table-stripied my-table">
                            <thead>
                                <tr>
                                    <td colspan="3">
                                        Bill ID: <b>{{$bill_id}}</b>
                                    </td>
                                    <td colspan="2" class="text-md-right">
                                        Date: <b>{{date('D, j M Y', strtotime($customer->created_at))}}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        Name: <b>{{$customer->getCustomer->name}}</b>
                                    </td>
                                    <td colspan="2" class="text-md-right">
                                        ID: <b>{{$customer->getCustomer->email}}</b>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="success">
                                    <th>SN</th>
                                    <th>Item(s)</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th class="text-right">Total</th>
                                </tr>
                                    @foreach($customer->orderDetail()->get() as $index=>$detail)
                                    <tr class="info">
                                        <td>{{$index+1}}</td>
                                        <td>{{$detail->getName->display_name}}</td>
                                        <td>{{$detail->quantity}} ({{$detail->getUnit->name}})</td>
                                        <td>{{$detail->rate}}</td>
                                        <td class="text-right">{{$detail->total}}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                            <tfoot>
                                @if($customer->discount != 0)
                                <tr>
                                    <td colspan="4" class="text-right">
                                        <b>Total:</b>
                                    </td>
                                    <td class="text-right">{{$customer->total}}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">
                                        <b>Discount:</b>
                                    </td>
                                    <td class="text-right">{{$customer->discount}}</td>
                                </tr>
                                @endif
                                @if($customer->is_due != 0)
                                <tr>
                                    <td colspan="4" class="text-right">
                                        <b>Due:</b>
                                    </td>
                                    <td class="text-right">{{$customer->due}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="4" class="text-right"><b>Net Amount:</b></td>
                                    <td class="text-right">{{$customer->paid}}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><b>Tender:</b></td>
                                    <td class="text-right">{{$customer->grand_total}}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><b>Change:</b></td>
                                    <td class="text-right">{{$customer->return_back}}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">In words: {{strtoupper(Terbilang::make($customer->paid))}} only/-</td>
                                </tr>
                                <tr>
                                    @if($customer->created_by)
                                    <td colspan="5" class="text-center">
                                        <small>
                                            <p class="m-0">
                                                <b>Bill By:</b> {{$customer->getUser->name}} of branch {{$customer->getUser->getBranch->name}}
                                            </p>
                                            <p class="m-0">
                                                <b>Printed on:</b> {{date('Y/m/d H:i A')}}
                                            </p>
                                        </small>
                                    </td>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                            @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
@endsection
@section('javascript')
<script src="{{url('/')}}/backend/js/alertify.min.js"></script>
<script type="text/javascript">
  // goes to category controller
  $("body").on("click", ".confirmed", function(event){
        var id = $(event.target).attr("id");
        token=$(".token").val();

        alertify.confirm("Are you sure you want to mark as confirmed?",function(){
            url= "{{route('review-confirm') }}",
            $.ajax({
                type:"POST",
                dataType:"JSON",
                url:url,
                data:{
                    _token:token,
                    id : id
                },
                success:function(e){
                    alertify.alert(e.msg,function(){
                        location.reload()
                    })
                },
                error: function (e) {
                    alertify.alert('Sorry! this data is used some where');
                }
            });
        });
    });
</script>
<script type="text/javascript">
  // goes to category controller
  $("body").on("click", ".delivered", function(event){
        var id = $(event.target).attr("id");
        token=$(".token").val();

        alertify.confirm("Are you sure you want to mark as delivered?",function(){
            url= "{{route('review-deliver') }}",
            $.ajax({
                type:"POST",
                dataType:"JSON",
                url:url,
                data:{
                    _token:token,
                    id : id
                },
                success:function(e){
                    alertify.alert(e.msg,function(){
                        location.reload()
                    })
                },
                error: function (e) {
                    alertify.alert('Sorry! this data is used some where');
                }
            });
        });
    });
</script>
<script type="text/javascript">
  // goes to category controller
  $("body").on("click", ".cancle", function(event){
        var id = $(event.target).attr("id");
        token=$(".token").val();

        alertify.confirm("Are you sure you want to mark as cancle?",function(){
            url= "{{route('review-cancle') }}",
            $.ajax({
                type:"POST",
                dataType:"JSON",
                url:url,
                data:{
                    _token:token,
                    id : id
                },
                success:function(e){
                    alertify.alert(e.msg,function(){
                        location.reload()
                    })
                },
                error: function (e) {
                    alertify.alert('Sorry! this data is used some where');
                }
            });
        });
    });
</script>
@endsection