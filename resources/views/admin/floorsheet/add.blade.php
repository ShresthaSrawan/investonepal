@extends('admin.master')

@section('title')
    Floorsheet
@endsection

@section('content')
@include('admin.partials.errors')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-file-text"></i> Floorsheet :Add:</h3>
            <div class="box-tools pull-right">
                <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.marketIndex.create')}}">
                    <i class="fa fa-plus"></i> Add Market Index
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="col-lg-4 col-lg-offset-4">
                <div class="form-group">
                    <a href="{{route('admin.addFloorsheetCrawler')}}" class="btn btn-default btn-lg"><i class="fa fa-bug fa-4x" aria-hidden="true"></i> Crawl</a>
                    <a href="{{route('admin.addFloorsheetExcel')}}" id="uploadExcel" class="btn btn-default btn-lg"><i class="fa fa-file-excel-o fa-4x" aria-hidden="true"></i>Excel</a>
                </div>
            </div>
            <div class="row" id="uploadFile">
                <div class="col-lg-4 col-lg-offset-4">
                    {!! Form::open(['route'=>['admin.floorsheet.upload'],'class'=>'form-horizontal','files'=>true]) !!}
                    <div class="form-group">
                        <div class="col-lg-11">
                            <div class="input-group">
                                <input type="file" name="file" class="form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary btn-flat" type="submit"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <br>
                            <p>You can download the sample XLS file <a href='{{route("get-floorsheet-sample")}}' id="sample">here</a></p>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('endscript')
    <script>
        var $uploadFile = $('#uploadFile');
        var $uploadExcel = $('#uploadExcel');
        $(document).ready(function(){
            $uploadFile.hide();
            $uploadExcel.click(function(e){
                e.preventDefault();
                var redirectURI = $(this).attr('href');
                $uploadFile.toggle();
                console.log(redirectURI);
            });
        });

        $('.ajax-request').click(function(e){
            e.preventDefault();
            $form = $(this).closest('form');
            var method = $form.children('input[name=_method]').val() || 'POST';
            var url = $form.attr('action');
            var data = $form.serialize();
            console.log(method,url,data);
        });


    </script>
@endsection
