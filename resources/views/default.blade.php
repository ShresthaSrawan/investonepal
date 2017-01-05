<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>NSM | @yield('title')</title>
    <meta name="_token" content="{{csrf_token()}}" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    {!! HTML::style('assets/dist/css/AdminLTE.min.css') !!}
    {!! HTML::style('vendors/bootstrap/css/bootstrap.css') !!}
    <link href="{{URL::asset('assets/ionicons/css/ionicons.min.css')}}" rel="stylesheet" type="text/css" />
    @yield('style')
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    @include('admin.partials.alerts')

    @yield('content')
    <!-- REQUIRED JS SCRIPTS -->
    {!! HTML::script('vendors/jquery/jquery.js') !!}
    {!! HTML::script('vendors/bootstrap/js/bootstrap.js') !!}
    {!! HTML::script('assets/dist/js/app.min.js') !!}

    @yield('script')

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>
