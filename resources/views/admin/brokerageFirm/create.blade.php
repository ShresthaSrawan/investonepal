@extends('admin.master')

@section('title')
Brokerage Firm
@endsection

@section('specificheader')
{!! HTML::style('vendors/fileInput/fileInput.min.css') !!}
@endsection

@section('content')
<div class="box box-info">
    {!! Form::open(['route'=>['admin.brokerageFirm.store'],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-building fa-fw"></i> Brokerage Firm :Add:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.brokerageFirmForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Create',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

@endsection
@section('endscript')
{!! HTML::script('vendors/fileInput/fileinput.js') !!}
@endsection