@extends('manager.app')
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage list {{date('Y/m/d')}}</h3>
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
                                <th>Display Name</th>
                                <th>Code</th>
                                <th>Weight</th>
                                <th>Unit</th>
                                <th>Rate</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>                 
                        </thead>
                        <tbody>
                            @foreach($purchases as $index=>$manage)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$manage->getName->display_name}}</td>
                                <td>{{$manage->purchase_id}}</td>
                                <td>{{$manage->weight}}</td>
                                <td>{{$manage->getUnit->name}}</td>
                                <td>Rs. {{$manage->amount}}</td>
                                <td>Rs. {{$manage->total}}</td>
                                <td>{{date('D, j M Y', strtotime($manage->created_at))}} <span class="badge badge-success">{{$manage->created_at->diffForHumans()}}</span></td>
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
@endsection