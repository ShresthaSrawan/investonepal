@extends('admin.master')

@section('title')
Merger &amp; Acquisition
@endsection

@section('specificheader')
{!! HTML::style('vendors/chosen/chosen.css') !!}
@endsection

@section('content')
<div class="box box-info">
    {!! Form::model($merger, ['route'=>['admin.merger.update', $merger->id], 'method' => 'PUT']) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-compress fa-fw"></i>  Merger &amp; Acquisition :Edit:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
                @include('admin.partials.validation')
                @include('admin.merger.form')
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
<script>
    var config = {
        allow_single_deselect:true,
        disable_search_threshold:5,
        no_results_text:'No company found with name '
    };
    $(document).ready(function(){
        $('select[name=company_id]').chosen(config);
    });
</script>
@endsection