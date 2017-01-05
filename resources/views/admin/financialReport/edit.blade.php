@extends('admin.master')

@section('title')
Financial Report
@endsection

@section('specificheader')
{!! HTML::style('vendors/chosen/chosen.css') !!}
@endsection

@section('content')

<div class="box box-info">
    {!! Form::model($financialReport, ['route'=>['admin.financialReport.update',$financialReport->id],'class'=>'form-horizontal','method'=>'put']) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-files-o fa-fw"></i> Financial Report :Edit:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.fr-financialReportForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

@endsection
@section('endscript')
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
@endsection