<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Vendor CSS -->
    {!! HTML::style('vendors/bootstrap/css/bootstrap.css') !!}
    {!! HTML::style('vendors/font-awesome/css/font-awesome.css') !!}
    <!-- Custom-->
    {!! HTML::style('assets/nsm/css/global.dropdown.css') !!}
    {!! HTML::style('assets/nsm/css/global.front.css') !!}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    @yield('specificheader')
</head>

<body>
<header class="container-fluid">
@include('front.partials.navbar')
</header>
<div class="my-wrapper">
    <div class="container main-content">
    <!-- Page Content -->
        @yield('content')
    </div>
</div>
<!-- /.container -->
<!-- Footer -->
<footer>
    <div class="row">
        <div class="col-lg-12">
            <p style="text-align: center;">Copyright &copy; Your Website 2014</p>
        </div>
    </div>
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
{!! HTML::script('vendors/jquery/jquery.js') !!}
<!-- Include all compiled plugins (below), or include individual files as needed -->
{!! HTML::script('vendors/bootstrap/js/bootstrap.js') !!}
{!! HTML::script('vendors/cbpHorizontalMenu/cbpHorizontalMenu.min.js') !!}

{!! HTML::script('assets/nsm/global.front.js') !!}
<script>
    $(function() {
        cbpHorizontalMenu.init();
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@yield('endscript')
</body>

</html>
