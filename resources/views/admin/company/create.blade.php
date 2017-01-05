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
    {!! Form::open(['route' => 'admin.company.store','files'=>true]) !!}
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-gears fa-fw"></i> Company :Add:</h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.validation')
            @include('admin.partials.companyForm')
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
{!! HTML::script('/assets/nsm/admin/js/company.js') !!}
<script type="text/javascript">
    @if(Session::has('name'))
    $(document).ready(function(){
        $('[name="quote"]').val('{{Session::pull("name")}}');
    });
    @endif
</script>
@endsection