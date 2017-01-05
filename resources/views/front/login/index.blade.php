@extends('front.main')

@section('title')
    Login
@endsection

@section('specificheader')
<style type="text/css">
	.tab-content{
	    background-color: #fff;
	}
	.tab-pane{
		padding: 30px 10px;
	}
	section.row>div:nth-child(1){
		padding-top: 25px;
	}
	button.resend {
	    background:none!important;
	    border:none; 
	    padding:0!important;
	    /*border is optional*/
	    border-bottom:1px solid #444; 
	}
</style>
@endsection

@section('content')
	<div class="row">
      	<div class="col-lg-12">
        	<h3>Please Login/Register to continue.</h3>
        </div>
    </div>
  	<div class="row">
		<div class="col-lg-12">
		    @if(Session::has('danger'))
		      <div class="alert alert-danger alert-dismissable">
		        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		        <h4><i class="icon fa fa-ban"></i> {!! Session::get('danger')!!}</h4>
		      </div>
		    @elseif(Session::has('info'))
		      <div class="alert alert-info alert-dismissable">
		        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		        <h4><i class="icon fa fa-info"></i> {!! Session::get('info')!!}</h4>
		      </div>
		    @elseif(Session::has('warning'))
		      <div class="alert alert-warning alert-dismissable">
		        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		        <h4><i class="icon fa fa-warning"></i> {!! Session::get('warning')!!}</h4>
		      </div>
		    @elseif(Session::has('success'))
		      <div class="alert alert-success alert-dismissable">
		        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		        <h4>	<i class="icon fa fa-check"></i> {!! Session::get('success')!!}</h4>
		      </div>
		    @endif
		</div>
	</div>      
    <div class="row">
	    <div class="col-lg-12">
	      	<ul class="nav nav-tabs">
	       		<li class="active"><a href="#login" data-toggle="tab">Login</a></li>
	        	<li><a href="#register" data-toggle="tab">Registration</a></li>
	      	</ul>
	     	<div id="myTabContent" class="tab-content">
			    <div class="tab-pane active in" id="login">
			      <section class="row">
							<div class="col-md-6">
							<form action="{{route('request-login')}}" method="post" autocomplete="off"><input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="form-group col-lg-12 has-feedback">
									<div class="input-group">
										<input type="text" name="login_email" class="form-control" id="" value="" placeholder="Email">
										<span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope"></i>
									</div>
									<span class="help-block">{{$errors->first('email')}}</span>
								</div>
								
								<div class="form-group col-lg-12 has-feedback">
									<div class="input-group">
										<input type="password" class="form-control" placeholder="Password" name="login_password">
										<span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i>
										</span>
									</div>
									<span class="help-block">{{$errors->first('password')}}</span>
								</div>
								<div class="form-group col-lg-12">
									<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
								</div>
								<div class="form-group col-lg-12">
								<!-- forgot Button trigger modal -->
									<a href="javascript:void(0)" data-toggle="modal" data-target="#forgotModal">
									  Forgot Password?
									</a>
								</div>
							</form>
							</div>
						
							<div class="col-md-6">
								<h2 class="dark-grey">Where You Can Get the most up-to-date and relaible data services</h2>
								<p>The best data analysis available in the market.</p>
								<p><a href="#" class="sign-up">Sign up now !!</a></p>
							</div>
					</section>
			    </div>
			    <div class="tab-pane fade" id="register">
			        <section class="row">		
			        	<form action="{{route('register-client')}}" method="post" autocomplete="off"><input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="col-md-6">
								<div class="form-group col-lg-12">
									<label>Username</label>
									<input type="text" name="username" class="form-control" value="{{old('username')}}">
									<span class="help-block">{{$errors->first('username')}}</span>
								</div>

								<div class="form-group col-lg-12">
									<label>Email Address</label>
									<input type="email" name="email" class="form-control" value="{{old('email')}}">
									<span class="help-block">{{$errors->first('email')}}</span>
								</div>
								
								<div class="form-group col-lg-6">
									<label>Password</label>
									<input type="password" name="password" class="form-control" value="{{old('password')}}">
									<span class="help-block">{{$errors->first('password')}}</span>
								</div>
								
								<div class="form-group col-lg-6">
									<label>Repeat Password</label>
									<input type="password" name="password_confirmation" class="form-control" id="" value="">
								</div>
								
								<div class="form-group col-lg-12">
									{!! Form::captcha() !!}
								</div>
								
							</div>

							<div class="col-md-6">
								<h3 class="dark-grey">Terms and Conditions</h3>
								<p>
									By clicking on "Register" you agree to The Company's' Terms and Conditions
								</p>
								<p>
								{{config('investonepal.TERMS_AND_CONDITIONS')}}
								</p>
								
								<button type="submit" class="btn btn-primary">Sign Up</button>
							</div>
							</form>
					</section>
			    </div>
			</div>
	  	</div>
  	</div>
  	<!-- Modal -->
<div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="forgotModalLabel">
	<form action="{{route('reset-password-request')}}" method="post" autocomplete="off"><input type="hidden" name="_token" value="{{csrf_token()}}">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="forgotModalLabel">Reset Password</h4>
      			</div>
      			<div class="modal-body">
        			<div class="row">
	        			<div class="col-sm-12">
				        	<p>
				        		Please enter your account email address and we will send you a password reset link.
				        	</p>
				        	
				        	<div class="input-group">
								<span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope"></i></span>
					          	<input type="email" class="form-control" placeholder="email" name="email_reset">
					        </div>
				        </div>
        			</div>
      			</div>
      			<div class="modal-footer">
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	        		<button type="send" class="btn btn-primary">Send</button>
	      		</div>
    		</div>
  		</div>
    </form>
</div>
@endsection
@section('endscript')
<script type="text/javascript">
	var redirected = {{Session::has('registerURL')?'true':'false'}};

	// Javascript to enable link to tab
	var url = document.location.toString();
	if(redirected){
		$('a[href=#register]').click();
	}else if (url.match('#')) {
	    $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
	} 

	// Change hash for page-reload
	$('.nav-tabs a').on('shown.bs.tab', function (e) {
	    window.location.hash = e.target.hash;
	});
	
	$('.sign-up').click(function(){
		$('a[href=#register]').click();
	});

</script>	
@endsection