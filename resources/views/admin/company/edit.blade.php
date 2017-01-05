@extends('admin.master')

@section('title')
Company
@endsection

@section('specificheader')
{!! HTML::style('vendors/fileInput/fileInput.min.css') !!}
{!! HTML::style('vendors/iCheck/skins/all.css') !!}
@endsection()

@section('content')

<div class="box box-info">
    {!! Form::model($company, ['route'=>['admin.company.update',$company->id],'class'=>'form-horizontal','method'=>'put','files'=>true]) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-gears fa-fw"></i> Company :Edit:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.validation')
            @include('admin.partials.companyForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <a href="#picture">#</a>
        Logo: <strong>{{ucwords($company->name)}}</strong>
    </div>
    <div class="box-body">
        <div class="col-xs-6 col-md-3">
            @if(is_null($company->logo) || $company->logo == "")
                <img src="http://placehold.it/150x150/dddddd/333333?text=Logo" class="img-responsive">
            @else
                <img src="{{$company->getImage()}}" class="img-responsive">
            @endif
        </div>
    </div>
</div>

@endsection
@section('endscript')
{!! HTML::script('/assets/nsm/admin/js/company.js') !!}
{!! HTML::script('vendors/fileInput/fileinput.js') !!}
{!! HTML::script('vendors/tinymce/tinymce.min.js') !!}
{!! HTML::script('vendors/iCheck/icheck.min.js') !!}
@endsection