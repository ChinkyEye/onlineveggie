@extends('frontend.app')
@section('content')
@include('frontend.header')
<section class="breadcrumb-section set-bg" data-setbg="{{URL::to('/')}}/frontend/img/breadcrumb.jpg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="breadcrumb__text">
					<h2>Profile</h2>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="checkout spad">
        <div class="container" style="border: 1px solid">
        	<div class="checkout__form">
                    <div class="row">
                    	<!-- <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Personal Details</h4>
                                <ul>
                                	@foreach($users as $data)
                                    <li>Name<span>{{$data->name}}</span></li>
                                    <li> Phone No. <span>{{$data->phone_no}}</span></li>
                                    <li>Email <span>{{$data->email}}</span></li>
                                    <li>Address <span>{{$data->getAddress->name}}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div> -->
                        <div class="col-lg-4 col-md-6 text-center" style="border: 1px double #138496;background-color: #fff;">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12" style="background-color: #17a2b8;height: 150px"></div>
                            </div>
                            <div class="row user-detail" style="margin:-50px 0px 30px 0px;">
                                @foreach($users as $data)
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <img src="{{URL::to('/')}}/frontend/img/avatar04.png" class="rounded-circle img-thumbnail">
                                    <h5>{{$data->name}}</h5>
                                    <hr>
                                    <a href="#" class="btn btn-success btn-sm">View Profile</a>
                                    <a href="#" class="btn btn-info btn-sm">Change Profile</a>
                                    <hr>
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"><span class="float-left text-danger">
                                                <i class="fa fa-home" aria-hidden="true"></i>
                                            </span>{{$data->getAddress->name}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" href="#"><span class="float-left text-danger">
                                            <i class="fa fa-envelope-open" aria-hidden="true"></i>
                                            </span>{{$data->email}}
                                        </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"><span class="float-left text-danger">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            </span>{{$data->phone_no}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-6">
                        	<h4>About Me</h4>
                            <form role="form" method="POST" action="{{URL::to('/')}}/profile/{{$data->id}}/update">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Full Name<span>*</span></p>
                                                <input type="text" value="{{$data->name}}" name="name" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Address<span>&nbsp;*</span></p>
                                                <select name="address" class="form-control" >
                                                    @foreach($users as $data)
                                                    <option value="{{$data->address_id}}">{{$data->getAddress->name}}</option>
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Phone<span>*</span></p>
                                                <input type="text" value="{{$data->phone_no}}" name="phone_no">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Email<span>&nbsp;readonly</span></p>
                                                <input type="text" value="{{$data->email}}" readonly="true" name="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="site-btn">SUBMIT CHANGE</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </section>
@endsection