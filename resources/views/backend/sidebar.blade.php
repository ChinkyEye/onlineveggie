<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{url('/')}}/home" class="brand-link">
    <img src="{{url('/')}}/backend/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
    style="opacity: .8">
    <span class="brand-text font-weight-light">{{Auth::user()->getBranch->name}}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{url('/')}}/backend/dist/img/avatar04.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info w-100">
          <a href="#" class="d-inline-block">
            {{Auth::user()->name}}
          </a>
          <i class="fas fa-circle blink text-success mt-2 float-right"></i>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview {!! Request::is('home/customer-creditor') ? 'menu-open' : (Request::is('home/customer-debitor') ? 'menu-open' : '') !!}">
          <a href="#" class="nav-link {!! Request::is('home/customer-creditor') ? 'active' : (Request::is('home/customer-debitor') ? 'active' : '') !!}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Customer
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('/')}}/home/customer-creditor" class="nav-link {!! Request::is('home/customer-creditor') ? 'active' : (Request::is('home/customer-creditor/*') ? 'active' : '')  !!}">
                <i class="far fa-circle nav-icon"></i>
                <p>Creditor</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('/')}}/home/customer-debitor" class="nav-link {!! Request::is('home/customer-debitor') ? 'active' : (Request::is('home/customer-debitor/*') ? 'active' : '')  !!}">
                <i class="far fa-circle nav-icon"></i>
                <p>Debitor</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{url('/')}}/home/unit" class="nav-link {!! Request::is('home/unit') ? 'active' : (Request::is('home/unit/*') ? 'active' : '')  !!}">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Unit
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{url('/')}}/home/category" class="nav-link {!! Request::is('home/category') ? 'active' : (Request::is('home/category/*') ? 'active' : '')  !!}">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Category
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{url('/')}}/home/vegetable" class="nav-link {!! Request::is('home/vegetable') ? 'active' : (Request::is('home/vegetable/*') ? 'active' : '')  !!}">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Vegetable
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{url('/')}}/home/slider" class="nav-link {!! Request::is('home/slider') ? 'active' : (Request::is('home/slider/*') ? 'active' : '')  !!}">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Slider
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{url('/')}}/home/contact" class="nav-link {!! Request::is('home/contact') ? 'active' : (Request::is('home/contact/*') ? 'active' : '')  !!}">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Contact
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{url('/')}}/home/blog" class="nav-link {!! Request::is('home/blog') ? 'active' : (Request::is('home/blog/*') ? 'active' : '')  !!}">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Blog
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>