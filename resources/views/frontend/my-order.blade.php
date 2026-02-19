@extends('frontend.app')
@section('content')
@include('frontend.header')
<section class="breadcrumb-section set-bg" data-setbg="{{URL::to('/')}}/frontend/img/breadcrumb.jpg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="breadcrumb__text">
					<h2>Your Order</h2>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="checkout spad">
        <div class="container">
            <!-- <div class="checkout__form">
                <h4>Order Details</h4>
                <form action="#">
                    <div class="row">
                    	@foreach($orders as $order)
                        <div class="col-md-4">
                            <div class="checkout__order">
                                <div class="checkout__order__products">Bill ID <span><a href="{{url('/')}}/my-order/{{$order->bill_id}}"> {{$order->bill_id}}</a></span></div>
                                <div class="checkout__order__products">Date <span>{{$order->date}}</span></div>
                                <div class="checkout__order__products">Date <span>{{$order->total}}</span></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div> -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Order Details</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Bill ID</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th>Status</th>
                      <!-- <th class="text-center">Delivered</th>
                      <th class="text-center">Seen</th>
                      <th class="text-center">Confirmed</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                    <tr>
                      <td><a href="{{url('/')}}/my-order/{{$order->bill_id}}">{{$order->bill_id}}</a></td>
                      <td>{{$order->date}}</td>
                      <td>{{$order->updated_at->diffForHumans()}}</td>
                      <td>{{$order->orderDetail->get(0)->quantity}}</td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20">{{$order->total}}</div>
                      </td>
                      <td>
                        @if($order->is_seen == '0' && $order->is_confirmed == '0'  && $order->is_deliverd == '0')
                        <span class="badge badge-success">Not Seem</span>
                        @elseif($order->is_seen == '1' && $order->is_confirmed == '0'  && $order->is_deliverd == '0')
                        <span class="badge badge-success">Not Confirmed</span>
                        @elseif($order->is_seen == '1' && $order->is_confirmed == '1'  && $order->is_deliverd == '0')
                        <span class="badge badge-success">Confirmed</span>
                        @elseif($order->is_seen == '1' && $order->is_confirmed == '1'  && $order->is_deliverd == '1')
                        <span class="badge badge-success">Delivered</span>
                        @endif
                      </td>
                      <!-- <td class="text-center">
                        <i class="{{ $order->is_deliverd == '1' ? 'text-success && fa fa-check':'text-danger && fa fa-times'}}" title="{{$order->is_deliverd == '1' ? 'Is Delivered' : 'Not Delivered'}}"></i>
                      </td>
                      <td class="text-center">
                        <i class="{{ $order->is_seen == '1' ? 'text-success && fa fa-check':'text-danger && fa fa-times'}}" title="{{$order->is_seen == '1' ? 'Is Seen' : 'Not Seen'}}"></i>
                      </td>
                      <td class="text-center">
                        <i class="{{ $order->is_confirmed == '1' ? 'text-success && fa fa-check':'text-danger && fa fa-times'}}" title="{{$order->is_confirmed == '1' ? 'Is Confirmed' : 'Not Confirmed'}}"></i>
                      </td> -->
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
            </div>
        </div>
    </section>
@endsection