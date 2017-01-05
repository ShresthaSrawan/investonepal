@extends('admin.master')

@section('title')
Interview
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
<?php
    if(!array_key_exists("newsCategory", old())):
        $selected = isset($interview) ? $interview->category->id : null;
    else:
        $selected = old('newsCategory');
    endif;

    $type = 0;
?>
<div class="box box-info">
    {!! Form::open(['route'=>['admin.interview.store'],'files'=>true,'novalidate'=>'']) !!}
    {!!Form::hidden('type', $type) !!}
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-microphone fa-fw"></i> Interview :Add:
        </h3>
        <div class="box-tools pull-right">
            <label for="source1">External
                {!! Form::input('radio','source', 'external', ['id'=>'source1']) !!}
            </label>
            <label for="source2">Internal
                {!! Form::input('radio','source', 'internal', ['id'=>'source2','checked'=>true]) !!}
            </label>
        </div>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.interviewArticleForm')
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
{!! HTML::script('vendors/tinymce/tinymce.min.js') !!}
{!! HTML::script('vendors/iCheck/icheck.min.js') !!}
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
<script>
    var external, internal;
    $(document).ready(function()
    {
        tinymce.init(getTinyMceSettings('.editor'));
        changeOption();
        changeChoice('internal');

        $('input').iCheck({
            radioClass: 'iradio_square-green'
        });

        $(document).on('ifChanged','input[name=source]',function()
        {
            if($(this).is(':checked')) changeChoice($(this).val());
        });
    });

    $('#newsCategory').change(function()
    {
        changeOption();
    });

    $('input[name*=source]').change(function()
    {
    	changeChoice($(this).val());
    });

    var config = {
        allow_single_deselect:true,
        disable_search_threshold:5,
        no_results_text:'No company found with name '
    };
    $(document).ready(function(){
        $('select[name=company_id]').chosen(config);
    });

    function changeOption()
    {
        var companyList = $('#companyList');
        var bullionList = $('#bullionList');

        if($("#newsCategory option:selected").text().toLowerCase()=="stock")
        {
            companyList.removeClass('hide');
            companyList.children('select').prop('disabled',false);
            bullionList.addClass('hide');
            bullionList.children('select').prop('disabled',true);
        }
        else if($("#newsCategory option:selected").text().toLowerCase()=="bullion")
        {
            companyList.addClass('hide');
            companyList.children('select').prop('disabled',true);
            bullionList.removeClass('hide');
            bullionList.children('select').prop('disabled',false);
        }
        else
        {
            companyList.addClass('hide');
            companyList.children('select').prop('disabled',true);
            bullionList.addClass('hide');
            bullionList.children('select').prop('disabled',true);
        }
    }

    function changeChoice(onoff)
    {
        if(onoff=='external')
        {
            $('#choice').append(external);
            internal = $('#internalDetail').detach();
        }
        else
        {
            $('#choice').append(internal);
            external = $('#externalDetail').detach();
        }
    }
</script>
@endsection
