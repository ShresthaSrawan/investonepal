@extends('admin.master')

@section('title')
    Announcement Misc
@endsection
@section('specificheader')
    {!! HTML::style('vendors/chosen/chosen.css') !!}
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12 pull-right">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-bell fa-fw"></i>Hints</h3>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-xs-12 pull-left">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-bullhorn fa-fw"></i>Dynamic Announcement Title & Description <small>:Create</small></h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-primary btn-xs" href="{{route('admin.announcement.misc.index')}}"><i class="fa fa-eye"></i> View All</a>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                {!! Form::open(array('route' => ['admin.announcement.misc.store'],'class'=>'form-horizontal'))!!}
                @include('admin.partials.announcementMisc')
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="submit" class="btn btn-primary "><i class="fa fa-plus"></i> Create</button>
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
        var URL = '{{route("admin.api.get.announcement.subtype")}}';
    </script>
    {!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
    {!! HTML::script('assets/nsm/admin/js/announcement.misc.js') !!}
@endsection