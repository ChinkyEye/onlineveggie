@extends('backend.app')
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@foreach($name as $nam){{$nam->name}} with phone {{$nam->phone_no}}@endforeach</h3>
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
                                <th>Item</th>
                                <th>Item ID</th>
                                <th>Weight</th>
                                <th>Amount</th>
                                <th>Category</th>
                                <th>Created By</th>
                                <th>Created At</th>
                            </tr>                 
                        </thead>
                        <tbody>
                            @foreach($user_details as $index=>$detail)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$detail->getName->display_name}}</td>
                                <td>{{$detail->purchase_id}}</td>
                                <td>{{$detail->weight}} ({{$detail->getUnit->name}})</td>
                                <td>Rs: {{$detail->amount}}</td>
                                <td>{{$detail->getCategory->name}}</td>
                                <td>{{$detail->getUser->name}}</td>
                                <td>{{date('D, j M Y', strtotime($detail->date))}}</td>
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