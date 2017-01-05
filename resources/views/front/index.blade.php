@extends('front.main')

@section('title')
    Home
@endsection
@section('specificheader')
    <style>
        #market-data .box-md {
            background-color: #ECF0F1;
        }

        table#indexDatatable {
            margin: 0 !important;
        }

        .page-title {
            display: none;
        }
    </style>
@endsection

@section('content')
    <section id="market-data" class="row">
        <div class="col-xs-12">
            <div class="box box-md">
                <ul class="nav nav-tabs nav-drops">
                    <li class="active"><a href="#stock" data-toggle="tab">Stock</a></li>
                    <li><a href="#bullion" data-toggle="tab">Bullion</a></li>
                    <li><a href="#currency" data-toggle="tab">Currency</a></li>
                    <li><a href="#energy" data-toggle="tab">Energy</a></li>
                    <li><a href="{{route('stock','today')}}" target="_blank">Today's</a></li>
                    <li><a href="{{route('stock','marketreport')}}" target="_blank">Market Report</a></li>
                    <li><a href="{{route('stock','averageprice')}}" target="_blank">Average</a></li>
                    <li><a href="{{route('stock','lastprice')}}" target="_blank">Lastest Price</a></li>
                    <li><a href="{{route('front.ipoPipeline')}}" target="_blank">Pipeline</a></li>
                    <li><a href="{{route('front.ipoResult')}}" target="_blank">Allotment</a></li>
                    <li><a href="{{route('front.issue')}}" target="_blank">Issues</a></li>
                </ul>
                <div id="market-data-tab" class="tab-content">
                    <div class="tab-pane fade active in" id="stock">
                        <div class="panel panel-default no-top-border no-shadow no-margin">
                            <div class="panel-body">
                                <div class="col-xs-12">
                                    <div class="summary-date">
                                        <span class="badge pull-right">Date: <small>{{date_create($index->date)->format('M jS')}}</small></span>
                                    </div>
                                </div>
                                <?php
                                $showableIndex = ['nepse' => 'NEPSE', 'float index' => 'FLOAT', 'sensitive' => 'SENS.', 'sensitive float' => 'S. FLOAT', 'banking' => 'BANK', 'development' => 'D. BANK'];
                                end($showableIndex);
                                $lastIndex = key($showableIndex);
                                $previousIndex = $index->previous;

                                ?>
                                @foreach($showableIndex as $key=>$value)
                                    <div class="market-summary-data col-xs-4 col-md-2">
                                        <a href="{{route('stock','index')}}" class="link" target="_blank"><strong
                                                    class="hidden-lg hidden-md hidden-sm">{{strtoupper($value)}}</strong><strong
                                                    class="hidden-xs">{{strtoupper($key)}}</strong></a>
                                        <?php

                                        $indexValue = $filter($index->indexValue, ['type', 'name'], $key);
                                        $previousValue = $filter($previousIndex->indexValue, ['type', 'name'], $key);

                                        $indexValue->previous($previousValue);
                                        $preDate = ($key == $lastIndex) ? '(<strong>' . date_create($index->previous->date)->format('j M') . '</strong>)' : '';

                                        if ($indexValue->change() == 0):
                                            $dataChange = 'neutral';
                                        elseif ($indexValue->change() > 0):
                                            $dataChange = 'up';
                                        elseif ($indexValue->change() < 0):
                                            $dataChange = 'down';
                                        endif;
                                        ?>
                                        <div class="market-summary-detail-bottom">
                                            <div class="market-summary-detail-price-today">{{$indexValue->value}}</div>
                                            <div class="market-summary-detail-price-change"
                                                 data-change="{{$dataChange}}">{{$indexValue->change()}}</div>
                                            <div class="market-summary-detail-price-percent-change"
                                                 data-change="{{$dataChange}}">{{$indexValue->changePercent()}}</div>
                                            <div class="market-summary-detail-previous-price">{{$indexValue->previousValue()}}
                                                <?php

                                                ?>
                                                <small><abbr title="Previous Close">Prior</abbr>
                                                    ({{ $indexValue->previousDate($previousIndex->date) }})
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="panel-footer">
                                <div class="summary clearfix">
                                    <div class="col-xs-12">
                                        <div class="col-xs-6 col-md-4">Traded Script:
                                            <small>{{$summary['total_company']}}</small>
                                        </div>
                                        <div class="col-xs-6 col-md-4">Stock Traded:
                                            <small>{{$summary['total_vol']}}</small>
                                        </div>
                                        <div class="col-xs-6 col-md-4">Market Cap. (Mil):
                                            <small>Rs. {{$summary['market_cap']}}</small>
                                        </div>
                                        <div class="col-xs-6 col-md-4">Transactions:
                                            <small>{{$summary['total_tran']}}</small>
                                        </div>
                                        <div class="col-xs-6 col-md-4">Amount:
                                            <small>Rs. {{$summary['total_amt']}}</small>
                                        </div>
                                        <div class="col-xs-6 col-md-4">Float Market Cap. (Mil):
                                            <small>Rs. {{$summary['float_cap']}}</small>
                                        </div>
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
                                        <span class="badge pull-right">Date: <small>{{date_create($bullion->date)->format('M jS')}}</small></span>
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
                                        <a href="{{route('front.bullion',$key)}}"
                                           target="_blank"><strong>{{strtoupper($key)}}</strong>
                                            ({{$bullionPrice->type->unit}})</a>

                                        <div class="market-summary-detail-bottom">
                                            <div class="market-summary-detail-price">{{$bullionPrice->price}}</div>
                                            <div class="market-summary-detail-price-change"
                                                 data-change="{{$dataChange}}">{{$bullionPrice->change()}}</div>
                                            <div class="market-summary-detail-percent-change"
                                                 data-change="{{$dataChange}}">{{$bullionPrice->changePercent()}}%
                                            </div>
                                            <div class="market-summary-detail-price">{{$bullionPrice->previousPrice()}}
                                                <small><abbr
                                                            title="Previous Price">Prior </abbr>({{date_create($bullion->previous->date)->format('j M')}}
                                                    )
                                                </small>
                                            </div>
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
                                        <span class="badge pull-right">Date: <small>{{date_create($currency->date)->format('M jS')}}</small></span>
                                    </div>
                                </div>
                                <?php $showableCurrency = ['us$','aus$','euro','sa riyal','qat. riyal','sin$'] ?>
                                @foreach($showableCurrency as $key)
                                    <div class="market-summary-data col-xs-4 col-md-2">
                                        <a href="{{route('front.currency',$key)}}"
                                           target="_blank"><strong>{{strtoupper($key)}}</strong>
                                            <small> (Buy)</small>
                                        </a>
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
                                            <div class="market-summary-detail-price-change"
                                                 data-change="{{$dataChange}}">{{$currencyRate->change('sell')}}</div>
                                            <div class="market-summary-detail-percent-change"
                                                 data-change="{{$dataChange}}">{{$currencyRate->changePercent('sell')}}%
                                            </div>
                                            <div class="market-summary-detail-price">{{$currencyRate->previousRate('sell')}}
                                                <small><abbr
                                                            title="Previous Rate">Prior </abbr>({{date_create($currency->previous->date)->format('j M')}}
                                                    )
                                                </small>
                                            </div>
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
                                        <span class="badge pull-right">Date: <small>{{date_create($energy->date)->format('M jS')}}</small></span>
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
                                        <a href="{{route('front.energy',$key)}}"
                                           target="_blank"><strong>{{strtoupper($key)}}</strong>
                                            ({{ucwords($energyPrice->type->unit)}})</a>

                                        <div class="market-summary-detail-bottom">
                                            <div class="market-summary-detail-price">{{$energyPrice->price}}</div>
                                            <div class="market-summary-detail-price-change"
                                                 data-change="{{$dataChange}}">{{$energyPrice->change()}}</div>
                                            <div class="market-summary-detail-percent-change"
                                                 data-change="{{$dataChange}}">{{$energyPrice->changePercent()}}%
                                            </div>
                                            <div class="market-summary-detail-price">{{$energyPrice->previousPrice()}}
                                                <small><abbr
                                                            title="Previous Price">Prior </abbr>({{date_create($energy->previous->date)->format('j M')}}
                                                    )
                                                </small>
                                            </div>
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
        <div class="col-xs-12 col-md-7 no-padding">
            <div class="col-xs-12"><h3 class="category-heading"><a href="{{route('front.news.index')}}" class="link"
                                                                   target="_blank">News</a></h3></div>
            <div class="col-xs-12">
				<div id="news-carousel" class="carousel slide box" data-ride="carousel">
					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						@foreach($news as $i=>$n)
							<?php if($i > 4) break; ?>
							<div class="item {{$i==0?'active':''}}">
								<img src="{{$n->imageThumbnail(484,670)}}" alt="{{$n->title}}" title="{{$n->title}}"
								 class="img-responsive"/>
								<div class="carousel-caption">
									<p data-animation="animated bounceInUp">
										<a href="{{$n->getLink('front.news.show',$n->category->label)}}"
										   class="link caption-link" target="_blank">{{$n->title}}
											&nbsp;<i class="fa fa-angle-double-right"></i></a>
									</p>
								</div>
							</div>
						@endforeach
					</div>

					<!-- Controls -->
					<a class="left carousel-control" href="#news-carousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#news-carousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
            </div>
        </div>
        <div class="col-xs-12 col-md-5 no-padding">
            <div class="col-xs-12"><h3 class="category-heading">Recent</h3></div>
            <div class="col-xs-12">
                <div class="box">
                    <div class="news-media-list">
                        @foreach($news as $i=>$n)
                            <div class="media">
                                <div class="media-body {{is_nepali($n->title)?'np':''}}">
                                    <?php
                                    $showAbleIcon = (strpos($n->timeAgo(),'ago') !== false) ? '<i class="fa fa-clock-o"></i> ' : '';
                                    ?>
                                    <h4 class="media-heading"><a
                                                href="{{$n->getLink('front.news.show',$n->category->label)}}"
                                                class="link">{{mb_strimwidth($n->title,0,73,"...")}} <span class="fh-label"><small>{!! $showAbleIcon.$n->timeAgo() !!} | {{$n->category->label}}</small></span></a></h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row" id="adv-hr">
        <div class="col-xs-12 col-sm-4">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- horizontal7may2012 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:468px;height:60px"
                 data-ad-client="ca-pub-5451183272464388"
                 data-ad-slot="8388800134"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div class="col-xs-12 col-sm-8">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- 728x90, created 11/14/10 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-5451183272464388"
                 data-ad-slot="2985692171"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>

    <section id="announcement" class="row">
        <div class="col-xs-12 col-md-8 no-padding">
            <div class="col-xs-12"><h3 class="category-heading"><a href="{{route('front.announcement.index')}}"
                                                                   class="link" target="_blank">Announcements</a></h3>
            </div>
            <div class="col-xs-12">
                <div class="box">
                    <div class="news-media-list">
                        @foreach($announcements as $i=>$a)
						<a href="{{$a->getLink('front.announcement.show',$a->type->label)}}" class="link">
                            <div class="media row">
                                <div class="col-xs-12 col-sm-3">
                                    <img class="media-object" src="{{$a->imageThumbnail(100,200)}}">
                                </div>
                                <div class="col-xs-12 col-sm-9 media-desc">
                                    <?php
                                    $showAbleIcon = (strpos($a->timeAgo(),'ago') !== false) ? '<i class="fa fa-clock-o"></i>' : '<i class="fa fa-calendar-o"></i>';
                                    ?>
                                    <span class="pull-right nsm-datetime nsm-badge">{!! $showAbleIcon !!} {{$a->timeAgo()}}</span>
                                    <h5 class="media-heading">{{$a->title}}</h5>

                                    <p>{{ucwords($a->type->label)}}@if($a->subtype!=null)
                                            | {{ucwords($a->subtype->label)}}@endif<br>
                                        @if(!is_null($a->event) || $a->event!="0000-00-00")
                                            Event: {{date_create($a->event)->format('M jS')}}
                                        @endif
                                        @if(!is_null($a->issue))
                                            @if(!is_null($auction = $a->issue->auction))
                                                @if(!is_null($auction->ordinary) && $auction->ordinary != 0)
                                                    | Ordinary: {{$auction->ordinary}}
                                                @endif
                                                @if(!is_null($auction->promoter) && $auction->promoter != 0)
                                                    | Promoter: {{$auction->promoter}}
                                                @endif
                                            @else
                                                | Close Date : {{date_create($a->issue->close_date)->format('M jS')}} |
                                                Kitta: {{$a->issue->kitta}}
                                            @endif
                                        @elseif(!is_null($a->agm))
                                            | Time: {{date_create($a->agm->time)->format('h:i A') }} |
                                            Venue: {{ $a->agm->venue }}
                                        @elseif(!is_null($a->financialHighlight))
                                            | Net Profit <small><i>(in thousand)</i></small>: {{ $a->financialHighlight->net_profit }}
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
							</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4 no-padding">
            <div class="col-xs-12">
                <h3 class="category-heading">
                    <a href="{{route('event')}}" class="link" target="_blank">Events</a>
                </h3>
            </div>
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-12">
                        <div class="box">
                            <div class="news-media-list no-padding no-margin no-border">
                                <div class="col-xs-12 news-data" style="padding:0.4rem 0;">
                                    <div class="col-xs-10 fh-value">
                                        Title
                                    </div>
                                    <div class="col-xs-2 fh-value">
                                        Date
                                    </div>
                                </div>
                                @foreach($events as $event)
                                    <div class="col-xs-12 news-data" style="padding:0.4rem 0;">
                                        <div class="col-xs-10">
											<h5 style="margin-top:10px;">
												<a href="{{$event->getLink('front.announcement.show',$event->type->label)}}"
												   rel="nofollow" class="link"
												   target="_blank">{{mb_strimwidth(strip_tags($event->title),0,42,"...")}}</a>
											</h5>
                                        </div>
                                        <div class="col-xs-2 fh-label">
											@if(date_create($event->event_date)->format('M jS') == date_create(date('Y-m-d'))->format('M jS'))
												Today
											@else
												{{date_create($event->event_date)->format('M jS')}}
											@endif
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

    <section id="bonus-dividend" class="row" style="margin-top:20px;">
        <div id="bodApproved" class="col-md-6 col-xs-12">
            <div class="col-xs-12 no-padding">
                <h4 class="category-heading">
                    <a href="{{route('front.bodApproved')}}" class="link" target="_blank">Benifits BOD Approved</a>
                </h4>
            </div>
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
                                <a href="{{$ba->announcement->getLink('front.announcement.show',$ba->announcement->type->label)}}"
                                   class="link" target="_blank">
                                    {{$ba->company->quote}}
                                </a>
                            </td>
                            <td>{{$ba->bonus_share==0 || $ba->bonus_share==null ? 'NA' : $ba->bonus_share}}</td>
                            <td>{{$ba->cash_dividend}}</td>
                            <td>{{date_create($ba->distribution_date)->format('M-d')}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No Data Available</td>
                    <tr>
                @endif
                </tbody>
            </table>
        </div>
        <div id="annualGeneralMeeting" class="col-md-6 col-xs-12">
            <div class="col-xs-12 no-padding">
                <h4 class="category-heading">
                    <a href="{{route('front.agm')}}" class="link" target="_blank">Annual General Meeting (AGM)</a>
                </h4>
            </div>
            <table id="datatable" class="table datatable table-condensed table-striped table-responsive with-border"
                   width="100%">
                <thead>
					<tr>
                    <th style="width:15%;">Quote</th>
                    <th style="width:70%;">Venue</th>
                    <th style="width:15%;">Date</th>
                </tr>
                </thead>
                <tbody>
                @if(!($annualGeneralMeeting->isEmpty()))
                    @foreach($annualGeneralMeeting as $value)
                        <?php $agm = $value->agm; ?>
                        <tr>
                            <td>
                                <a href="{{$agm->announcement->getLink('front.announcement.show',$agm->announcement->type->label)}}"
                                   class="link" target="_blank">
                                    {{$agm->company->quote}}
                                </a>
                            </td>
                            <td>{{$agm->venue}}</td>
                            <td>{{date_create($agm->agm_date)->format('M-d')}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No Data Available</td>
                    <tr>
                @endif
                </tbody>
            </table>
        </div>

        <div id="current-upcoming-issue" class="col-md-12 col-xs-12">
            <div class="col-xs-12 no-padding">
                <h4 class="category-heading">
                    <a href="{{route('front.issue')}}" class="link" target="_blank">Current/Upcoming Issue</a>
                </h4>
            </div>
            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php $count=0; ?>
                    @foreach($issues as $key => $issue)
                        <?php $count++; ?>
                        <li role="presentation" class="{{ $count == 1 ? 'active' : '' }}">
                            <a href="#{{ str_slug($key) }}" aria-controls="{{ $key }}" role="tab" data-toggle="tab">{{ strtoupper($key) }}</a>
                        </li>
                    @endforeach
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php $count=0; ?>
                    @foreach($issues as $key => $issueList)
                        <?php $count++; ?>
                        <div role="tabpanel" class="tab-pane {{ $count == 1 ? 'active' : '' }}" id="{{ str_slug($key) }}">
                            <table class="table datatable table-responsive table-striped table-condensed with-border" width="100%">
                                <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Type</th>
                                    <th>Kitta</th>
                                    <th>Issue Date</th>
                                    <th>Close Date</th>
                                    <th>Issue Manager</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($issueList as $value)
                                    @foreach($value as $issue)
                                        <?php
                                        $name=$issue->name;
                                        $subLabel=$issue->subLabel;
                                        $today = Carbon\Carbon::today();
                                        $issue_date=Carbon\Carbon::createFromFormat('Y-m-d', $issue->issue_date);
                                        $close_date=Carbon\Carbon::createFromFormat('Y-m-d', $issue->close_date);
                                        $status="";
                                        $class="";
                                        if($today->gt($close_date)){
                                            $status = "Closed";
                                            $class="danger";
                                        }
                                        elseif($today->gt($issue_date) && ($today->lt($close_date) || $today->eq($close_date))){
                                            $status = "Open";
                                            $class="success";
                                        }
                                        elseif($today->lt($issue_date)){
                                            $status = "Coming Soon";
                                            $class="warning";
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="{{$issue->getLink('front.announcement.show',$issue->label)}}" class="link"
                                                   target="_blank">
                                                    {{$name}}
                                                </a>
                                            </td>
                                            <td>{{strtoupper($subLabel)}}</td>
                                            <td>{{strtoupper($issue->kitta)}}</td>
                                            <td>{{$issue_date->format('M-d')}}</td>
                                            <td>{{$close_date->format('M-d')}}</td>
                                            <td>{{$issue->issueManager}}</td>
                                            <td class="{{ $class }}">{{$status}}</td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">No data available.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="market-index" class="row">
        <div class="col-xs-12 col-md-7">
            <h3 class="category-heading"><a href="{{route('stock','index')}}" class="link" target="_blank">Index
                    Chart</a> |<a href="{{route('technical-analysis-index','nepse')}}" class="btn btn-link btn-lg" title="In-Depth Analysis" target="_blank"><i class="fa fa-external-link"></i></a></h3>

            <div class="box chart-container" id="chart-container" style="min-height: 420px;">

            </div>
        </div>
        <div class="col-xs-12 col-md-5">
            <h3 class="category-heading"><a href="{{route('stock','index')}}" class="link" target="_blank">Market
                    Index</a><span class="date"> ({{date_create($index->date)->format('M jS')}})</span></h3>
            <table id="indexDatatable"
                   class="table datatable table-condensed table-striped table-responsive display no-wrap" width="100%">
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
    </section>

    <section id="news-category">
        <?php  $categories = ['stock','bullion','currency','energy']; ?>
        @foreach($categories as $cat)
            <div class="row">
                <?php $category = $filter($newsCategories,['label'],$cat); ?>
                <div id="{{strtolower($cat)}}" class="col-xs-12">
                    <h3 class="category-heading"><a href="{{route('front.news.category',str_slug($cat))}}"
                                                    class="link">{{ucwords($cat)}}</a></h3>

                    <div class="row news-list">
                        @foreach($category->recentNews() as $categoryNews)
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="box">
                                    <figure class="captionize">
										<div class="thumb-wrapper">
											<img src="{{$categoryNews->imageNewsFirst->getThumbnail(360,720) }}"
												 alt="{{$categoryNews->title}}" class="img-responsive"/>
											<div class="figure-social-share-wrapper">
												<div class="btn-group figure-social-share">
													<a href="http://www.facebook.com/sharer.php?u={{urlencode($categoryNews->getLink('front.news.show',$categoryNews->category->label))}}"
													   target="_blank" class="js-social-share facebook">
														<i class="fa fa-facebook-square fa-2x"></i>
													</a>
													<a href="https://twitter.com/intent/tweet?text={{urlencode($categoryNews->title)}}&url={{urlencode($categoryNews->getLink('front.news.show',$categoryNews->category->label))}}&via=investonepal"
													   target="_blank" class="js-social-share twitter">
														<i class="fa fa-twitter-square fa-2x"></i>
													</a>
												</div>
											</div>
										</div>
                                        <figcaption>
                                            <h4 class="{{is_nepali($categoryNews->title)?'np':''}}"><a
                                                        href="{{$categoryNews->getLink('front.news.show',$cat)}}"
                                                        class="link"
                                                        target="_blank">{{$categoryNews->title}} <small>({{date_create($categoryNews->pub_date)->format('M-d')}})</small></a></h4>

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
        $('.news-media-list').slimScroll({height: '484px',allowPageScroll:true});
        var getIndexUrl = "{{route('api-get-index')}}";
        var indexSummaryDatatableURL = "{{route('api-get-index-summary-datatable')}}";
    </script>
    {!! HTML::script('vendors/highstock/js/highstock.js') !!}
    {!! HTML::script('vendors/highstock/js/exporting.js') !!}
    {!! HTML::script('vendors/tabdrop/js/bootstrap-tabdrop.js') !!}
    {!! HTML::script('assets/nsm/front/js/home.js') !!}
@endsection
