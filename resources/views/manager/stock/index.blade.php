@extends('manager.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center my-md-0 font-weight-bold float-none text-danger">Price List of Grocery Items, Vegetables and Fruits on : {{date('d M, Y')}}</div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($data_lists as $list)
                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-body p-0 d-flex justify-content-center">
                                <img src="{{url('/')}}/images/vegetable/{{$list->getName->image}}" class="img-fluid p-2 stock-img">
                            </div>
                            <div class="card-footer text-center p-0">
                                <h6 class="bg-gray-dark color-palette py-1 m-0">{{$list->getName->display_name}}</h6>
                                <p class="m-0 py-1 text-danger font-weight-bold">Rs. {{$list->getPurchaseMinLatestI->rate}} / {{$list->getPurchaseMinLatestI->getUnit->name}}</p>
                            </div>
                        </div>
                    </div>    
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
              {!! $data_lists->links("pagination::bootstrap-4") !!}
            </div>
        </div>
    </div>
</div>
@endsection