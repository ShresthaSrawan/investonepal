@extends('default')

@section('title')
	Login
@endsection

@section('content')
	<div class="login-box">
		<div class="login-logo">
			<a href="{{url('/')}}"><b>Nepal</b>ShareMarket</a>
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">Sign in to start your session</p>
			<form action="{{route('request-login')}}" method="post" autocomplete="off">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="form-group has-feedback">
					<input type="text" class="form-control" placeholder="Email" name="email">
					<span class="help-block">{{$errors->first('email')}}</span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" class="form-control" placeholder="Password" name="password">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					<span class="help-block">{{$errors->first('password')}}</span>
				</div>
				<div class="row">
					<div class=" col-xs-offset-8 col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
					</div><!-- /.col -->
				</div>
			</form>
		</div><!-- /.login-box-body -->
	</div>

@endsection
