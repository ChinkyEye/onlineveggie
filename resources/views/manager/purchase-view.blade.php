@extends('manager.app')
@section('css')
<link rel="stylesheet" href="{{url('/')}}/backend/css/alertify.min.css">
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
        <form role="form" method="POST" action="{{route('item-purchase-search')}}" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Search Form</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
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
                    <div class="col-md">
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
                    <div class="col-md">
                        <div class="form-group">
                            <label>Date:</label>
                            <input type="text" class="form-control" name="from_date" id="date" placeholder="Enter date..." autocomplete="off"  value="{{old('date')}}">
                        </div>
                    </div>
                    <!-- <div class="col-sm-3">
                        <div class="form-group">
                            <label>Date To:</label>
                            <input type="text" class="form-control" name="to_date" id="date1" placeholder="Enter date..." autocomplete="off"  value="{{old('date')}}">
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-info">Search Now!</button>
            </div>
        </div>
        </form>
        <div class="card">
            <div class="card-header">
                <form method="GET" action="{{route('purchase-date')}}">
                <div class="row">
                <h3 class="card-title col-md-3 mt-2">Purchase list of {{$date}}</h3>
                <div class="col-md">
                    <div class="form-group">
                        <input type="text" class="form-control" name="dateseach" id="dateseach" placeholder="Enter date..." autocomplete="off"  value="{{old('dateseach')}}">
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name..." autocomplete="off"  value="{{old('name')}}">
                    </div>
                </div>
                <div class="col-md">
                    <button type="submit" class="btn btn-info">Search Now!</button>
                </div>
                </div>
                </form>
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
                                <th>Name</th>
                                <th>Code</th>
                                <th>Weight</th>
                                <th>B Amt</th>
                                <th>Total</th>
                                <th>Cat</th>
                                <th>From</th>
                                <th>Manage</th>
                                <th>Out</th>
                                <th>Latest Price/Unit</th>
				<th>Date</th>
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
                                <td>
                                    @if($purchase->getCategory->name == "Vegetable")
                                        veg
                                    @elseif($purchase->getCategory->name == "Fruits")
                                        frt
                                    @else
                                        {{$purchase->getCategory->name}}
                                    @endif
                                </td>
                                <td>{{$purchase->getPurchase->name}}</td>
                                <td><a href="{{url('/')}}/manager/purchase/view/manage/{{$purchase->id}}"><i class="fas fa-check"></i></a>({{$purchase->getPurchaseCount()->count()}})</td>
                                <td>
                                    @if($purchase->getPurchaseOut()->count() || $purchase->is_out)
                                    <a href="javascript:void(0)"><i class="fas fa-eye"></i></a>
                                    <!--  -->
                                    ({{$purchase->getPurchaseOut()->select('weight')->value('weight')}} {{$purchase->getUnit->name}})
                                    @else
                                    <a href="javascript:void(0)" class="mark_out" id="{{$purchase->id}}"><i class="fas fa-check"></i></a>
                                    @endif
                                </td>
                                @if($purchase->getPurchaseMin()->count())
                                @foreach($purchase->getPurchaseMinLatest()->get()->take(1) as $pur)
                                <td>
                                   {{$pur->rate}}/{{$pur->getUnit->name}}
                                </td>
				<td>{{$pur->created_at}}</td>
                                @endforeach
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <nav class="text-center">
                        <!-- {!! str_replace('/?', '?', $purchases->render()) !!} -->
                        {!! str_replace('/?', '?', $purchases->links()) !!}
                    </nav>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script src="{{url('/')}}/backend/js/alertify.min.js"></script>
<script type="text/javascript">
  // goes to category controller
  $("body").on("click", ".mark_out", function(event){
        var id = $(event.target).parent().attr("id");
        token=$(".token").val();

        alertify.confirm("Are you sure you want to make stock out?",function(){
            url= "{{route('purchase-make_out')}}",
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