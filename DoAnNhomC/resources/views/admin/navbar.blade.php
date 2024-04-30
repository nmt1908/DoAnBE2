<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Shop :: Administrative Panel</title>
    <!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin-acess/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-acess/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-acess/css/custom.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Right navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
		</ul>
		<div class="navbar-nav pl-2">
		</div>

		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" data-widget="fullscreen" href="#" role="button">
					<i class="fas fa-expand-arrows-alt"></i>
				</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
					<img src="{{ asset('admin-acess/img/avatar5.png') }}" class='img-circle elevation-2' width="40" height="40" alt="">
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
					<h4 class="h4 mb-0"><strong>{{ Auth::user()->name }}</strong></h4>
					<div class="mb-3">{{ Auth::user()->email }}</div>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item">
						<i class="fas fa-user-cog mr-2"></i> Settings
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item">
						<i class="fas fa-lock mr-2"></i> Change Password
					</a>
					<div class="dropdown-divider"></div>
					<a href="{{route('signout')}}" class="dropdown-item text-danger">
						<i class="fas fa-sign-out-alt mr-2"></i> Logout
					</a>
				</div>
			</li>
		</ul>
	</nav>

    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="{{ asset('admin-acess/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">LARAVEL SHOP</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.listcategories') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ asset('admin-acess/subcategory.html') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Sub Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ asset('admin-acess/brands.html') }}" class="nav-link">
                            <i class="fas fa-layer-group nav-icon"></i>
                            <p>Brands</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ asset('admin-acess/products.html') }}" class="nav-link">
                            <i class="nav-icon fas fa-tag"></i>
                            <p>Products</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-truck nav-icon"></i>
                            <p>Shipping</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ asset('admin-acess/orders.html') }}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ asset('admin-acess/discount.html') }}" class="nav-link">
                            <i class="nav-icon  fa fa-percent" aria-hidden="true"></i>
                            <p>Discount</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.listuser') }}" class="nav-link">
                            <i class="nav-icon  fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ asset('admin-acess/pages.html') }}" class="nav-link">
                            <i class="nav-icon  far fa-file-alt"></i>
                            <p>Pages</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2022 AmazingShop All rights reserved.
    </footer>
</div>
<script src="{{ asset('admin-acess/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin-acess/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin-acess/js/adminlte.min.js') }}"></script>
<script src="{{ asset('admin-acess/js/demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
