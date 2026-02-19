<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block my-auto">
            <a href="{{url('/')}}/manager/order" class="btn btn-sm btn-warning"><span class="text-bold text-primary ">Billing</span></a>
           <a href="{{url('/')}}/manager/review" class="btn btn-sm btn-default"><span class="text-bold text-primary ">Review<span class="badge  text-danger">({{$seen_count}})</span></span></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link rotate" data-toggle="dropdown" href="#">
              <i class="far fa-comments mr-2"></i>Report <i class="rotate-this fas fa-angle-right ml-1"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="{{route('customer-report')}}" class="dropdown-item">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                <i class="fas fa-user-friends mr-2"></i>Customer
                            </h3>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{route('stock-report')}}" class="dropdown-item">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                <i class="fas fa-layer-group mr-2"></i>Stock
                            </h3>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{route('sales-report')}}" class="dropdown-item">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                <i class="fas fa-receipt mr-2"></i>Sales
                            </h3>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{route('purchase-report')}}" class="dropdown-item">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                <i class="fas fa-money-bill-alt mr-2"></i>Purchase
                            </h3>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{route('bill-report')}}" class="dropdown-item">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                <i class="fas fa-file-invoice mr-2"></i>Bill
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link rotate" data-toggle="dropdown" href="#">
                <i class="far fa-user mr-2"></i> {{Auth::user()->name}} <i class="rotate-this fas fa-angle-right ml-2"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="{{route('change-password')}}" class="dropdown-item">
                    <i class="fas fa-unlock-alt mr-2"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{route('today-price',['date','lang'])}}" class="dropdown-item">
                    <i class="fas fa-unlock-alt mr-2"></i> View Today price
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    <i class="fas fa-users mr-2"></i> Logout
                </a>
            </div>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </ul>
</nav>