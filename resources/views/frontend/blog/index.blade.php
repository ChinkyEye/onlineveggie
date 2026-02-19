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
                <div class="col-lg-4 col-md-5">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Categories</h4>
                            @foreach($categories as $category)
                            <ul>
                                <li><a href="#">{{$category->name}}</a></li>
                                <!-- <li><a href="#">Beauty (20)</a></li>
                                <li><a href="#">Food (5)</a></li>
                                <li><a href="#">Life Style (9)</a></li>
                                <li><a href="#">Travel (10)</a></li> -->
                            </ul>
                            @endforeach
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Recent News</h4>
                            <div class="blog__sidebar__recent">
                            	@foreach($blog as $data)
                                <a href="#" class="blog__sidebar__recent__item">
                                    <div class="blog__sidebar__recent__item__pic">
                                        <img src="{{URL::to('/')}}/images/blog/{{$data->image}}" style="width: 50px;height: 50px" alt="">
                                    </div>
                                    <div class="blog__sidebar__recent__item__text">
                                        <h6>{{$data->title}}</h6>
                                        <span>MAR 05, 2019</span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="row">
                    	@foreach($blog as $data)
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="{{URL::to('/')}}/images/blog/{{$data->image}}" style="height: 300px" class="img-thumbnail" alt="">
                                </div>
                                <div class="blog__item__text">
                                    <ul>
                                        <li><i class="fa fa-calendar-o"></i>{{$data->created_at}}</li>
                                        <li><i class="fa fa-comment-o"></i> </li>
                                    </ul>
                                    <h5><a href="#">{{$data->title}}</a></h5>
                                    <p>{{$data->st_paragraph}}</p>
                                    <a href="{{URL::to('/')}}/blog/show" class="blog__btn" id="read">READ MORE <span class="arrow_right"></span></a>
                                    <p class="lg_read">{{$data->lg_paragraph}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#read').click(function(){
            $('lg_read').toggle();
        })
    })
</script>
@endsection
