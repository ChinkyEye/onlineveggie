<header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> onlinevegg@gmail.com</li>
                                <li>Free Home Delivery with 100% Replacement</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </div>
                            @if(Auth::check())
                            <div class="header__top__right__language">
                                    <div>{{Auth::user()->name}}</div>
                                    <span class="arrow_carrot-down"></span>
                                    <ul style="width: 200px">
                                        <li><a href="{{ route('profile')}}"><i class="fa fa-users mr-2" aria-hidden="true"></i>Profile</a></li>
                                        <li><a href="{{route('cart-show')}}"><i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>Cart</a></li>
                                        <li><a href="{{ route('myOrder')}}"><i class="fa fa-shopping-basket mr-2" aria-hidden="true"></i>My Order</a></li>
                                        <li><a href="{{route('change-password')}}"><i class="fa fa-unlock mr-2"></i>Change Password</a></li>
                                        <li>
                                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out mr-2"></i> Logout</a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                            </div>
                            @else
                            <div class="header__top__right__auth">
                                 <div class="row">
                                    <a href="{{route('login')}}"><i class="fa fa-user"></i>Login</a> &nbsp;&nbsp;&nbsp;  <a href="{{route('register')}}"><i class="fa fa-user-plus"></i>Register</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="./index.html"><img src="{{ URL::to('/')}}/frontend/img/onlinevegg2.png" style="width: 70px;height: 50px" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="{{URL::to('/')}}">Home</a></li>
                            <li><a href="{{URL::to('/')}}/price">Today Price</a></li>
                            <li><a href="{{URL::to('/')}}/blog">Blog</a></li>
                            <li><a href="{{URL::to('/')}}/contact">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-2">
                    @if(Auth::check())
                    <div class="header__cart">
                        <ul>
                            <li><a href="{{URL::to('/')}}/cart"><i class="fa fa-shopping-bag"></i> <span>{{$carts->count()}}</span></a></li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>