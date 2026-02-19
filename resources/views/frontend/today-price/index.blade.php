@extends('frontend.app')
@section('content')
@include('frontend.header');
<section class="breadcrumb-section set-bg" data-setbg="{{URL::to('/')}}/frontend/img/breadcrumb.jpg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="breadcrumb__text">
					<h2>Today Price</h2>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
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
            </div>
        </div>
    </section>
@endsection
