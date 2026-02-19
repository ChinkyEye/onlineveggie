@extends('manager.app')
@section('css')<link rel="stylesheet" href="{{url('/')}}/backend/css/print.css">@endsection
@section('content')
<!-- Small boxes (Stat box) -->

<div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center mt-md-2">Estimate Bill</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-info btn-sm hidden-print" onclick="PrintDiv('printDiv')" style=" margin-bottom: 2px;" >PRINT<i class="fa fa-print"></i></button>
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