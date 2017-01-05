@extends('front.main')

@section('title')
	Contact
@endsection

@section('specificheader')
<style type="text/css">
	@media screen and (min-width: 480px) {
	    .vertical-divider{
			border-right: 1px #f1f1f1 solid;
			padding-right: 40px;
		}
		.contact-submit{margin-top:57px;}
	}
	@media screen and (max-width: 480px) {
		.contact-submit{margin:20px 0;}
		.g-recaptcha iframe{width:100%;}
	}
</style>
@endsection

@section('content')
<section class="main-content" style="padding:10px 10px;">
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
		<form role="form" action="" method="post" >
		{!! Form::open(['route'=>'front.contact'])!!}
			<div class="col-lg-6 vertical-divider">
				<div class="well well-sm"><strong><i class="glyphicon glyphicon-asterisk"></i> Required Field</strong></div>
				<div class="form-group">
					<label for="name">Your Name</label>
					<div class="input-group">
						<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
						<span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
					</div>
				</div>
				<div class="form-group">
					<label for="email">Your Email</label>
					<div class="input-group">
						<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required  >
						<span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
					</div>
				</div>
				<div class="form-group">
					<label for="subject">Subject</label>
					<div class="input-group">
						<input type="subject" class="form-control" id="subject" name="subject" placeholder="Enter Subject" required  >
						<span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
					</div>
				</div>
				<div class="form-group">
					<label for="message">Message</label>
					<div class="input-group">
						<textarea name="message" id="message" class="form-control" rows="5" required></textarea>
						<span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-9">
						<label for="captcha">Are you human?</label>
						{!! Form::captcha() !!}
					</div>
					<div class="col-lg-3 contact-submit">
						<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<hr class="featurette-divider hidden-lg">
		<div class="col-lg-5">
			<address>
				<h3>Office Location: InvestoNepal.com</h3>
				<p class="lead">{{config('investonepal.FOOTER_ADDRESS_LINE_1')}}<br>
				{{config('investonepal.FOOTER_ADDRESS_LINE_2')}}</a><br>
				Phone: {{config('investonepal.FOOTER_PHONE_NO')}}<br>
				Email: {{config('investonepal.FOOTER_EMAIL')}}<br>
				Office Time: {{config('investonepal.FOOTER_OFFICE_HOURS')}}</p>
			</address>
		</div>
	</div>
</section>
@endsection

@section('endscript')
@endsection