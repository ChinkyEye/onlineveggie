<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}/manager" class="brand-link">
      <img src="{{url('/')}}/backend/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{Auth::user()->getBranch->name}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('/')}}/backend/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
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
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview {!! Request::is('manager/customer-creditor') ? 'menu-open' : (Request::is('manager/customer-debitor') ? 'menu-open' : '') !!}">
            <a href="#" class="nav-link {!! Request::is('manager/customer-creditor') ? 'active' : (Request::is('manager/customer-debitor') ? 'active' : '') !!}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Customer
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/')}}/manager/customer-creditor" class="nav-link {!! Request::is('manager/customer-creditor') ? 'active' : (Request::is('manager/customer-creditor/*') ? 'active' : '')  !!}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Creditor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/')}}/manager/customer-debitor" class="nav-link {!! Request::is('manager/customer-debitor') ? 'active' : (Request::is('manager/customer-debitor/*') ? 'active' : '')  !!}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Debitor</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{url('/')}}/manager/unit" class="nav-link {!! Request::is('manager/unit') ? 'active' : (Request::is('manager/unit/*') ? 'active' : '')  !!}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Unit
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/')}}/manager/category" class="nav-link {!! Request::is('manager/category') ? 'active' : (Request::is('manager/category/*') ? 'active' : '')  !!}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Category
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/')}}/manager/vegetable" class="nav-link {!! Request::is('manager/vegetable') ? 'active' : (Request::is('manager/vegetable/*') ? 'active' : '')  !!}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Vegetable
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview {!! Request::is('manager/purchase/entry') ? 'menu-open' : (Request::is('manager/purchase/view') ? 'menu-open' : '')  !!}">
            <a href="#" class="nav-link {!! Request::is('manager/purchase/entry') ? 'active' : (Request::is('manager/purchase/view') ? 'active' : '')  !!}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Purchase
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/')}}/manager/purchase/entry" class="nav-link {!! Request::is('manager/purchase/entry') ? 'active' : (Request::is('manager/purchase/entry/*') ? 'active' : '')  !!}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Entry</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/')}}/manager/purchase/view" class="nav-link {!! Request::is('manager/purchase/view') ? 'active' : (Request::is('manager/purchase/view/*') ? 'active' : '')  !!}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>