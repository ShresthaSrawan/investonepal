@extends('admin.master')

@section('title')
Issue Manager
@endsection

@section('specificheader')
@endsection

@section('content')
<div class="box box-info">
    {!! Form::open(['route'=>['admin.issueManager.store'],'class'=>'form-horizontal']) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-male fa-fw"></i> Issue Manager :Add:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.issueManagerForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Create',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

@endsection
@section('endscript')
@endsection