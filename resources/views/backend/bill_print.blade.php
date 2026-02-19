@extends('backend.app')
@section('content')
<!-- Small boxes (Stat box) -->
<button type="button" class="btn btn-default btn-sm hidden-print" onclick="PrintDiv('printDiv')" style=" margin-bottom: 2px;" >PRINT<i class="fa fa-print"></i></button>
<div class="row">
    <div class="col-md-12">
        <div id="printDiv">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bill Summary</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                    <table class="table table-bordered">
                        <tbody>
                            @foreach($customer_bills as $customer)
                            <tr>
                                <td>Bill ID: <b>{{$bill_id}}</b></td>
                                <td>Date: <b>{{date('D, j M Y', strtotime($customer->created_at))}}</b></td>
                            </tr>
                            <tr>
                                <td>Customer Name: <b>{{$customer->getCustomer->name}}</b></td>
                                <td>Customer ID: <b>{{$customer->getCustomer->email}}</b></td>
                            </tr>
                            <tr class="success">
                                <th>SN</th>
                                <th>Item(s)</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Total</th>
                            </tr>
                            @foreach($customer->orderDetail()->get() as $index=>$detail)
                            <tr class="info">
                                <td>{{$index+1}}</td>
                                <td>{{$detail->getName->display_name}}</td>
                                <td>{{$detail->quantity}}({{$detail->getUnit->name}})</td>
                                <td>{{$detail->rate}}</td>
                                <td>{{$detail->total}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>Total: {{$customer->total}}</td>
                            </tr>
                            <tr>
                                <td>Discount: {{$customer->discount}}</td>
                            </tr>
                            @if($customer->is_due != 0)
                            <tr>
                                <td>Due: {{$customer->due}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Net Total: {{$customer->grand_total}}</td>
                            </tr>
                            <tr>
                                <td>Bill By: {{$customer->getUser->name}} of branch {{$customer->getUser->getBranch->name}}</td>
                                <td>Printed on: {{date('Y/m/d H:i A')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
@endsection