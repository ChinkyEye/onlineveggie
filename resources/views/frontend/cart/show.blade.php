`@extends('frontend.app')
@section('content')
@include('frontend.header');
<section class="breadcrumb-section set-bg" data-setbg="{{URL::to('/')}}/frontend/img/breadcrumb.jpg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="breadcrumb__text">
					<h2>Shopping Cart</h2>
					<div class="breadcrumb__option">
						<a href="./index.html">Home</a>
						<span>Shopping Cart</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="shoping-cart spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="shoping__cart__table">
					<table>
						<thead>
							<tr>
								<th class="shoping__product">Products</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Total</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($carts as $data)
							<tr>
								<td class="shoping__cart__item">
									<img src="{{URL::to('/')}}/images/vegetable/{{$data->getPurchase->getName->image}}" alt="" style="height:50px;width: 50px">
									<h5>{{$data->getPurchase->getName->display_name}}</h5>
								</td>
								<td class="shoping__cart__price">
									Rs {{$data->getPurchaseHasMin->rate}}
								</td>
								<td class="shoping__cart__total">
									{{$data->quantity}} / {{$data->getPurchase->getUnit->name}}
								</td>
								<td class="shoping__cart__total">
									Rs {{$data->getPurchaseHasMin->rate * $data->quantity}}
								</td>
								<td class="shoping__cart__item__close">
									<a href="#"><span class="icon_close deleteProduct" ids="{{$data->id}}"></span></a>
									<!-- <button class="deleteProduct" ids="{{ $data->id }}" data-token="{{ csrf_token() }}" >Delete Task</button> -->
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="shoping__cart__btns">
					<a href="{{URL::to('/')}}/cart/store" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
					<a href="{{URL::to('/')}}/cart/proceed" class="primary-btn cart-btn cart-btn-right "><span class="icon_loading"></span>
					Proceed Checkout</a>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
@section('javascript')
<script type="text/javascript">
	$('.cart-btn').on('click',function(){
		Swal.fire({
			position: 'down-end',
			icon: 'success',
			title: 'Thank You For Using',
			showConfirmButton: false,
			timer: 4500
		})
	})
</script>

<script type="text/javascript">
	$(".deleteProduct").click(function(e){
		var id = $(event.target).attr('ids');
		var token = $('meta[name="csrf-token"]').attr('content');
		var url = "{{URL::to('/')}}/cart/delete/" + id;
		debugger;
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
				$.ajax(
				{
					url: url,
					type: 'GET',
					dataType: "JSON",
					data: {
						"id": id,
						"_token": token,
					},
					success:function(e){
						location.reload();
						Swal.fire(
							'Deleted!',
							'Your file has been deleted.',
							'success'
							)
					},
					error: function (e) {
						alert('Sorry! this data is used some where');
						Pace.start();
					}
				});
			}
		})
		
	});
</script>
@endsection

