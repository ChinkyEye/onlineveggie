@extends('manager.app')
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
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
                                <th>Order By</th>
                                <th>Created At</th>
                            </tr>                 
                        </thead>
                        <tbody>
                            @foreach($items as $index=>$unit)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td><a href="{{route('review-detail',$unit->bill_id)}}">{{$unit->bill_id}}</a></td>
                                <td>{{$unit->total}}</td>
                                <td>{{$unit->getCustomerOrder->name}} ({{$unit->getCustomerOrder->phone_no}})</td>
                                <td>{{date('D, j M Y', strtotime($unit->created_at))}} <span class="badge badge-success">{{$unit->created_at->diffForHumans()}}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

@endsection