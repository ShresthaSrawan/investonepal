@extends('front.main')

@section('title')
    Energy
@endsection

@section('specificheader')
{!! HTML::style('assets/nsm/front/css/commodity.css') !!}
@endsection

@section('content')
<section class="main-content col-md-9 no-padding">
    <div class="row commodity-type-selector no-margin">
        <div class="col-md-3">
            {!! Form::select('energy_type',$energyTypes,$energyID,['class'=>'form-control chart-selector']) !!}
        </div>
        <div class="col-md-9">
            <span class="compare-chart-selector">
                {!! Form::select('energy_type',$energyTypes,$energyID,['class'=>'form-control mymulti','multiple'=>'multiple']) !!}
            </span>
        </div>
    </div>
    <div class="row no-margin">
        <div class="col-sm-12">
            <div id="chart-container"  class="chart-container" style="width:100%; height:400px;"></div>
        </div>
    </div>
    <div class="row no-margin">
        <div class="col-sm-1 col-sm-offset-5">
            <h3 class="chart-title"></h3>
        </div>
    </div>
    <div class="row no-margin">
        <div class="col-sm-12">
            <p class="commodity-table"><i class="fa fa-tint"></i> Price of <span data-role="energy" class="commodity-type"></span> are listed below:</p>
            <table class="table datatable energy table-condensed table-hover with-border table-striped" width="100%">
                <thead>
                    <tr>
                        <th class="hidden-sm hidden-xs">SN</th>
                        <th>Date</th>
                        <th>Close Price</th>
                        <th class="hidden-sm hidden-xs">Previous Close</th>
                        <th>Change</th>
                        <th class="hidden-sm hidden-xs">% Change</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>

<aside class="col-md-3 col-xs-12">
    <div class="panel panel-default no-padding">
        <div class="panel-heading">
            <strong>Related News</strong>
        </div>
        <div class="panel-body no-padding">
            <ul class="unlist no-padding">
                <li>
                    <h4 class="aside-heading"><a href="{{route('front.news.category','energy')}}" class="link">Energy</a></h4>
                    <ul class="news-media-list unlist no-padding">
                        @foreach($newsList as $i=>$n)
                            <li class="aside-item">
                                <div class="media">
                                    <div class="media-left">
                                        <img class="media-object" src="{{$n->imageThumbnail(75,75)}}">
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <a href="{{route('front.news.show',$n->id)}}" class="link">
                                                {{mb_strimwidth($n->title,0,65,"...")}} <small>({{date_create($n->pub_date)->format('M-d')}})</small>
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</aside>
@endsection

@section('endscript')
<script type="text/javascript">
    var getEnergyURL = "{{route('api-get-energy')}}";
    var getEnergyDatatableURL = "{{route('api-get-energy-datatable')}}";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/highstock.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/modules/exporting.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js" type="text/javascript"></script>
{!! HTML::script('assets/nsm/front/js/energy.js') !!}
<script type="text/javascript">
    // Hide Search Bar Until Chosen is Loaded
    var selector = document.querySelector(".commodity-type-selector");

    // Show Search Bar
    removeClass(selector, "display-none");
</script>
@endsection