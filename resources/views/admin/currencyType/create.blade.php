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
    {!! Form::open(['route'=>['admin.currencyType.store'],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-btc fa-fw"></i> Currency Type :Add:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
        	@include('admin.partials.currencyTypeForm')
        </div>
        <div class="box-footer">
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
            {!! Form::submit('Create',['class'=>'btn btn-primary pull-right']) !!}
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