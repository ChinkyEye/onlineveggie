@extends('frontend.app')
@section('content')
@include('frontend.header');
<section class="breadcrumb-section set-bg" data-setbg="{{URL::to('/')}}/frontend/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Vegetables</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="featured spad">
        <div class="container">
            <div class="row featured__filter">
            	@foreach($vegetables as $vegetable)
                <div class="col-md-2">
                        <div class="card">
                            <div class="card-body p-0 d-flex justify-content-center">
                                <img src="{{url('/')}}/images/vegetable/{{$vegetable->getName->image}}" class="img-fluid p-2 stock-img">
                            </div>
                            <div class="card-footer text-center p-0">
                                <h6 class="bg-gray-dark color-palette py-1 m-0">{{$vegetable->getName->display_name}}</h6>
                                <p class="m-0 py-1 text-danger font-weight-bold">Rs. {{$vegetable->getPurchaseMinLatestI->rate}} / {{$vegetable->getPurchaseMinLatestI->getUnit->name}}</p>
                            </div>
                        </div>
                    </div>  
               <!--  <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__text">
                        	<img src="{{URL::to('/')}}/images/vegetable/{{$vegetable->id}}" class="img-fluid" style="width: 100px;height: 100px">
                            <h6><a href="#">{{$vegetable->display_name}}</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div> -->
                @endforeach
            </div>
        </div>
    </section>
@endsection