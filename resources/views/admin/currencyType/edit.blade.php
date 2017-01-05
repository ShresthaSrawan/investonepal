@extends('admin.master')

@section('title')
Currency Type
@endsection

@section('specificheader')
    <link href="{{url('/')}}/css/chosen.min.css" rel="stylesheet">
    <link href="{{url('/')}}/css/fileinput.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="box box-info">
    {!! Form::model($currencyType,['route'=>['admin.currencyType.update',$currencyType->id],'class'=>'form-horizontal','method'=>'put','files'=>true]) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-btc fa-fw"></i> Currency Type :Edit:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
        	@include('admin.partials.currencyTypeForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-left']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

@endsection
@section('endscript')
<script type="text/javascript" src="{{url('/')}}/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/js/chosen.proto.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/js/fileinput.js"></script>
<script type="text/javascript">
    $('.mymulti').chosen();
</script>
@endsection