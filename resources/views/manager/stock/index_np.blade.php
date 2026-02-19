@extends('manager.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center my-md-0 font-weight-bold float-none text-danger">Price List of Vegetable and Fruits on : {{date('d M, Y')}}</div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($data_lists as $list)
                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-body p-0 d-flex justify-content-center">
                                <img src="{{URL::to('/')}}/images/vegetable/{{$list->image}}" class="img-fluid p-2 stock-img">
                            </div>
                            <div class="card-footer text-center p-0">
                                <h6 class="bg-gray-dark color-palette py-1 m-0">{{$list->getPurchaseMin->get(0)->date}}</h6>
                                <p class="m-0 py-1 text-danger font-weight-bold">Rs. {{$list->rate}} / {{$list->getUnit->name}}</p>
                            </div>
                        </div>
                    </div>    
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection