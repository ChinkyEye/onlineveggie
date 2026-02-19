@extends('frontend.app')
@section('content')
@include('frontend.header')
<section class="checkout spad">
	<div class="container">
		<div class="card">
			<div class="card-header border-transparent">
				<h3 class="card-title">Total Items</h3>

			</div>
			<!-- /.card-header -->
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table m-0">
						<thead>
							<tr>
								<th>Vegetables</th>
								<th>Quantity</th>
								<th>Rate</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach($orders as $order)
							<tr>
								<td>{{$order->getName->display_name}}</td>
								<td>
									{{$order->quantity}}
								</td>
								<td>
									{{$order->rate}} {{$order->getUnit->name}}
								</td>
								<td>
									Rs {{$order->total}}
								</td>
							</tr>
							@endforeach
							<tr>
								<td><strong>Total</strong></td>
								<td></td>
								<td></td>
								<td>Rs {{$orders->sum('total')}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- <div class="card-footer">Total <span style="position:absolute; right:150px;">Rs {{$orders->sum('total')}}</span></div> -->

		</div>
	</div>
</section>
@endsection