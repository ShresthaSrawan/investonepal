@extends('front.main')

@section('title')
    NSM : Reset Password
@endsection

@section('specificheader')
<style type="text/css">
	.tab-content{
	    background-color: #fff;
	}
	.tab-pane{
		padding: 30px 10px;
	}
</style>
@endsection

@section('content')
	<div class="row">
      	<div class="col-lg-12">
        	<h3>Enter new password.</h3>
        </div>
    </div>
	<form action="{{route('reset-password')}}" method="post" autocomplete="off"><input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group col-sm-12 has-feedback">
					<div class="input-group">
						<input type="text" class="form-control" id="" value="{{$user->email}}" placeholder="Username/Email" name="email" readonly>
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope"></i>
					</div>
				</div>
				
				<div class="form-group col-sm-6 has-feedback">
					<div class="input-group">
						<input type="password" class="form-control" placeholder="Password" name="password" value="{{old('password')}}">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i>
						<input type="hidden" name="confirmation_code" value="{{$confirmation_code}}">
						</span>
					</div>
					<span class="help-block">{{$errors->first('password')}}</span>
				</div>

				<div class="form-group col-sm-6 has-feedback">
					<div class="input-group">
						<input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" value="">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-sm-6 has-feedback">
				<div class="form-group col-sm-6">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
				</div>
	    	</div>
    	</div>
	</form>
@endsection