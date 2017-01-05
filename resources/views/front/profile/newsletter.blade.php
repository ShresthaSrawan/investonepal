@extends('front.main')

@section('title')
{{$user->username}}
@endsection

@section('specificheader')
{!! HTML::style('vendors/iCheck/skins/all.css') !!}
<style type="text/css">
	section.row{
		padding: 15px 0px;
	}
	.dt .dd{
		margin-bottom: 10px;
	}
	.alert-validation{
		border: 1px solid #e74c3c;
	}
</style>
@endsection

@section('content')
<section class="row main-content">
	<div class="col-md-3 hidden-xs hidden-sm">
		<div class="list-group">
			<a href="#" class="list-group-item disabled">
				Account Features
			</a>
			<a href="{{route('user.profile.edit')}}" class="list-group-item">Edit Profile</a>
			<a href="{{route('user.profile.newsletter')}}" class="list-group-item active">Newsletter</a>
			<a href="#" class="list-group-item">Assets Management</a>
			<a href="{{route('watchlist')}}" class="list-group-item">Watchlist</a>
		</div>
	</div>
	<div class="col-md-9 col-xs-12">
		<div class="row">
			{!! Form::model($user, ['route' => ['user.profile.newsletter'],'class'=>'form-horizontal','method'=>'put']) !!}
			<div class="col-md-2"> 
				<div class="row checkbox">
					<label>
						{!! Form::checkbox('subscribed','1',null) !!} <strong>Subscribe</strong>
					</label>
				</div>
			</div>
			<div class="col-md-10 hidden-sm hidden-xs">
				<blockquote><p>Get daily and weekly updates on watchlisted companies by subscribing to the newsletter. Newsletter will be emailed to your registed email address.</p></blockquote>
			</div>
			<div class="col-md-12 form-submit"> 
				{!! Form::submit('Save',['class'=>'btn btn-sm btn-primary pull-left']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</section>
@endsection

@section('endscript')
{!! HTML::script('vendors/iCheck/icheck.min.js') !!}
<script type="text/javascript">
	$(document).ready(function(){
	    $('input').iCheck({
	       checkboxClass: 'icheckbox_square',
	    });    
	});
</script>
@endsection