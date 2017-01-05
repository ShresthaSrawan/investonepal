@extends('front.main')

@section('title')
{{$user->username}}
@endsection

@section('specificheader')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.2.7/css/fileinput.min.css" rel="stylesheet" type="text/css">
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
			<a href="{{route('user.profile.edit')}}" class="list-group-item active">Edit Profile</a>
			<a href="{{route('user.profile.newsletter')}}" class="list-group-item">Newsletter</a>
			<a href="#" class="list-group-item">Assets Management</a>
			<a href="{{route('watchlist')}}" class="list-group-item">Watchlist</a>
		</div>
	</div>
	<div class="col-md-9 col-xs-12">
	@include('front.partials.validation')
	{!! Form::model($user, ['route' => ['user.profile.update'],'files'=>true,'class'=>'form-horizontal','method'=>'put']) !!}
		<div class="row dt">
		    <div class="col-md-12 dd">
		        {!! Form::label('username', 'Username') !!}
		        {!! Form::text('username',old('username'),['class'=>'form-control','placeholder'=>'Eg. why9edm']) !!}
		    </div>
		    <div class="col-md-12 dd">
		    	{!! Form::label('profile_picture', 'Profile Picture (Max: 2 MB)') !!}
		        {!! Form::input('file','profile_picture',old('profile_picture'),['class'=>'form-control file']) !!}
		    </div>
		    <div class="col-md-6 dd">
		        {!! Form::label('first_name', 'First Name') !!}
		        {!! Form::text('userInfo[first_name]',old('first_name'),['class'=>'form-control','placeholder'=>'Eg. Ikari']) !!}
		    </div>
		    <div class="col-md-6 dd">
		        {!! Form::label('last_name', 'Last Name') !!}
		        {!! Form::text('userInfo[last_name]',old('last_name'),['class'=>'form-control','placeholder'=>'Eg. Shinji']) !!}
		    </div>
		    <div class="col-md-6 dd">
		        {!! Form::label('address', 'Address') !!}
		        {!! Form::text('userInfo[address]',old('address'),['class'=>'form-control','placeholder'=>'Eg. Osaka, Japan']) !!}
		    </div>
		    <div class="col-md-6 dd">
		        {!! Form::label('dob', 'Date of Birth') !!}
		        {!! Form::input('date','userInfo[dob]',old('dob'),['class'=>'form-control']) !!}
		    </div>
		    <div class="col-md-6 dd">
		        {!! Form::label('email', 'E-Mail') !!}
		        {!! Form::text('email',old('email'),['class'=>'form-control','placeholder'=>'Eg. ikari@shinji.com']) !!}
		    </div>
		    <div class="col-md-6 dd">
		        {!! Form::label('phone', 'Phone No.') !!}
		        {!! Form::text('userInfo[phone]',old('phone'),['class'=>'form-control','placeholder'=>'Eg. XXX-XXXXXXXXXX']) !!}
		    </div>
		    <div class="col-md-6 dd">
		        {!! Form::label('password', 'New Password') !!}
		        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Eg. Secret password']) !!}
		    </div>
		    <div class="col-md-6 dd">
		        {!! Form::label('password_confirmation', 'Password Conformation') !!}
		        {!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Eg. Secret Password']) !!}
		    </div>
		    <div class="col-md-12 dd">
	            <a href="{{route('user.profile')}}" class="btn btn-default pull-left">Cancel</a>
	            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
	        </div>
		</div>
	{!! Form::close() !!}
	</div>
</section>
@endsection

@section('endscript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.2.7/js/fileinput.min.js" type="text/javascript"></script>
@endsection