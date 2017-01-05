@extends('admin.master')

@section('title')
Base Price
@endsection

@section('content')
@include('admin.partials.errors')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user fa-fw"></i> Base Price :Upload:</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="alert alert-info" role="alert">
                    {!! Form::open(['route'=>['admin.basePrice.upload'],'class'=>'form-horizontal','files'=>true]) !!}
                        <div class="row">
                            <div class="col-lg-6">
                                Click on 'sample' to download sample xls file before uploading your data.
                                <a href="{{url('/')}}/assets/sample_reports/sample_base_price.xls">Sample.
                                </a>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group" style="width:90%;">
                                        <input type="file" name="file" class="form-control">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary btn-flat" type="submit">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection