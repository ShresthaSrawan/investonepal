@extends('admin.master')

@section('title')
Brokerage Firm
@endsection

@section('specificheader')
{!! HTML::style('vendors/chosen/chosen.css') !!}
{!! HTML::style('vendors/fileInput/fileInput.min.css') !!}
@endsection

@section('content')
<div class="box box-info">
    {!! Form::model($brokerageFirm,['route'=>['admin.brokerageFirm.update',$brokerageFirm->id],'method'=>'put','class'=>'form-horizontal','files'=>true]) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-building fa-fw"></i> Brokerage Firm :Edit:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.brokerageFirmForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>


<div class="box box-info">
    <div class="box-header with-border">
    <a href="#picture">#</a>
    Photo: <strong>{{ucwords($brokerageFirm->name)}}</strong></div>
    <div class="box-body">
        <div class="col-xs-6 col-md-3">
            <a href="#picture" class="thumbnail">
            <img src="{{url('/').'/brokerageFirm_photo/'.$brokerageFirm->photo}}" alt="NA">
            </a>
        </div>
    </div>
</div>

@endsection
@section('endscript')
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
{!! HTML::script('vendors/fileInput/fileinput.js') !!}
@endsection