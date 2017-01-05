<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Investo Nepal : @yield('title')</title>
	<title>@yield('title')</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	{!! HTML::style('vendors/bootstrap/css/bootstrap.css') !!}
	{!! HTML::style('vendors/font-awesome/css/font-awesome.css') !!}
	{!! HTML::style('vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.css') !!}
    {!! HTML::style('vendors/dataTables/DataTables-1.10.9/css/dataTables.bootstrap.css') !!}
	{!! HTML::style('assets/dist/css/AdminLTE.min.css') !!}
	{!! HTML::style('assets/dist/css/skins/skin-blue.min.css') !!}
	{!! HTML::style('assets/nsm/admin/css/style.css') !!}
	{!! HTML::style('assets/nsm/admin/css/global.admin.css') !!}

	
	<style>
		.navbar-nav>.user-menu>.dropdown-menu{
			width: 140px;
		}
		*{
			border-radius: 0 !important;
		}
		a.mobile-logout{
			color: #FFF;
			margin-top: 10px;
		}
		@media(min-width: 480px){
			a.mobile-logout{
				display: none;
			}
		}
	</style>
	@yield('specificheader')
    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="sidebar-mini fixed skin-blue">
<div class="wrapper">
	<!-- Main Header -->
	<header class="main-header">

		<!-- Logo -->
		<a href="{{url('/')}}" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini"><b>I</b>N</span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b>INVESTO</b> NEPAL</span>
		</a>

		<!-- Header Navbar -->
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<a href="{{route('logout')}}" class="btn btn-info mobile-logout">
				<i class="fa fa-logout"></i> Logout
			</a>
			<!-- Navbar Right Menu -->
			<div class="collapse navbar-collapse" style="margin-right: 20px">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-fw fa-user"></i>{{strtoupper(Auth::user()->username)}}<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{{route('user.profile')}}" target="_blank"><i class="fa fa-fw fa-shield"></i> Profile</a></li>
							<li class="divider"></li>
							<li>
								{!! Form::open(['route'=>'logout']) !!}
								<button type="submit" class="btn btn-danger btn-block"><i class="fa fa-fw fa-sign-out"></i> Logout</button>
								{!! Form::close() !!}
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>

	<!-- Sidebar. Sidebar goes here -->
	@include('admin.partials.sidebar')

			<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Main content -->
		<section class="content">
			@include('admin.partials.alerts')
			<!-- Your Page Content Here -->
			@yield('content')
		</section><!-- /.content -->
	</div><!-- /.content-wrapper -->
</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
{!! HTML::script('vendors/jquery/jquery.js') !!}
{!! HTML::script('vendors/bootstrap/js/bootstrap.js') !!}
{!! HTML::script('vendors/moment/moment.min.js') !!}
{!! HTML::script('vendors/dataTables/DataTables-1.10.9/js/jquery.dataTables.min.js') !!}
{!! HTML::script('vendors/dataTables/DataTables-1.10.9/js/dataTables.bootstrap.min.js') !!}
{!! HTML::script('vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.js') !!}
{!! HTML::script('vendors/slimScroll/jquery.slimscroll.min.js') !!}

{!! HTML::script('assets/dist/js/app.min.js') !!}
{!! HTML::script('assets/nsm/admin/js/global.admin.js') !!}
{!! HTML::script('assets/nsm/admin/js/custom.js') !!}

@yield('endscript')
<script type="text/javascript">
	$('form').preventDoubleSubmission();
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
</script>
</body>
</html>