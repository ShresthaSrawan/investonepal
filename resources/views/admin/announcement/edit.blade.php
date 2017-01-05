@extends('admin.master')

@section('title')
    Edit Announcement
@endsection

@section('specificheader')
    <link href="{{URL::asset('vendors/jquery.steps/jquery.steps.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('vendors/chosen/chosen.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('vendors/fileInput/fileInput.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .chosen-container{
            width: 100% !important;
        }
        .chosen-container .chosen-choices{
            display: block;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.428571429;
            color: #555;
            vertical-align: middle;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
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
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bullhorn fa-fw"></i> Announcement <small>:Edit:</small></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="spinner">
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
                @include('admin.partials.validation');
            @endif

            <div id="updateAnonForm" class="hide">
                {!! Form::open(['route'=>['admin.announcement.update',$announcement->id],'class'=>'form-horizontal','method'=>'put','id'=>'createAnnForm','files'=>true]) !!}
                @include('admin.partials.editAnnouncement')
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            Featured Image: <strong>{{ucwords($announcement->title)}}</strong>
        </div>
        <div class="box-body">
            <div class="thumbnail">
                @if(is_null($announcement->featured_image) || $announcement->featured_image == "")
                    <img src="http://placehold.it/150x150/dddddd/333333?text=NA" class="img-responsive">
                @else
                    <img src="{{$announcement->image()}}" alt="NA" class="img-responsive">
                @endif
            </div>
        </div>
    </div>
@endsection

@section('endscript')
    <script src="{{URL::asset('vendors/jquery.steps/jquery.steps.min.js')}}"></script>
    <script src="{{URL::asset('vendors/jquery.validate/jquery.validate.min.js')}}"></script>
    <script src="{{URL::asset('vendors/chosen/chosen.jquery.min.js')}}"></script>
    <script src="{{URL::asset('vendors/fileInput/fileinput.js')}}"></script>
    <script src="{{URL::asset('vendors/tinymce/tinymce.min.js')}}"></script>
    <script>
        var url = '{{route('admin.api.get.announcement.subtype')}}';
        var fiscalYearSearchUrl = '{{route("admin.api-search-fiscal-year")}}';
        var dynamicFormUrl = '{{route("admin.api-get-dynamic-announcement-form")}}';
        var searchAnnouncemnet = "{{route('admin.api.search.announcement')}}";
        var searchRecentAnnouncemnet = null;
        var getDynamicTD = "{{route('admin.api.get.announcement.dynamic')}}";
        var root = "{{url('/')}}";
        var $spinner = $('.spinner');

        $(document).ready(function(){
            $spinner.remove();
            $('#updateAnonForm').removeClass('hide');
        });

    </script>
    {!! HTML::script('/assets/nsm/admin/js/announcement.js') !!}
@endsection