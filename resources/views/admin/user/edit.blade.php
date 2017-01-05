@extends('admin.master')

@section('title')
User
@endsection

@section('specificheader')
{!! HTML::style('vendors/fileInput/fileInput.min.css') !!}
@endsection

@section('content')

<div class="box box-info">
    {!! Form::model($user, ['route' => ['admin.user.update',$user->id],'files'=>true,'class'=>'form-horizontal','method'=>'put']) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user fa-fw"></i> User :Edit:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
                @include('admin.partials.userForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

<div class="box box-info">
    <div class="box-header with-border">
        Profile Picture: <strong>{{ucwords($user->first_name.' '.$user->last_name)}}</strong>
    </div>
    <div class="box-body">
        <div class="thumbnail">
            @if(is_null($user->profile_picture) || $user->profile_picture == "")
                <img src="http://placehold.it/150x150/dddddd/333333?text=NA" class="img-responsive">
            @else
                <img src="{{url('/').'/profile_picture/'.$user->profile_picture}}" alt="NA" class="img-responsive">
            @endif
        </div>
    </div>
</div>
@endsection

@section('endscript')
{!! HTML::script('vendors/fileInput/fileinput.js') !!}
@endsection