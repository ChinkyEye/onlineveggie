@extends('frontend.app')
@section('content')
@include('frontend.header');
	<section class="breadcrumb-section set-bg" data-setbg="{{URL::to('/')}}/frontend/img/breadcrumb.jpg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="breadcrumb__text">
						<h2>Blog</h2>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- Blog Section Begin -->
	<section class="blog spad">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					@foreach($blog as $data)
					<div class="card card-widget">
						<!-- <div class="card-header">
							<div class="user-block">
								<span>Blog Detail</span>
							</div>
						</div> -->
						<div class="card-body">
							<p>{{$data->lg_paragraph}}</p>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</section>
    <!-- Blog Section End -->
@endsection
