@extends('backend.app')
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
        <div class="card-header">
                <h3 class="card-title">@foreach($item_details as $item) {{$item->getName->display_name}} {{$item->weight}} {{$item->getUnit->name}} @endforeach</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{route('admin-purchase-manage-store', $id)}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Quantity:</label>
                                <input type="text" class="form-control" name="quantity" id="reservation" placeholder="Enter quantity..." autocomplete="off"  value="{{old('quantity')}}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Unit:</label>
                                <select class="form-control" name="unit_id">
                                    <option value="">--Please select--</option>
                                    @foreach($units as $unt=>$unit)
                                    <option value="{{$unit}}" {{old('unit_id') == $unit ?'selected':''}}>{{$unt}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Price:</label>
                                <input type="text" class="form-control" name="price" id="reservation" placeholder="Enter price..." autocomplete="off"  value="{{old('price')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Manage Now!</button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage list {{date('Y/m/d')}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                <table class="table table-bordered table-striped">
                    <thead> 
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Weight</th>
                            <th>Unit</th>
                            <th>Rate</th>
                            <th>Date</th>
                        </tr>                 
                    </thead>
                    <tbody>
                        @foreach($manages as $index=>$manage)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$manage->weight}}</td>
                            <td>{{$manage->getUnit->name}}</td>
                            <td>Rs: {{$manage->rate}}</td>
                            <td>{{date('D, j M Y', strtotime($manage->created_at))}} <span class="badge badge-success">{{$manage->created_at->diffForHumans()}}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection