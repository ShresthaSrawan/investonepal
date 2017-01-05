@extends('front.main')

@section('title')
{{$user->username}}
@endsection

@section('specificheader')
<style type="text/css">
.glyphicon {  margin-bottom: 10px;margin-right: 10px;}

small {
display: block;
line-height: 1.428571429;
color: #999;
}

.well{
	background-color: #fff;
}

[data-type=buy]{
    background-color: #18bc9c !important;
}
[data-type=sell]{
	background-color: #e74c3c !important;
}
[data-type=hold]{
	background-color: #ecf0f1 !important;
}

.review-type{
	border: 1px solid #fff;
	padding: 2px 6px;
}
</style>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		@if(Session::has('danger'))
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Danger!</h4>
				{{Session::get('danger')}}
			</div>
	    @elseif(Session::has('success'))
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4>	<i class="icon fa fa-check"></i> Success!</h4>
				{{Session::get('success')}}
			</div>
	    @endif
   	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Your Reviews</h3>
			</div>
			<div class="panel-body" style="padding:5px;">
				@foreach($reviews as $rev)
					<?php
						if($rev->type == 'b'):
		                    $dataType = 'buy';
		                elseif($rev->type == 's'):
		                    $dataType = 'sell';
		                elseif($rev->type == 'h'):
		                    $dataType = 'hold';
		                endif;
	                ?>
					<div class="panel panel-default panel-review no-margin">
						<div class="panel-heading" data-type="{{$dataType}}">
							<div class="row">
								<div class="col-xs-8">
									<h3 class="panel-title">
										<a href="{{route('quote',$rev->company->quote)}}" class="link" target="_blank"> 
											{{$rev->company->name}}
										</a>
									</h3>
								</div>
								<div class="col-xs-4">
									<span class="pull-right">
										@if($rev->up_user_id != "" || $rev->up_user_id != NULL)
			                            	<span class="up-count"><i class="fa fa-thumbs-up"></i> {{count(explode(",",$rev->up_user_id))-1}}</span>
										@endif
										<span class="review-type">{{strtoupper($dataType)}}</span>
		                            </span>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<p class="lead text-justify no-margin">{{$rev->review}}</p>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6">
	    <div class="well well-sm">
	        <div class="row">
	            <div class="col-sm-6 col-md-4">
	            	@if($user->profile_picture !="" && $user->profile_picture !=NULL)
	            		<img src="{{$user->getThumbnail(500,380)}}" alt="profile_picture" class="img-rounded img-responsive" />
	                @else
	                	<img src="{{url('/')}}/profile_picture/placeholder-user.png" alt="profile_picture" class="img-rounded img-responsive" />
	                @endif
	            </div>
	            <div class="col-sm-6 col-md-8">
	            	<div class="pull-right">
		                <a href="{{route('user.profile.edit')}}" class="btn btn-sm btn-primary">
							Edit Profile
		                </a>
		           	</div>
	            	<h4>{{$user->username}}</h4>

	                @if($user->userInfo->address != "" || $user->userInfo->address != NULL)
	                	<small><cite title="{{$user->address}}">{{$user->userInfo->address}} <i class="glyphicon glyphicon-map-marker"></i></cite></small>
	                @endif
	                <p>
	                    @if($user->userInfo->first_name != "" && $user->userInfo->last_name != "" || $user->userInfo->first_name != NULL && $user->userInfo->last_name != NULL)
	                    	<i class="glyphicon glyphicon-user"></i> {{$user->userInfo->first_name}} {{$user->userInfo->last_name}}
	                    @endif
	                    <br />
	                    <i class="glyphicon glyphicon-envelope"></i> {{$user->email}}
	                    <br />
	                    @if($user->userInfo->dob != "" && $user->userInfo->dob != null && $user->userInfo->dob != "0000-00-00")
	                    	<i class="glyphicon glyphicon-gift"></i> {{date_create($user->userInfo->dob)->format('M d, Y')}}
	                    <br />
	                    @endif
	                    @if($user->userInfo->phone !="" || $user->userInfo->phone !=NULL)
							<i class="glyphicon glyphicon-phone-alt"></i> {{$user->userInfo->phone}}
						<br />
	                    @endif
	                </p>
	            </div>
	        </div>
	    </div>
	</div>
</div>
@endsection

@section('endscript')
@endsection