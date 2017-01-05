@extends('front.main')

@section('title')
    Home
@endsection
@section('specificheader')
{!! HTML::style('vendors/bxSlider/bxslider.css') !!}

<style>
    .bx-viewport{
        min-height: 457px;
    }
    .bx-wrapper .bx-pager{
        width: auto;
    }
    #market-data .box-md{
        background-color: #ECF0F1;
    }
    .bx-wrapper .bx-pager, .bx-wrapper .bx-controls-auto {
        bottom: 12%;
        left: 45%;
    }
    table#indexDatatable {
        margin: 0 !important;
    }
</style>
@endsection

@section('content')
    <section id="market-data" class="row">
        <div class="col-xs-12">
            <div class="box box-md">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#stock" data-toggle="tab">Stock</a></li>
                    <li><a href="#bullion" data-toggle="tab">Bullion</a></li>
                    <li><a href="#currency" data-toggle="tab">Currency</a></li>
                    <li><a href="#energy" data-toggle="tab">Energy</a></li>
                </ul>
                <div id="market-data-tab" class="tab-content">
                    <div class="tab-pane fade active in" id="stock">
                        <div class="panel panel-default no-top-border no-shadow no-margin">
                            <div class="panel-body">
                                <div class="col-xs-12">
                                    <div class="summary-date">
                                        <span class="badge pull-right">Date: <small>{{date_create($index->date)->format('j M y')}}</small></span>
                                    </div>
                                </div>
                                <?php
                                $showableIndex = ['nepse'=>'NEPSE','float index'=>'FLOAT','sensitive'=>'SENS.','sensitive float'=>'S. FLOAT','banking'=>'BANK','development'=>'D. BANK'];
                                end($showableIndex);
                                $lastIndex = key($showableIndex);
                                $previousIndex = $index->previous;

                                ?>
                                @foreach($showableIndex as $key=>$value)
                                    <div class="market-summary-data col-xs-4 col-md-2">
                                        <a href="#"><strong class="hidden-lg hidden-md hidden-sm">{{strtoupper($value)}}</strong><strong class="hidden-xs">{{strtoupper($key)}}</strong></a>
                                        <?php

                                        $indexValue = $filter($index->indexValue,['type','name'],$key);
                                        $previousValue = $filter($previousIndex->indexValue,['type','name'],$key);

                                        $indexValue->previous($previousValue);
                                        $preDate = ($key == $lastIndex) ? '(<strong>'.date_create($index->previous->date)->format('j M').'</strong>)' : '';

                                        if($indexValue->change() == 0):
                                            $dataChange = 'neutral';
                                        elseif($indexValue->change() > 0):
                                            $dataChange = 'up';
                                        elseif($indexValue->change() < 0):
                                            $dataChange = 'down';
                                        endif;
                                        ?>
                                        <div class="market-summary-detail-bottom">
                                            <div class="market-summary-detail-price-today">{{$indexValue->value}}</div>
                                            <div class="market-summary-detail-price-change" data-change="{{$dataChange}}">{{$indexValue->change()}}</div>
                                            <div class="market-summary-detail-price-percent-change" data-change="{{$dataChange}}">{{$indexValue->changePercent()}}</div>
                                            <div class="market-summary-detail-previous-price">{{$indexValue->previousValue()}}
                                                <?php

                                                ?>
                                                <small><abbr title="Previous Close">Prior</abbr> ({{ $indexValue->previousDate($previousIndex->date) }})</small></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="panel-footer">
                                <div class="summary clearfix">
                                    <div class="col-xs-12">
                                        <div class="col-xs-6 col-md-4">Traded Script: <small>1489</small></div>
                                        <div class="col-xs-6 col-md-4">Stock Traded: <small>1145716</small></div>
                                        <div class="col-xs-6 col-md-4">Market Cap. (Mil): <small>Rs.1,113,053.98</small></div>
                                        <div class="col-xs-6 col-md-4">Transactions: <small>124</small></div>
                                        <div class="col-xs-6 col-md-4">Amount: <small>Rs.732,321,159.56</small></div>
                                        <div class="col-xs-6 col-md-4">Float Market Cap. (Mil): <small>Rs.355,285.55</small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="bullion">
                        <div class="panel panel-default no-top-border no-margin">
                            <div class="panel-body">
                                <div class="col-xs-12">
                                    <div class="summary-date">
                                        <span class="badge pull-right">Date: <small>{{date_create($bullion->date)->format('j M y')}}</small></span>
                                    </div>
                                </div>
                                <?php $showableBullion = ['hallmark gold','tejabi gold','silver'] ?>
                                @foreach($showableBullion as $key)
                                    <div class="market-summary-data col-xs-4">
                                        <?php
                                        $bullionPrice = $filter($bullion->bullionPrice,['type','name'],$key);
                                        $previousPrice = $filter($bullion->previous->bullionPrice,['type','name'],$key);
                                        $bullionPrice->previous($previousPrice);
                                        if($bullionPrice->change() == 0):
                                            $dataChange = 'neutral';
                                        elseif($bullionPrice->change() > 0):
                                            $dataChange = 'up';
                                        elseif($bullionPrice->change() < 0):
                                            $dataChange = 'down';
                                        endif;
                                        ?>
                                        <a href="#"><strong>{{strtoupper($key)}}</strong> ({{$bullionPrice->type->unit}})</a>
                                        <div class="market-summary-detail-bottom">
                                            <div class="market-summary-detail-price">{{$bullionPrice->price}}</div>
                                            <div class="market-summary-detail-price-change" data-change="{{$dataChange}}">{{$bullionPrice->change()}}</div>
                                            <div class="market-summary-detail-percent-change" data-change="{{$dataChange}}">{{$bullionPrice->changePercent()}}%</div>
                                            <div class="market-summary-detail-price">{{$bullionPrice->previousPrice()}} <small><abbr title="Previous Price">Prior </abbr>({{date_create($bullion->previous->date)->format('j M')}})</small></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="currency">
                        <div class="panel panel-default no-top-border no-margin">
                            <div class="panel-body">
                                <div class="col-xs-12">
                                    <div class="summary-date">
                                        <span class="badge pull-right">Date: <small>{{date_create($currency->date)->format('j M y')}}</small></span>
                                    </div>
                                </div>
                                <?php $showableCurrency = ['us$','aus$','euro','sa riyal','qat. riyal','sin$'] ?>
                                @foreach($showableCurrency as $key)
                                    <div class="market-summary-data col-xs-4 col-md-2">
                                        <a href="#"><strong>{{strtoupper($key)}}</strong><small> (Buy)</small></a>
                                        <?php
                                        $currencyRate = $filter($currency->currencyRate,['type','name'],$key);
                                        $previousRate = $filter($currency->previous->currencyRate,['type','name'],$key);
                                        $currencyRate->previous($previousRate);
                                        if($currencyRate->change() == 0):
                                            $dataChange = 'neutral';
                                        elseif($currencyRate->change() > 0):
                                            $dataChange = 'up';
                                        elseif($currencyRate->change() < 0):
                                            $dataChange = 'down';
                                        endif;
                                        ?>
                                        <div class="market-summary-detail-bottom">
                                            <div class="market-summary-detail-price">{{$currencyRate->sell}}</div>
                                            <div class="market-summary-detail-price-change" data-change="{{$dataChange}}">{{$currencyRate->change('sell')}}</div>
                                            <div class="market-summary-detail-percent-change" data-change="{{$dataChange}}">{{$currencyRate->changePercent('sell')}}%</div>
                                            <div class="market-summary-detail-price">{{$currencyRate->previousRate('sell')}} <small><abbr title="Previous Rate">Prior </abbr>({{date_create($currency->previous->date)->format('j M')}})</small></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="energy">
                        <div class="panel panel-default no-top-border no-margin">
                            <div class="panel-body">
                                <div class="col-xs-12">
                                    <div class="summary-date">
                                        <span class="badge pull-right">Date: <small>{{date_create($energy->date)->format('j M y')}}</small></span>
                                    </div>
                                </div>
                                <?php $showableEnergy = ['petrol','diesel','gas','kerosene'] ?>
                                @foreach($showableEnergy as $key)
                                    <div class="market-summary-data col-xs-3">
                                        <?php
                                        $energyPrice = $filter($energy->energyPrice,['type','name'],$key);
                                        $previousPrice = $filter($energy->previous->energyPrice,['type','name'],$key);
                                        $energyPrice->previous($previousPrice);
                                        if($energyPrice->change() == 0):
                                            $dataChange = 'neutral';
                                        elseif($energyPrice->change() > 0):
                                            $dataChange = 'up';
                                        elseif($energyPrice->change() < 0):
                                            $dataChange = 'down';
                                        endif;
                                        ?>
                                        <a href="#"><strong>{{strtoupper($key)}}</strong> ({{ucwords($energyPrice->type->unit)}})</a>
                                        <div class="market-summary-detail-bottom">
                                            <div class="market-summary-detail-price">{{$energyPrice->price}}</div>
                                            <div class="market-summary-detail-price-change" data-change="{{$dataChange}}">{{$energyPrice->change()}}</div>
                                            <div class="market-summary-detail-percent-change" data-change="{{$dataChange}}">{{$energyPrice->changePercent()}}%</div>
                                            <div class="market-summary-detail-price">{{$energyPrice->previousPrice()}} <small><abbr title="Previous Price">Prior </abbr>({{date_create($energy->previous->date)->format('j M')}})</small></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="news" class="row">
        <div class="col-xs-12 col-md-7"><h3 class="category-heading"><a href="{{route('front.news.index')}}" class"link" target="_blank">News</a></h3></div>
        <div class="col-xs-12 col-md-5"><h3 class="category-heading">Recent</h3></div>
        <div class="col-xs-12 col-md-7">
            <div id="newsCarousel" class="box">
                <ul class="nsm-news-slider no-padding unlist">
                    @foreach($news as $i=>$n)
                        <?php if($i > 4) break; ?>
                        <li style="display:none;">
                            <img src="{{$n->imageThumbnail(484,670)}}" title="{{$n->title}}" class="img-responsive"/>
                            <div class="bx-caption">
                                <span>
                                    <a href="{{$n->getLink('front.news.show',$n->category->label)}}" class="link caption-link" target="_blank">{{$n->title}}
                                        <i class="fa fa-angle-double-right"></i></a>
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-xs-12 col-md-5">
            <div class="box">
                <div class="news-media-list">
                    @foreach($news as $i=>$n)
                        <?php if($i < 5) continue; ?>
                        <div class="media">
                            <div class="media-left">
                                <img class="media-object" src="{{$n->imageThumbnail(75,150)}}">
                            </div>
                            <div class="media-body {{is_nepali($n->title)?'np':''}}">
                                <?php
                                $showAbleIcon = (strpos($n->timeAgo(),'ago') !== false) ? '<i class="fa fa-clock-o"></i> ' : '';
                                ?>
                                <h5 class="media-heading"><a href="{{$n->getLink('front.news.show',$n->category->label)}}" class="link">{{$n->title}}</a></h5>
                                <p>{!! $showAbleIcon.$n->timeAgo() !!} | {{$n->category->label}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <div class="row" id="adv-hr">
        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-default no-margin">
                <div class="panel-heading">More Ads 1</div>
                <div class="panel-body no-padding no-margin no-border" style="height: 56px">

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-default no-margin">
                <div class="panel-heading">More Ads 2</div>
                <div class="panel-body no-padding no-margin no-border" style="height: 56px">

                </div>
            </div>
        </div>
    </div>

    <section id="announcement" class="row">
        <div class="col-xs-12 col-md-8"><h3 class="category-heading"><a href="{{route('front.announcement.index')}}" class"link" target="_blank">Announcements</a></h3></div>
        <div class="col-xs-12 col-md-4">
            <h3 class="category-heading">
                Events
            </h3>
        </div>
        <div class="col-xs-12 col-md-8">
            <div class="box">
                <div class="news-media-list">
                    @foreach($announcements as $i=>$a)
                        <div class="media">
                            <div class="media-left">
                                <img class="media-object" src="{{$a->imageThumbnail(75,150)}}">
                            </div>
                            <div class="media-body">
                                <?php
                                $showAbleIcon = (strpos($a->timeAgo(),'ago') !== false) ? '<i class="fa fa-clock-o"></i>' : '<i class="fa fa-calendar-o"></i>';
                                ?>
                                <span class="pull-right nsm-datetime nsm-badge">{!! $showAbleIcon !!} {{$a->timeAgo()}}</span>
                                <h5 class="media-heading"><a href="{{$a->getLink('front.announcement.show',$a->type->label)}}" class="link">{{$a->title}}</a></h5>
                                <p>{{ucwords($a->type->label)}} | {{ucwords($a->subtype->label)}} <br>Event: {{date_create($a->event)->format('j M y')}}
                                    @if(!is_null($a->issue))
                                        @if(!is_null($auction = $a->issue->auction))
                                            @if(!is_null($auction->ordinary) && $auction->ordinary != 0)
                                                | Ordinary: {{$auction->ordinary}}
                                            @endif
                                            @if(!is_null($auction->promoter) && $auction->promoter != 0)
                                                | Promoter: {{$auction->promoter}}
                                            @endif
                                        @else
                                            | Close Date : {{date_create($a->issue->close_date)->format('j M')}} | Kitta: {{$a->issue->kitta}}
                                        @endif
                                    @elseif(!is_null($a->agm))
                                        | Time: {{date_create($a->agm->time)->format('h:i A') }} | Venue: {{ $a->agm->venue }}
                                    @elseif(!is_null($a->financialHighlight))
                                        | Net Profit: {{ $a->financialHighlight->net_profit }}
                                    @elseif(!is_null($a->bondDebenture))
                                        | Kitta: {{$a->bondDebenture->kitta}}
                                    @elseif(!is_null($a->bonusDividend))
                                        @if(!is_null($a->bonusDividend->bonus_share) && $a->bonusDividend->bonus_share != 0)
                                            | Bonus: {{$a->bonusDividend->bonus_share}}
                                        @endif
                                        @if(!is_null($a->bonusDividend->cash_dividend) && $a->bonusDividend->cash_dividend != 0)
                                            | Dividend: {{$a->bonusDividend->cash_dividend}}
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-12">
                    <div class="box">
                        <div class="news-media-list no-padding no-margin no-border">
                            @foreach($events as $event)
                                 <div class="col-xs-12 news-data" style="padding: 1.5rem 0;">
                                    <div class="col-xs-2 fh-label" style="margin-top: 1rem;">
                                        {{date_create($event->event_date)->format('M jS')}}
                                    </div>
                                    <div class="col-xs-10 fh-value">
                                        <a href="{{$event->getLink('front.announcement.show',$event->type->label)}}" rel="nofollow" class="link" target="_blank">{{mb_strimwidth(strip_tags($event->details),0,42,"...")}}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="market-index" class="row">
        <div class="col-xs-12 col-md-7"><h3 class="category-heading"><a href="{{route('stock','index')}}" class"link" target="_blank">Index Chart</a></h3></div>
        <div class="col-xs-12 col-md-5" style="padding-left:0;"><h3 class="category-heading"><a href="{{route('stock','index')}}" class"link" target="_blank">Market Index</a></h3></div>
        <div class="col-xs-12 col-md-7">
            <div class="box" id="chart-container" style="min-height: 420px;">

            </div>
        </div>
        <div class="col-xs-12 col-md-5">
            <div class="panel panel-default no-top-border no-shadow no-margin">
                <div class="panel-body no-padding">
                    <table id="indexDatatable" class="table datatable table-condensed table-striped table-responsive display no-wrap" width="100%">
                        <thead>
                            <tr>
                                <th>Index</th>
                                <th>Value</th>
                                <th>Change</th>
                                <th>Percent</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section id="bonus-dividend" class="row">
        <div id="bodApproved" class="col-md-4 col-xs-12">
            <div class="col-xs-12 no-padding"><h4 class="category-heading">Benifits BOD Approved</h4></div>
            <table class="table datatable table-condensed table-responsive table-stripped with-border">
                <thead>
                    <tr>
                        <th>Quote</th>
                        <th>Bonus</th>
                        <th>Cash Dividend</th>
                        <th>Approved Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!($bodApproved->isEmpty()))
                        @foreach($bodApproved as $ba)
                            <tr>
                                <td>
                                    <a href="{{$ba->announcement->getLink('front.announcement.show',$ba->announcement->type->label)}}" class="link" target="_blank">
                                        {{$ba->company->quote}}
                                    </a>
                                </td>
                                <td>{{$ba->bonus_share}}</td>
                                <td>{{$ba->cash_dividend}}</td>
                                <td>{{$ba->distribution_date}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4">No Data Available</td><tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div id="annualGeneralMeeting" class="col-md-4 col-xs-12">
            <div class="col-xs-12 no-padding"><h4 class="category-heading">Annual General Meeting (AGM)</h4></div>
            <table id="datatable" class="table datatable table-condensed table-striped table-responsive with-border" width="100%">
                <thead>
                    <tr>
                        <th>Quote</th>
                        <th>Venue</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!($annualGeneralMeeting->isEmpty()))
                        @foreach($annualGeneralMeeting as $value)
                            <?php $agm = $value->agm; ?>
                            <tr>
                                <td>
                                    <a href="{{$agm->announcement->getLink('front.announcement.show',$agm->announcement->type->label)}}" class="link" target="_blank">
                                        {{$agm->company->quote}}
                                    </a>
                                </td>
                                <td>{{$agm->venue}}</td>
                                <td>{{date_create($agm->agm_date)->format('M-d-Y')}}</td>
                                <td>{{date_create($agm->time)->format('h:i A')}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4">No Data Available</td><tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div id="certificate" class="col-md-4 col-xs-12">
            <div class="col-xs-12 no-padding"><h4 class="category-heading">Certificates and Benifits Distribution</h4></div>
            <table id="datatable" class="table datatable table-condensed table-striped table-responsive with-border" width="100%">
                <thead>
                    <tr>
                        <th>Quote</th>
                        <th>Detail</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!($certificate->isEmpty()))
                        @foreach($certificate as $c)
                            <tr>
                                <td>
                                    <a href="{{$c->announcement->getLink('front.announcement.show',$c->announcement->type->label)}}" class="link" target="_blank">
                                        {{$c->company->quote}}
                                    </a>
                                </td>
                                <td>{{explode(":",$c->announcement->title)[1]}}</td>
                                <td>{{$c->distribution_date == "0000-00-00" ? 'NA' : date_create($c->distribution_date)->format('M-d-Y')}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4">No Data Available</td><tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    <section id="news-category">
        <?php  $categories = ['stock','bullion','currency','energy']; ?>
        @foreach($categories as $cat)
        <div class="row">
            <?php $category = $filter($newsCategories,['label'],$cat); ?>
            <div id="{{strtolower($cat)}}" class="col-xs-12">
                <h3 class="category-heading"><a href="{{route('front.news.category',str_slug($cat))}}" class="link">{{ucwords($cat)}}</a></h3>
                <div class="row news-list">
                    @foreach($category->recentNews() as $categoryNews)
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="box">
                                <figure class="captionize">
                                    <img src="{{$categoryNews->imageNewsFirst->getThumbnail(360,720) }}" alt="{{$categoryNews->title}}" class="img-responsive"/>
                                    <figcaption>
                                        <div class="btn-group pull-right">
                                            <a href="http://www.facebook.com/sharer.php?u={{urlencode($categoryNews->getLink('front.news.show',$categoryNews->category->label))}}" target="_blank" class="js-social-share facebook">
                                                <i class="fa fa-facebook-square"></i>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?text={{urlencode($categoryNews->title)}}&url={{urlencode($categoryNews->getLink('front.news.show',$categoryNews->category->label))}}&via=SrawanShr" target="_blank" class="js-social-share twitter">
                                                <i class="fa fa-twitter-square"></i>
                                            </a>
                                        </div>
                                        <span class="clearfix"></span>
                                        <h4><a href="{{$categoryNews->getLink('front.news.show',$cat)}}" class="link caption-link" target="_blank">{{$categoryNews->title}}</a></h4>
                                        <p>{{$captionize($categoryNews->details,0,150)}}</p>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </section>
@endsection

@section('endscript')
    <script>
        $('.news-media-list').slimScroll({height: '484px'});
        var getIndexUrl = "{{route('api-get-index')}}";
        var indexSummaryDatatableURL = "{{route('api-get-index-summary-datatable')}}";
    </script>
    {!! HTML::script('vendors/highstock/js/highstock.js') !!}
    {!! HTML::script('vendors/highstock/js/exporting.js') !!}
    {!! HTML::script('vendors/bxSlider/bxslider.min.js') !!}
    {!! HTML::script('assets/nsm/front/js/home.js') !!}
@endsection