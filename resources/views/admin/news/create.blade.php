@extends('admin.master')

@section('title')
News
@endsection

@section('specificheader')
{!! HTML::style('vendors/fileInput/fileInput.min.css') !!}
{!! HTML::style('vendors/iCheck/skins/all.css') !!}
{!! HTML::style('vendors/chosen/chosen.css') !!}
<style type="text/css">
    .mce-fullscreen{
        z-index: 9999 !important;
    }
</style>
@endsection

@section('content')
<div class="box box-info">
    {!! Form::open(['route'=>['admin.news.store'],'files'=>true,'novalidate'=>'']) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-newspaper-o fa-fw"></i> News :Create:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
                @include('admin.partials.validation')
                @include('admin.partials.newsForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Create',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!} 
</div>
@endsection

@section('endscript')
{!! HTML::script('/assets/nsm/admin/js/news.js') !!}
{!! HTML::script('vendors/fileInput/fileinput.js') !!}
{!! HTML::script('vendors/tinymce/tinymce.min.js') !!}
{!! HTML::script('vendors/iCheck/icheck.min.js') !!}
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