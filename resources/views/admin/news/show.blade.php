@extends('admin.master')

@section('title')
News
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <table class="table-condensed borderless">
            <thead>
                <th style="font-size: 25px; font-weight: 400">
                    <i class="fa fa-newspaper-o"></i> News :Show:
                </th>
            </thead>
            <tbody>
                <tr>
                    <th>Title</th>
                    <td>: {{ucwords($news->title)}}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>: {{$news->category->label}}</td>
                </tr>
                    @if(ucwords($news->category->label) == "Bullion")
                        <tr>
                            <th>Bullion Type</th>
                            <td>: {{$news->bullionType->name}}</td>
                    @elseif(ucwords($news->category->label) == "Stock")
                            <th>Company</th>
                            <td>: {{is_null($news->company) ? 'NA' :$news->company->name}}</td>
                        </tr>
                    @endif
                <tr>
                    <th>Date Created</th>
                    <td>: {{$news->pub_date}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                       @if($news->status==0)
                            : Draft
                        @else
                            : Published
                        @endif 
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.news.create')}}">
                <i class="fa fa-plus"></i> Add News
            </a>
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.news.edit',$news->id)}}">
                <i class="fa fa-edit"></i> Edit News
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-10 col-md-offset-1">
            <p>{!! $news->details !!}</p>
        </div>

        <div class="col-md-6 col-md-offset-3">
            <table class="table table-condensed">
                <tbody>
                    <tr>
                        <th>Location</th>
                        <td>{{is_null($news->location) || $news->location == '' ? 'NA' : $news->location}}</td>                      
                    </tr>

                    <tr>
                        <th>Author</th>
                        <td>{{ucfirst($news->user->userInfo->first_name)}} {{ucfirst($news->user->userInfo->last_name)}}</td>
                    </tr>

                    <tr>
                        <th>Event</th>
                        <td>{{is_null($news->event_date) ? 'NA' : $news->event_date}}</td>
                    </tr>

                    <tr>
                        <th>Source</th>
                        <td>{{is_null($news->source) || $news->source == ''? 'NA' : $news->source}}</td>                      
                    </tr>

                    <tr>
                        <th>Tags</th>
                        <td>
                            @if(is_null($news->tags) || $news->tags == '')
                            NA
                            @else
                                @foreach($news->tags as $tag)
                                    {{$tag->name}},
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.news.create')}}">
            <i class="fa fa-plus"></i> Add News
        </a>
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.news.edit', $news->id)}}">
            <i class="fa fa-edit"></i> Edit News
        </a>
    </div>
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-image"></i> Featured Images: <strong>{{ucwords($news->title)}}</strong>
    </div>
    <div class="box-body">
        @foreach($news->imageNews as $i=>$image)
            <div class="thumbnail col-md-3">
                <img src="{{$image->getImage()}}" class="img-responsive" style="height:100px !important;">
            </div>
        @endforeach
    </div>
</div>

@endsection
