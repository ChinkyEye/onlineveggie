@extends('frontend.app')
@section('content')
@include('frontend.header');
@foreach($contacts as $data)
<section class="breadcrumb-section set-bg" data-setbg="{{URL::to('/')}}/frontend/img/breadcrumb.jpg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="breadcrumb__text">
					<h2>Contact</h2>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="contact spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-6 text-center">
				<div class="contact__widget">
					<span class="icon_phone"></span>
					<h4>Phone</h4>
					<p>{{$data->phone_no}}</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 text-center">
				<div class="contact__widget">
					<span class="icon_pin_alt"></span>
					<h4>Address</h4>
					<p>{{$data->address}}</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 text-center">
				<div class="contact__widget">
					<span class="icon_clock_alt"></span>
					<h4>Open time</h4>
					<p>{{$data->open_time}}</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 text-center">
				<div class="contact__widget">
					<span class="icon_mail_alt"></span>
					<h4>Email</h4>
					<p>{{$data->email}}</p>
				</div>
			</div>
		</div>
	</div>
</section>
 <!-- Map Begin -->
 <div class="map">
 	<iframe src="{{$data->iframe}}" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
 	
 	<div class="map-inside">
 		<i class="icon_pin"></i>
 		<div class="inside-widget">
 			<h4>Smart Veggies</h4>
 			<ul>
 				<li>Phone: 021403049</li>
 				<li>Add: Godhuli Marg, Biratnagar</li>
 			</ul>
 		</div>
 	</div>
 </div>
 <!-- Map End -->
@endforeach
@endsection