@extends('backend.app')
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$name}}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped w-100 my-table">
                        <thead class="bg-secondary"> 
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Bill ID</th>
                                <th>Total</th>
                                <th>Discount</th>
                                <th>Due</th>
                                <th>Net Total</th>
                                <th>Created By</th>
                                <th>Created At</th>
                            </tr>                 
                        </thead>
                        <tbody>
                            @foreach($user_details as $index=>$detail)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td><a href="{{url('/')}}/home/order/bill/{{$detail->bill_id}}">{{$detail->bill_id}}</a></td>
                                <td>Rs: {{$detail->total}}</td>
                                <td>Rs: {{$detail->discount}}</td>
                                <td>Rs: {{$detail->due}}</td>
                                <td>Rs: {{$detail->grand_total}}</td>
                                <td>{{$detail->getUser->name}}</td>
                                <td>{{date('D, j M Y', strtotime($detail->created_at))}} <span class="badge badge-success">{{$detail->created_at->diffForHumans()}}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<!-- /.row -->
@endsection