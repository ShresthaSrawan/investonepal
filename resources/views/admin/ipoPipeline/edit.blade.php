@extends('admin.master')

@section('title')
IPO Pipeline
@endsection

@section('specificheader')
{!! HTML::style('vendors/chosen/chosen.css') !!}
@endsection

@section('content')
<div class="box box-info">
    {!! Form::model($ipoPipeline->toArray(), ['route'=>['admin.ipoPipeline.update', $ipoPipeline->id],'class'=>'form-horizontal','method'=>'put']) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-info-circle fa-fw"></i> IPO Pipeline :Create:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
                @include('admin.partials.ipoPipelineForm')
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
<script type="text/javascript">
    $('.mymulti').chosen();
</script>
@endsection
