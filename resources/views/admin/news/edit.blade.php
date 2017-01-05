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
    {!! Form::model($news, ['route' =>['admin.news.update',$news->id],'files'=>true,'method'=>'put','novalidate'=>'']) !!}
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-newspaper-o fa-fw"></i> News :Edit:</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
	
            @include('admin.partials.newsForm')
			
        </div>
        <div class="box-footer">
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-image"></i> Featured Image
    </div>
    <div class="box-body">
        @if($news->imageNews->isEmpty())
            <img src="http://placehold.it/150x150/dddddd/333333?text=NA" class="img-responsive">
        @else
            @foreach($news->imageNews as $i=>$image)
            <div class="thumbnail col-md-3">
                <img src="{{$image->getImage()}}" style="height:125px !important;"/>
                {!! Form::open(['route'=>['admin.imageNews.destroy', $image->id], 'method'=>'delete']) !!}
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
{!! HTML::script('/assets/nsm/admin/js/news.js') !!}

<script type="text/javascript">

    $(document).ready(function(){
		$('input[type=checkbox]').iCheck({
			checkboxClass: 'icheckbox_square-green'
		});
		changeOption();

    @if($news->company!=null)
       $('[name="company"]').val({{$news->company->id}});
    @endif

    @if($news->event_date != null)
        event_date = '{{$news->event_date}}';
        $('#event').iCheck('check');
        $('[name="event_date"]').val(event_date.replace(' ','T'));
    @endif
    
    });

    $(document).on('click','.delbtn',function(e){
        e.preventDefault();
        $form=$(this).closest('form');
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection