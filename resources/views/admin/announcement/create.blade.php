@extends('admin.master')

@section('title')
    Create Announcement
@endsection

@section('specificheader')
    {!! HTML::style('vendors/jquery.steps/jquery.steps.min.css') !!}
    {!! HTML::style('vendors/chosen/chosen.css') !!}
    {!! HTML::style('vendors/fileInput/fileInput.min.css') !!}
    <style>
        .list-group-item{
            padding: 2px 5px;

        }
        .no-padding > .list-group{
            margin-bottom: 0;
        }
        .wizard > .steps > ul > li
        {
            width: 33.33%;
        }
        .mce-fullscreen{
            z-index: 9999 !important;
        }
		a[href="#cancel"] {
			display:none !important;
		}
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-9">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bullhorn fa-fw"></i> Announcement <small>:Create:</small></h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-lg-12 spinner">
                        <div class="sk-cube-grid" >
                            <div class="sk-cube sk-cube1"></div>
                            <div class="sk-cube sk-cube2"></div>
                            <div class="sk-cube sk-cube3"></div>
                            <div class="sk-cube sk-cube4"></div>
                            <div class="sk-cube sk-cube5"></div>
                            <div class="sk-cube sk-cube6"></div>
                            <div class="sk-cube sk-cube7"></div>
                            <div class="sk-cube sk-cube8"></div>
                            <div class="sk-cube sk-cube9"></div>
                            <h5>Loading</h5>
                        </div>
                    </div>
                    @if(!empty($errors->all()))
                        @include('admin.partials.validation')
                    @endif
                    {!! Form::open(['route'=>['admin.announcement.store'],'class'=>'form-horizontal hide','id'=>'createAnnForm','files'=>true]) !!}
                    @include('admin.partials.createAnnouncement')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-3" id="recentAnnouncement">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Recent Announcement</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="list-group" id="recentAnouncement">
                    </div>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection

@section('endscript')
    {!! HTML::script('vendors/jquery.ui/jquery-ui.min.js') !!}
    {!! HTML::script('vendors/jquery.steps/jquery.steps.min.js') !!}
    {!! HTML::script('vendors/jquery.validate/jquery.validate.min.js') !!}
    {!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
    {!! HTML::script('vendors/fileInput/fileinput.js') !!}
    {!! HTML::script('vendors/tinymce/tinymce.min.js') !!}
    <script>
        var url = '{{route('admin.api.get.announcement.subtype')}}';
        var fiscalYearSearchUrl = '{{route("admin.api-search-fiscal-year")}}';
        var dynamicFormUrl = '{{route("admin.api-get-dynamic-announcement-form")}}';
        var searchRecentAnnouncemnet = "{{route('admin.api.search.recent.announcement')}}";
        var getDynamicTD = "{{route('admin.api.get.announcement.dynamic')}}";
        var root = "{{url('/')}}";
        var $spinner = $('.spinner');

        $(document).ready(function(){
            $('#recentAnnouncement').draggable();
            $spinner.remove();
            $('#createAnnForm').removeClass('hide');
        });

    </script>
    {!! HTML::script('/assets/nsm/admin/js/announcement.js') !!}
@endsection