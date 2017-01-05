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
    {!! Form::model($interview,['route' => ['admin.interview.update',$interview->id],'method'=>'put','files'=>true,'novalidate'=>'']) !!}
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-microphone fa-fw"></i> Interview :Edit:
            </h3>
            <div class="box-tools pull-right">
                <label for="source1">External
                    {!! Form::input('radio','source', 'external', ['id'=>'source1']) !!}
                </label>
                <label for="source2">Internal
                    {!! Form::input('radio','source', 'internal', ['id'=>'source2']) !!}
                </label>
            </div>
        </div>

        <div class="box-body">            
    		@include('admin.partials.interviewArticleForm')            
        </div>

        <div class="box-footer">
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-image"></i> Pictures:
    </div>
    <div class="box-body">
        <div class="col-md-6 pull-left">
            <h4>Interviewé: {{ucwords($interview->intervieweDetail->interviewe_name)}}</h4>
            <div class="thumbnail">
                @if(url_exists($interview->intervieweDetail->getImage()) ==0)
                    <img src="http://placehold.it/150x150/dddddd/333333?text=NA" class="img-responsive">
                @else
                    <img src="{{$interview->intervieweDetail->getImage()}}" alt="NA" class="img-responsive" height="150" width="150">
                @endif
            </div>
        </div>
        @if(!is_null($interview->externalDetail))
        <div class="col-md-6 pull-right">
            <h4>Interviewer: {{ucwords($interview->externalDetail->name)}}</h4>
            <div class="thumbnail">
				@if(url_exists($interview->externalDetail->getImage()) ==0)
                    <img src="http://placehold.it/150x150/dddddd/333333?text=NA" class="img-responsive">
                @else
                    <img src="{{$interview->externalDetail->getImage()}}" alt="NA" height="150" width="150">
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!--Featured Image Box-->
<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-image"></i> Featured Image
    </div>
    <div class="box-body">
        @if($interview->featuredImage->isEmpty())
            <img src="http://placehold.it/150x150/dddddd/333333?text=NA" class="img-responsive">
        @else
            @foreach($interview->featuredImage as $i=>$image)
            <div class="thumbnail col-md-3">
                <img src="{{$image->getImage()}}" style="height:125px !important;"/>
                {!! Form::open(['route'=>['admin.interviewFeaturedImage.destroy', $image->id], 'method'=>'delete']) !!}
                    <button class="btn btn-danger btn-block btn-sm delbtn" data-toggle="modal" data-target="#removeImage">
                        <i class="fa fa-trash-o"></i> Remove
                    </button>
                {!! Form::close() !!}
            </div>
            @endforeach
        @endif
    </div>
</div>

<!-- Delete Featured Image Modal -->
<div class="modal fade" id="removeImage" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p class="text-danger">
                    <i class="fa fa-exclamation-triangle"></i>
                    Are you sure want to delete?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger confirm-delete">
                    <i class="fa fa-trash"></i> Yes
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('endscript')
{!! HTML::script('vendors/fileInput/fileinput.js') !!}
{!! HTML::script('vendors/tinymce/tinymce.min.js') !!}
{!! HTML::script('vendors/iCheck/icheck.min.js') !!}
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
<script>
    var external, internal;
    var user_id = '{{$interview->user_id}}';
    $(document).ready(function(){
        tinymce.init(getTinyMceSettings('.editor'));
        changeOption();

        $('input').iCheck({
            radioClass: 'iradio_square-green'
        });

        if(user_id == '')
        {
            $('#source1').iCheck('check');
            changeChoice('external');
        }
        else
        {
            $('#source2').iCheck('check');
            changeChoice('internal');
        }

        $(document).on('ifChanged','input[name=source]',function()
        {
            if($(this).is(':checked')) changeChoice($(this).val());
        });
    });

    $('#newsCategory').change(function(){
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

    function changeOption() {
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
        console.log(onoff);
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

    $(document).on('click','.delbtn',function(e){
        e.preventDefault();
        $form=$(this).closest('form');
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
