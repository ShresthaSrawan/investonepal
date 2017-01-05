@extends('admin.master')

@section('title')
BOD
@endsection

@section('specificheader')
{!! HTML::style('vendors/chosen/chosen.css') !!}
{!! HTML::style('vendors/fileInput/fileInput.min.css') !!}
@endsection

@section('content')

<div class="box box-info">
    {!! Form::model($bod,['route'=>['admin.company.bod.update','cid'=>$bod->company->id,'bid'=>$bod->id],'class'=>'form-horizontal','method'=>'put','files'=>true]) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user-md fa-fw"></i> BOD of <strong>{{$company->name}}</strong> :Edit:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.bodForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

@if(!empty($bod->photo))
<div class="box box-info">
    <div class="box-header with-border">
    Photo: <strong>{{ucwords($bod->name)}}</strong></div>
    <div class="box-body">
        <div class="col-xs-6 col-md-3">
            <a href="#picture" class="thumbnail">
                <img src="{{asset(\App\Models\BOD::$imageLocation.$bod->photo)}}" alt="NA">
            </a>
        </div>
    </div>
</div>
@endif
@endsection

@section('endscript')
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
{!! HTML::script('vendors/fileInput/fileinput.js') !!}
<script type="text/javascript">
    $('.mymulti').chosen();
</script>
@endsection