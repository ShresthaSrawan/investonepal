@extends('front.main')

@section('title')
    Currency
@endsection

@section('specificheader')
{!! HTML::style('assets/nsm/front/css/commodity.css') !!}
@endsection

@section('content')
<section class="main-content col-md-9 no-padding">
    <div class="row commodity-type-selector no-margin">
        <div class="col-md-3">
            {!! Form::select('currency_type',$currencyTypes,$currencyID,['class'=>'form-control chart-selector']) !!}
        </div>
        <div class="col-md-2">
            {!! Form::select('value_type',[0=>'Buy',1=>'Sell'],0,['class'=>'form-control','id'=>'value_type'])!!}
        </div>
        <div class="col-md-7">
            <span class="compare-chart-selector">
                {!! Form::select('currency_type',$currencyTypes,$currencyID,['class'=>'form-control mymulti','multiple'=>'multiple']) !!}
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
        <div class="col-sm-12">
            <p class="commodity-table"><i class="fa fa-money"></i> Price of <span data-role="currency" class="commodity-type"></span> are listed below:</p>
            <table class="table datatable currency table-striped table-condensed table-hover with-border" width="100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th class="buy-tdata hidden-sm hidden-xs">Buy</th>
                        <th class="buy-tdata hidden-sm hidden-xs"><abbr title="Change Amount (Buy)">B.Change</abbr></th>
                        <th class="buy-tdata hidden-sm hidden-xs"><abbr title="Percent Change (Buy)">% Change</abbr></th>
                        <th class="sell-tdata">Sell</th>
                        <th class="sell-tdata"><abbr title="Change Amount (Sell)">S.Change</abbr></th>
                        <th class="sell-tdata hidden-sm hidden-xs"><abbr title="Percent Change (Sell)">% Change</th>
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
                    <h4 class="aside-heading"><a href="{{route('front.news.category','currency')}}" class="link">Currency</a></h4>
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
    var getCurrencyURL = "{{route('api-get-currency')}}";
    var getCurrencyDatatableURL = "{{route('api-get-currency-datatable')}}";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/highstock.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/modules/exporting.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js" type="text/javascript"></script>
{!! HTML::script('assets/nsm/front/js/currency.js') !!}
<script type="text/javascript">
    // Hide Search Bar Until Chosen is Loaded
    var selector = document.querySelector(".commodity-type-selector");

    // Show Search Bar
    removeClass(selector, "display-none");
</script>
@endsection