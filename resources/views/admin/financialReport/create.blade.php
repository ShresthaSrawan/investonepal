@extends('admin.master')

@section('title')
Financial Report
@endsection

@section('specificheader')
{!! HTML::style('vendors/chosen/chosen.css') !!}
@endsection

@section('content')
<div class="box box-info">
    {!! Form::open(['route'=>['admin.financialReport.store'],'class'=>'form-horizontal']) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-files-o fa-fw"></i> Financial Report :Add:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.fr-financialReportForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Create',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

@endsection
@section('endscript')
<script>
    $(document).ready(function(){
        $('#company').chosen();    
    });
</script>
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
@endsection