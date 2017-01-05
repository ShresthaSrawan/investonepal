@extends('admin.master')

@section('title')
Issue Manager
@endsection

@section('specificheader')
@endsection

@section('content')
<div class="box box-info">
    {!! Form::model($issueManager,['route'=>['admin.issueManager.update',$issueManager->id],'method'=>'put','class'=>'form-horizontal']) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-male fa-fw"></i> Issue Manager :Edit:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.issueManagerForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>
@endsection
@section('endscript')
@endsection