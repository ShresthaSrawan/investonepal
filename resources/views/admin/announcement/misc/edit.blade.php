@extends('admin.master')

@section('title')
    Announcement Misc
@endsection
@section('specificheader')
    {!! HTML::style('vendors/chosen/chosen.css') !!}
@endsection
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bullhorn fa-fw"></i>Dynamic Announcement Title & Description <small>:Edit</small></h3>
            <div class="box-tools pull-right">
                <a class="btn btn-info btn-xs" href="{{route('admin.announcement.misc.index')}}"><i class="fa fa-eye"></i> View All</a>
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            {!! Form::model($misc,['route' => ['admin.announcement.misc.update',$misc->id],'class'=>'form-horizontal','method'=>'put'])!!}
            @include('admin.partials.announcementMisc',['subtype'=>$misc->subtype_id])
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary "><i class="fa fa-edit"></i> Update</button>
                </div>
            </div>
            {!! Form::close() !!}
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