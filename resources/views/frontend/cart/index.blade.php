@extends('frontend.app')
@section('content')
 <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            @foreach($data_lists as $lists)
                            <img class="product__details__pic__item--large"
                                src="{{URL::to('')}}/images/vegetable/{{$lists->getName->image}}" alt="">
                                @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>Vetgetable</h3>
                        @foreach($data_lists as $lists)
                        <form role="form" method="POST" action="{{URL::to('/')}}/cart/store" >
                        	{{csrf_field()}}
                        	<div class="modal-body">
                        		<!-- form start -->
                        		<div class="form-group">
                        			<input type="hidden" class="form-control" name="purchase_id" id="purchase_id" value="{{$lists->id}}">
                        		</div>
                                <div class="form-group">
                                    <label for="name">Veg Name </label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{$lists->getName->display_name}}">
                                </div>
                        		<div class="form-group">
                        			<label for="quantity">Quantity</label>
                        			<input type="text" class="form-control" name="quantity" id="quantity" autocomplete="off">
                        		</div>
                                <!-- <div class="form-group">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="1" name="quantity">
                                        </div>
                                    </div>
                                </div> -->
                        	</div>
                        	<div class="modal-footer">
                        		<button type="submit" class="btn btn-primary">ADD TO CARD</button>
                        		<a href="#" class="btn btn-info">BUY NOW</a>
                        	</div>
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection