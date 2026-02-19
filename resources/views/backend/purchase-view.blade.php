@extends('backend.app')
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
        <div class="card-header">
                <h3 class="card-title">Search Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{route('admin-purchase-search')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Purchase From:</label>
                                <select class="form-control" name="purchase_user_id">
                                    <option value="">--Please select--</option>
                                    @foreach($purchase_users as $agent=>$purchase)
                                    <option value="{{$purchase}}" {{old("purchase_user_id") == $purchase ?"selected":''}}>{{$agent}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Category:</label>
                                <select class="form-control" name="category_id">
                                    <option value="">--Please select--</option>
                                    @foreach($categories as $cat=>$category)
                                    <option value="{{$category}}" {{old('category_id') == $category ?'selected':''}}>{{$cat}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Date From:</label>
                                <input type="text" class="form-control" name="from_date" id="reservation" placeholder="Enter date..." autocomplete="off"  value="{{old('date')}}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Date To:</label>
                                <input type="text" class="form-control" name="to_date" id="reservation" placeholder="Enter date..." autocomplete="off"  value="{{old('date')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Search Now!</button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Purchase list {{date('Y/m/d')}} of amount Rs: {{$sum}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
                <table class="table table-bordered table-striped">
                    <thead> 
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Weight</th>
                            <th>Amount</th>
                            <th>Total</th>
                            <th>Category</th>
                            <th>From</th>
                            <th>Manage</th>
                        </tr>                 
                    </thead>
                    <tbody>
                        @foreach($purchases as $index=>$purchase)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$purchase->getName->display_name}}</td>
                            <td>{{$purchase->purchase_id}}</td>
                            <td>{{$purchase->weight}} ({{$purchase->getUnit->name}})</td>
                            <td>Rs: {{$purchase->amount}}</td>
                            <td>Rs: {{$purchase->total}}</td>
                            <td>{{$purchase->getCategory->name}}</td>
                            <td>{{$purchase->getPurchase->name}}</td>
                            <td><a href="{{url('/')}}/home/purchase/view/manage/{{$purchase->id}}"><i class="fas fa-check"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item">{{ $purchases->links() }}</li>
                </ul>
              </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection