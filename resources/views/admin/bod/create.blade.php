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
    {!! Form::open(['route'=>['admin.company.bod.store', $company->id],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user-md fa-fw"></i> BOD of <strong>{{$company->name}}</strong> :Add:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.bodForm')
        </div>
        <div class="box-footer">
            {!! Form::submit('Create',['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-left']) !!}
        </div>
    {!! Form::close() !!}
</div>

@endsection
@section('endscript')
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
{!! HTML::script('vendors/fileInput/fileinput.js') !!}

<script type="text/javascript">
    $('.mymulti').chosen();
</script>
@endsection