<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Investo Nepal | @yield('title')</title>
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
    {!! HTML::style('assets/dist/css/AdminLTE.min.css') !!}
    {!! HTML::style('assets/dist/css/skins/skin-black.min.css') !!}
    {!! HTML::style('assets/nsm/member/css/members.master.css') !!}

    @yield('specificheader')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      .content-wrapper i.fa { font-size: 1.2em; }
    </style>
</head>
<body class="sidebar-mini fixed skin-black">
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
            <!-- Navbar Right Menu -->
            <div class="collapse navbar-collapse" style="margin-right: 20px">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-fw fa-user"></i>{{strtoupper(Auth::user()->username)}}<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('user.profile')}}" target="_blank"><i class="fa fa-fw fa-shield"></i> Profile</a></li>
                            <li class="divider"></li>
                            <li>
                                {!! Form::open(['route'=>'admin.logout']) !!}
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
    @include('members.layout.partials.sidebar')

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
@yield('modal')
<!-- REQUIRED JS SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.6/jquery.slimscroll.min.js" type="text/javascript"></script>
{!! HTML::script('assets/dist/js/app.min.js') !!}
{!! HTML::script('assets/nsm/member/js/members.master.js') !!}

@yield('endscript')
</body>
</html>
