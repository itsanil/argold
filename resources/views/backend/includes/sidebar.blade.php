<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  @php($dashboard=route('profile'))
  @if(Gate::check('branch-view'))
  @php($dashboard = route('dashboard.view'))
  @elseif(Gate::check('branch-dashboard'))
  @php($dashboard = route('dashboard.branchView'))
  @elseif(Gate::check('user-dashboard'))
  @php($dashboard = route('dashboard.userView'))  
  @endif
  <a href="{{$dashboard}}" class="brand-link">
    <img src="{{ asset('backend/dist/img/swamijiLogo.jpeg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{route('profile')}}" class="d-block">{{ Auth::user()->name }}
          @if(Auth::user()->hasRole('Branch Admin'))
          / {{ Auth::user()->branchDetail->branch_number }}
          @endif
        </a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <!-- <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div> -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        @if(Gate::check('branch-view') || Gate::check('branch-dashboard') || Gate::check('user-dashboard'))
        <li class="nav-item">
            <a href="{{ $dashboard }}" class="nav-link 
              {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}
              
              ">
            <i class="nav-icon fa fa-home"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        @endif
        <!-- <li class="nav-item {{ (request()->is('admin/branch*') || request()->is('admin/bank*') || request()->is('admin/category*') || request()->is('admin/mode*') || request()->is('admin/user*') || request()->is('admin/client*')) ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link 
            {{ (request()->is('admin/branch*') || request()->is('admin/bank*') || request()->is('admin/category*') || request()->is('admin/mode*') || request()->is('admin/user*') || request()->is('admin/client*')) ? 'active' : '' }}
          ">
            <i class="nav-icon fa fa-table"></i>
            <p>
              Master
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview"> -->
            {{--
            @can('branch-add')
            <li class="nav-item">
              <a href="{{ route('branch.add') }}" class="nav-link {{ (request()->is('admin/branch*')) ? 'active' : '' }}">
                <i class="fa fa-code-branch nav-icon"></i>
                <p>Branches</p>
              </a>
            </li>
            @endcan
            @can('bank-view')
            <li class="nav-item">
              <a href="{{ route('bank.view') }}" class="nav-link {{ (request()->is('admin/bank*')) ? 'active' : '' }}">
                <i class="fas fa-rupee-sign nav-icon"></i>
                <p>Banks</p>
              </a>
            </li>
            @endcan
            @can('category-view')
            <li class="nav-item">
              <a href="{{ route('category.view') }}" class="nav-link {{ (request()->is('admin/category*')) ? 'active' : '' }}">
                <i class="fa fa-list nav-icon"></i>
                <p>Categories</p>
              </a>
            </li>
            @endcan
            @can('mode-view')
            <li class="nav-item">
              <a href="{{ route('mode.view') }}" class="nav-link {{ (request()->is('admin/mode*')) ? 'active' : '' }}">
                <i class="fa fa-snowflake nav-icon"></i>
                <p>Modes</p>
              </a>
            </li>
            @endcan
            --}}
            <li class="nav-item">
              <a href="{{ route('employee.view') }}" class="nav-link {{ (request()->is('admin/employee/*')) ? 'active' : '' }}">
                <i class="fa fa-user nav-icon"></i>
                <p>Employee</p>
              </a>
            </li>
            @can('user-view')
            <li class="nav-item">
              <a href="{{ route('vendor.view') }}" class="nav-link {{ (request()->is('admin/vendor/*')) ? 'active' : '' }}">
                <i class="fa fa-user nav-icon"></i>
                <p>Vendor</p>
              </a>
            </li>
            @endcan
            {{--
            @can('client-view')
            <li class="nav-item">
              <a href="{{ route('client.view') }}" class="nav-link {{ (request()->is('admin/client*')) ? 'active' : '' }}">
                <i class="fa fa-users nav-icon"></i>
                <p>Clients</p>
              </a>
            </li>
            @endcan

          <!-- </ul> -->
        <!-- </li> -->
        <!-- FUNDS -->
        @can('fund-view')
        <li class="nav-item {{ (request()->is('admin/fund*')) ? 'menu-is-opening menu-open' : '' }}
         ">
          <a href="{{ route('fund.view') }}" class="nav-link 
              {{ (request()->is('admin/fund*')) ? 'active' : '' }}
              
              ">
              <i class="nav-icon fa fa-university" area-hidden="true"></i>
              <p>
                Funds Request
              </p>
          </a>
        </li>
        @endcan
        --}}
        <!-- EXPENSE -->
        @can('expense-view')
        <li class="nav-item {{ (request()->is('admin/vendor-payment*')) ? 'menu-is-opening menu-open' : '' }}
         ">
          <a href="{{ route('vendor-payment.add') }}" class="nav-link 
              {{ (request()->is('admin/vendor-payment*')) ? 'active' : '' }}
              
              ">
              <i class="nav-icon fas fa-dollar-sign" area-hidden="true"></i>
              <p>
                Vendor Payment
              </p>
          </a>
        </li>
        @endcan
        {{--
        <!-- WITHDRAWAL -->
        @can('withdrawal-view')
        <li class="nav-item {{ (request()->is('admin/withdrawal*')) ? 'menu-is-opening menu-open' : '' }}
         ">
          <a href="{{ route('withdrawal.view') }}" class="nav-link 
              {{ (request()->is('admin/withdrawal*')) ? 'active' : '' }}
              ">
              <i class="nav-icon fa fa-money-check-alt" area-hidden="true"></i>
              <p>
                Withdrawals
              </p>
          </a>
        </li>
        @endcan

        <!-- DEPOSIT -->
        @can('deposit-view')
        <li class="nav-item {{ (request()->is('admin/deposit*')) ? 'menu-is-opening menu-open' : '' }}
         ">
          <a href="{{ route('deposit.view') }}" class="nav-link 
              {{ (request()->is('admin/deposit*')) ? 'active' : '' }}
              ">
              <i class="nav-icon fa fa-money-bill-alt" area-hidden="true"></i>
              <p>
                Deposits
              </p>
          </a>
        </li>
        @endcan

        <!-- ROLE -->
        @can('role-view')
        <li class="nav-item {{ (request()->is('admin/role*')) ? 'menu-is-opening menu-open' : '' }}
         ">
          <a href="{{ route('role.view') }}" class="nav-link 
              {{ (request()->is('admin/role*')) ? 'active' : '' }}
              ">
              <i class="nav-icon fa fa-user-plus" area-hidden="true"></i>
              <p>
                Roles
              </p>
          </a>
        </li>
        @endcan
        --}}
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>