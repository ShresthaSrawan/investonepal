@extends('front.main')

@section('specificheader')
    {!! HTML::style('assets/nsm/front/css/commodity.css') !!}
    <style type="text/css">
        .chart-selector, .compare-chart-selector {
            text-transform: capitalize;
        }
    </style>
@endsection

@section('title')
    Stock : Index
@endsection

@section('content')
    <section class="main-content col-md-9 no-padding">
        <div class="row commodity-type-selector no-margin">
            <div class="col-md-3">
                {!! Form::select('index_type',$indexTypes,1,['class'=>'form-control chart-selector']) !!}
            </div>
            <div class="col-md-9">
            <span class="compare-chart-selector">
                {!! Form::select('index_type',$indexTypes,1,['class'=>'form-control mymulti','multiple'=>'multiple']) !!}
            </span>
            </div>
        </div>
        <div class="row no-margin">
            <div class="col-sm-12">
                <div id="chart-container" class="chart-container" style="width:100%; height:400px;"></div>
            </div>
        </div>
        <div class="row no-margin">
            <div class="col-sm-1 col-sm-offset-5">
                <h3 class="chart-title"></h3>
            </div>
        </div>
        <div class="row no-margin">
            <div class="index-wrapper col-sm-12">
                <p><img src="{{url('/')}}/assets/bull-icon.png" height="50px" width="50px"><strong><span
                                data-role="index"></span> INDEX</strong></p>
                <table class="table datatable with-border index table-striped table-responsive display" width="100%">
                    <thead>
                    <tr>
                        <th class="hidden-sm hidden-xs">SN</th>
                        <th>Date</th>
                        <th>Close Price</th>
                        <th class="hidden-sm hidden-xs"><abbr title="Previous Close">Prev.</abbr></th>
                        <th>Change</th>
                        <th class="hidden-sm hidden-xs"><abbr title="Percent Change">% Change</abbr></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <aside class="col-xs-12 col-md-3">
        <div class="row">
            <div class="col-lg-12">
                <a href="{{route('technical-analysis-index','nepse')}}" class="btn btn-primary btn-block" target="_blank">In-Depth
                    Analysis <i class="fa fa-external-link"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default no-padding">
                    <div class="panel-heading">
                        <strong>Latest News</strong>
                    </div>
                    <div class="panel-body no-padding">
                        <ul class="unlist no-padding">
                            @foreach($allCategories as $cat)
                                @if(!$cat->news->isEmpty())
                                    <li>
                                        <h4 class="aside-heading"><a
                                                    href="{{route('front.news.category',str_slug($cat->label))}}"
                                                    class="link">{{ucwords($cat->label)}}</a></h4>
                                        <ul class="unlist news-media-list no-padding">
                                            @foreach($newsList[$cat->id] as $i=>$n)
                                                <?php if ($i > 1) break; ?>
                                                <li class="aside-item">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <img class="media-object"
                                                                 src="{{$n->imageThumbnail(75,75)}}">
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="media-heading">
                                                                <a href="{{route('front.news.show',$n->id)}}"
                                                                   class="link">
                                                                    {{mb_strimwidth($n->title,0,65,"...")}} <small>({{date_create($n->pub_date)->format('M-d')}})</small>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </aside>
@endsection
@section('endscript')
    <script type="text/javascript">
        var getIndexUrl = "{{route('api-get-index')}}";
        var getIndexDatatableUrl = "{{route('api-get-index-datatable')}}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/highstock.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/modules/exporting.js"
            type="text/javascript"></script>
    {!! HTML::script('assets/nsm/front/js/indexes.js') !!}
    <script type="text/javascript">
        // Hide Search Bar Until Chosen is Loaded
        var selector = document.querySelector(".commodity-type-selector");

        // Show Search Bar
        removeClass(selector, "display-none");
    </script>
@endsection