@extends('front.main')

@section('title')
    {{ucwords($company->name)}}
@endsection

@section('specificheader')
{!! HTML::style('assets/nsm/front/css/quote.css') !!}
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.4.0/animate.min.css" rel="stylesheet" type="text/css">
<style type="text/css">
    .bod th{
        color:white;
    }
	.quote-charts .tab-content{
		background: url(/images/loader.gif) no-repeat center;
	}
</style>
@endsection

@section('content')
<section class="main-content row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-12 text-center no-padding">
    			<div class="heading{{$company->quote}} company-heading">
                    <h1 class="cover-heading">{{ucwords($company->name)}}<span>({{strtoupper($company->quote)}})</span></h1>
                    <h4 class="lead">
                    @if(!is_null($company->details->address) && $company->details->address!="")
                        {{$company->details->address}};
                    @endif
                    @if(!is_null($company->details->phone) && $company->details->phone!="")
                        Ph: {{$company->details->phone}}
                    @endif
                    </h4>
                    <h5>RTS: {!! isset($rts->id) ? "<a href='".route('front.issueManager','id='.$rts->id)."' target='_blank'>".$rts->company."</a>" : $rts !!}</h5>
                </div>
            </div>
        </div>
        <div class="row company-data">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <span class='date'>As on <h3><span data-value="last-date"></span></h3></span>
                            </div>
                            <div class="col-sm-12">
                                <span class="close-price-wrapper"><span class="rs">Rs.</span><span data-value="close-price" class="close-price"></span></span>
                            </div>
                            <div class="col-sm-12">
                                <div class="change">
                                    <span class="amount" data-value="change-amt" data-change=''></span>,
                                    <span class="percent" data-value="change-per" data-change=''></span>
                                    <i class="delta-bar fa"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 trans">
                        <div class="transaction row">
                            <span class="col-sm-12 trans-header"><abbr title="Transaction">Tran.</abbr></span>
                            <span class="col-sm-12 trans-data" data-value="totaltran"></span>
                        </div>
                        <div class="volume row">
                            <span class="col-sm-12 trans-header"><abbr title="Total Volume of Shares">Volume</abbr></span>
                            <span class="col-sm-12 trans-data" data-value="totalshare"></span>
                        </div>
                        <div class="amount row">
                            <span class="col-sm-12 trans-header"><abbr title="Total Amount">Amount</abbr></span>
                            <span class="col-sm-12 trans-data" data-value="totalamt"></span>
                        </div>
                    </div>
                </div>
                <div class="row data-collection hidden-xs hidden-sm">
                    <div class="col-sm-3">  
                        <div class="data-header"><abbr title="Opening Price">Open</abbr></div>
                        <div class="data-data" data-value="open">-</div>
                    </div>
                    <div class="col-sm-3">  
                        <div class="data-header"><abbr title="Highest Price">High</abbr></div>
                        <div class="data-data" data-value="high">-</div>
                    </div>
                    <div class="col-sm-3">  
                        <div class="data-header"><abbr title="Lowest Price">Low</abbr></div>
                        <div class="data-data" data-value="low">-</div>
                    </div>
                    <div class="col-sm-3">  
                        <div class="data-header"><abbr title="Prior Closing Price">P.Close</abbr></div>
                        <div class="data-data" data-value="previous">-</div>
                    </div>
                </div>
                <div class="row data-collection hidden-xs hidden-sm">   
                    <div class="col-sm-3">  
                        <div class="data-header"><abbr title="52 Week Highest Price">52 High</abbr></div>
                        <div class="data-data" data-value="52max">-</div>
                    </div>
                    <div class="col-sm-3">  
                        <div class="data-header"><abbr title="52 Week Lowest Price">52 Low</abbr></div>
                        <div class="data-data" data-value="52min">-</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="data-header"><abbr title="52 Week Date Range">52 Range</abbr></div>
                        <div class="date-range" data-value="date-range"></div>
                    </div>
                </div>
                <div class="row ratings-wrapper">
                    <div class="col-md-12">
                        <div class="data-header" style="position:relative">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default btn-sm review-toggle"><i class="fa fa-heart-o"></i> Review</button>
                                <button type="button" class="btn btn-default btn-sm watchlist-toggle">
                                @if(isset($watchlist))
                                    <i class="fa text-danger fa-heart"></i> Added to WatchList
                                @else
                                    <i class="fa fa-heart-o"></i> Add to WatchList
                                @endif
                                </button>
                            </div>
                            <div class="popover fade bottom in review no-padding" role="tooltip">
                                <div class="arrow" style="left: 13%;"></div>
                                <h3 class="popover-title">Write a Review
                                    <button type="button" class="pull-right review-close">&times;</button>
                                </h3>
                                <div class="popover-content">
                                    <div class="review-button">
                                        <input id="buy" class="cmn-toggle cmn-toggle-yes-no" type="radio" name="review_type" value="b" {{isset($personalReview['type'])&&$personalReview->type=='b'?'checked':''}}>
                                        <label for="buy" data-on="Buy" data-off="Buy"></label>
                                        <input id="sell" class="cmn-toggle cmn-toggle-yes-no" type="radio" name="review_type" value="s" {{isset($personalReview['type'])&&$personalReview->type=='s'?'checked':''}}>
                                        <label for="sell" data-on="Sell" data-off="Sell"></label>
                                        <input id="hold" class="cmn-toggle cmn-toggle-yes-no" type="radio" name="review_type" value="h" {{isset($personalReview['type'])&&$personalReview->type=='h'?'checked':''}}>
                                        <label for="hold" data-on="Hold" data-off="Hold"></label>
                                        {!! Form::input('button','','Submit',['class'=>'btn btn-primary pull-right review-submit']) !!}
                                    </div>
                                    <div class="review-textarea">
                                        <textarea name="review_text" class="form-control" rows="4">{{isset($personalReview['review'])?$personalReview->review:''}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="progress ratings">
                                    <div class="progress-bar progress-bar-success buy" style="width: 0%; transition: all 0.5s;"></div>
                                    <div class="progress-bar progress-bar-danger sell" style="width: 0%; transition: all 0.5s;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 label pull-right">
                                <span class="legend legend-buy"><span class="legend-box">&nbsp;</span> Buy</span>
                                <span class="legend legend-sell"><span class="legend-box">&nbsp;</span> Sell</span>
                                <span class="legend legend-hold"><span class="legend-box">&nbsp;</span> Hold</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <!-- tabs bottom -->
                <div class="tabbable tabs-below quote-charts">
                    <div class="tab-content">
                        <div class="tab-pane active chart-wrapper" id="one_">
                       		<div id="company-ohlcv" style="height:400px;"></div>
                   		</div>
                        <div class="tab-pane chart-wrapper" id="two_">
                       		<div id="company-tran" style="height:400px;" class="chart-container"></div>
                       	</div>
                        <ul class="nav nav-pills clear-fix">
                            <li class="active"><a href="#one_" data-toggle="tab" id="OHLC-chart">OHLC</a></li>
                            <li><a href="#two_" data-toggle="tab" id="floorsheet-chart">Floorsheet</a></li>
                        </ul>
                    </div>
                <!-- /tabs -->
                </div>
            </div>
        </div>
        <div class="row tabs-container">
            <div class="col-md-12 no-padding">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="quote-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Overview</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
                    @if(!$company->bod->isEmpty())
                    <li role="presentation"><a href="#bods" aria-controls="bod" role="tab" data-toggle="tab" id="bod-tab">BOD & MGMT</a></li>
                    @endif
                    <li role="presentation"><a href="{{route('technical-analysis',$company->quote)}}" target="_blank">Chart</a></li>
                    @if($company->sector->label == 'Commercial Bank' || $company->sector->label == 'Development Bank' || $company->sector->label == 'Finance')
                        <li role="presentation"><a href="#financial" aria-controls="financial" role="tab" data-toggle="tab">Financial Report</a></li>
                    @endif
                    <li role="presentation"><a href="#published-report" aria-controls="published-report" role="tab" data-toggle="tab" id="published-report-tab">Published Report</a></li>
                    <li role="presentation"><a href="#floorsheet" aria-controls="floorsheet" role="tab" data-toggle="tab" id="floorsheet-tab">Floorsheet</a></li>
                    <li role="presentation"><a href="#closeprice" aria-controls="closeprice" role="tab" data-toggle="tab" id="closeprice-tab">Close Price</a></li>
                    <li role="presentation"><a href="#competitor" aria-controls="competitor" role="tab" data-toggle="tab" id="competitor-tab">Competitors</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content quote-tabs">
                    <div role="tabpanel" class="tab-pane active" id="overview">
                        @if(!is_null($financialHighlight))
                        <div class="panel panel-default no-margin" style="padding:0 15px;">
                            <div class="panel-body">
                                <div class="title"><h3 class="category-heading no-margin">Financial Highlights <span class="fh-label">({{$financialHighlight->announcement->subtype->label}}, {{$financialHighlight->fiscalYear->label}})</span></h3></div>
                                <div class="row" id="financial-highlight">
                                    <div class="col-md-3 col-xs-12 fh-column">
                                        <div class="row">
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Earning Per Share</div>
                                                <div class="fh-value">{{$financialHighlight->earning_per_share}}</div>
                                            </div>
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Net Asset Per Share</div>
                                                <div class="fh-value">{{$financialHighlight->book_value_per_share}}</div>
                                            </div>
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Net Worth Per Share</div>
                                                <div class="fh-value">{{$financialHighlight->net_worth_per_share}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-12 fh-column">
                                        <div class="row">
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Paid up Capital<small>(Rs in '000')</small></div>
                                                <div class="fh-value">{{$financialHighlight->paid_up_capital}}</div>
                                            </div>
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Reserve and Surplus<small>(Rs in '000')</small></div>
                                                <div class="fh-value">{{$financialHighlight->reserve_and_surplus}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-12 fh-column">
                                        <div class="row">
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Operating Profit<small>(Rs in '000')</small></div>
                                                <div class="fh-value">{{$financialHighlight->operating_profit}}</div>
                                            </div>
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Net Profit<small>(Rs in '000')</small></div>
                                                <div class="fh-value">{{$financialHighlight->net_profit}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-12 fh-column">
                                        <div class="row">
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Price Earning Ratio</div>
                                                <div class="fh-value">{{$financialHighlight->price_earning_ratio}}</div>
                                            </div>
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Liquidity Ratio</div>
                                                <div class="fh-value">{{$financialHighlight->liquidity_ratio}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="panel panel-default no-margin">
                                <div class="panel-body">
                                    <div class="well well-sm no-margin">
                                        <center>No financial highlights available.</center>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row" id="news-announcement">
								@if(!$newsList->isEmpty())
                                    <div class="col-md-6 col-xs-12 news-column row">
                                    <div class="col-xs-12 title"><a href="{{ route('front.news.quote', $company->quote) }}" target="_blank"><h3 class="category-heading no-margin">News</h3></a></div>
                                        @foreach($newsList as $news)
                                            <div class="col-xs-12 news-data">
                                                <div class="col-xs-2 fh-label">
                                                    {{$news->timeAgo()}}
                                                </div>
                                                <div class="col-xs-10 fh-value">
                                                    <a href="{{$news->getLink('front.news.show',$news->category->label)}}" class="link" target="_blank">{{mb_strimwidth($news->title,0,52,"...")}}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-xs-12 news-data text-right">
                                            <a href="{{ route('front.news.quote', $company->quote) }}" target="_blank">View ALL >></a>
                                        </div>
                                    </div>
								@else
									<div class="well well-sm">
										<center>No news available.</center>
									</div>
								@endif
								@if(!$annList->isEmpty())
                                    <div class="col-md-6 col-xs-12 announcement-column row">
                                    <div class="col-xs-12 title"><a href="{{ route('front.announcement.quote', $company->quote) }}" target="_blank"><h3 class="category-heading no-margin">Announcement</h3></a></div>
                                        @foreach($annList as $ann)
                                            <div class="col-xs-12 news-data">
                                                <div class="col-xs-2 fh-label">
                                                    {{$ann->timeAgo()}}
                                                </div>
                                                <div class="col-xs-10 fh-value">
                                                    <a href="{{$ann->getLink('front.announcement.show',$ann->type->label)}}" class="link" target="_blank">{{mb_strimwidth($ann->title,0,52,"...")}}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-xs-12 news-data text-right">
                                            <a href="{{ route('front.announcement.quote', $company->quote) }}" target="_blank">View ALL >></a>
                                        </div>
                                    </div>
								@else
									<div class="well well-sm">
										<center>No announcement available.</center>
									</div>
								@endif
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row" id="bonus-dividend">
                                    <div class="col-xs-12">
                                        <table id="bonusDividendDatatable" class="table datatable table-condensed table-striped table-responsive with-border display no-wrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Fiscal Year</th>
                                                    <th>Bonus Share</th>
                                                    <th>Cash Dividend</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row" style="padding-bottom:10px;">
                                    <div class="col-md-9 col-xs-12 pull-right">
                                        <div class="row">
                                            <div class="col-md-4 col-xs-6">
                                                <div class="fh-data-pro">
                                                    <div class="fh-label">Sector</div>
                                                    <div class="fh-value">{{$company->sector->label}}</div>
                                                </div>
                                                <div class="fh-data-pro">
                                                    <div class="fh-label">Operation Date</div>
                                                    <div class="fh-value">{{$company->details->operation_date=="0000-00-00" || $company->details->operation_date==NULL ? 'NA' : $company->details->operation_date}}</div>
                                                </div>
                                                <div class="fh-data-pro">
                                                    <div class="fh-label">Listed Status</div>
                                                    <div class="fh-value">{{$company->listed=="0"?'No':'Yes'}}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-center hidden-sm hidden-xs">
                                                @if(url_exists($company->getImage()))
                                                    <div class="company-logo thumbnail">
                                                        <img src="{{$company->getImage()}}" alt="{{$company->name}}">
                                                    </div>
                                                @else
														<div class="title"><h3 class="fh-value category-heading no-margin no-border">Company Description</h3></div>
                                                @endif
                                            </div>
                                            <div class="col-md-4 col-xs-6 text-right">
                                                <div class="fh-data-pro">
                                                    <div class="fh-label">Face Value</div>
                                                    <div class="fh-value">{{$company->face_value}}</div>
                                                </div>
                                                <div class="fh-data-pro">
                                                    <div class="fh-label">Listed Share</div>
                                                    <div class="fh-value">{{$company->listed_shares==NULL || $company->listed_shares=="" ? 'NA' : $company->listed_shares}}</div>
                                                </div>
                                                <div class="fh-data-pro">
                                                    <div class="fh-label">Market Capitalization</div>
                                                    <div class="fh-value" id="mktcap" data-listed-shares="{{$company->listed_shares}}"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="title hidden-lg"><h3 class="category-heading" style="margin-top:10px;">Company Description</h3></div>
                                            @if($company->details->profile=="" || $company->details->profile==null)
                                                <div class="panel panel-default no-margin">
                                                    <div class="panel-body">
                                                        <div class="well well-sm no-margin">
                                                            <center>Company description currently unavailable.</center>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="company-profile text-justify">{!! $company->details->profile !!}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-12 pull-left">
                                        <span class="category-heading fh-value">Contact Information</span>
                                        <div class="row" style="padding:0 15px;">
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Address</div>
                                                <?php $ad=$company->details->address;?>
                                                <div class="fh-value">{{$ad==null || $ad=="" ? 'NA' : $ad}}</div>
                                            </div>
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Phone</div>
                                                <?php $ph=$company->details->phone;?>
                                                <div class="fh-value">{{$ph==null || $ph=="" ? 'NA' : $ph}}</div>
                                            </div>
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">Web</div>
                                                <?php $web=$company->details->web;?>
                                                <div class="fh-value"><a href="{{$web==null || $web=="" ? '#' : $web}}" target="_blank">{{$web==null || $web=="" ? 'NA' : $web}}</a></div>
                                            </div>
                                            <div class="col-xs-12 fh-data">
                                                <div class="fh-label">E-Mail</div>
                                                <?php $email=$company->details->email;?>
                                                <div class="fh-value">{{$email==null || $email=="" ? 'NA' : $email}}</div>
                                            </div>
                                            <div class="col-xs-12 fh-data">
                                                <div class="category-heading fh-value">RTS</div>
                                                <div class="fh-value">{!! isset($rts->id) ? "<a href='".route('front.issueManager','id='.$rts->id)."' target='_blank'>".$rts->company."</a>" : $rts !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					@if($company->sector->label == 'Commercial Bank' || $company->sector->label == 'Development Bank' || $company->sector->label == 'Finance')
                    <div role="tabpanel" class="tab-pane" id="financial">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12 no-padding">
                                        <div class="tab-content financial-report-table">
                                            <ul class="nav nav-pills">
                                                <li class="active"><a href="#balanceSheet" data-toggle="tab">Balance Sheet</a></li>
                                                @if(array_key_exists('profitLoss',$report))
                                                    <li><a href="#profitLoss" data-toggle="tab">Profit Loss</a></li>
                                                @endif
                                                @if(array_key_exists('principalIndicators',$report))
                                                    <li><a href="#principalIndicators" data-toggle="tab">Principle Indicators</a></li>
                                                @endif
                                                @if(array_key_exists('incomeStatement',$report))
                                                    <li><a href="#incomeStatement" data-toggle="tab">Income Statement</a></li>
                                                @endif
                                                @if(array_key_exists('consolidateRevenue',$report))
                                                    <li><a href="#consolidateRevenue" data-toggle="tab">Consolidate Revenue Account</a></li>
                                                @endif
                                            </ul>
                                            <div role="tabpanel" class="tab-pane active" id="balanceSheet">
                                                <div class="tab-content">
                                                    <ul class="nav nav-pills sub-menu" id="balanceSheet_tabs">
                                                        <li class="active"><a href="#bsquarterly" data-toggle="tab">Quarterly Report</a></li>
                                                        <li><a href="#bsannual" data-toggle="tab">Annual Report</a></li>
                                                    </ul>
                                                    <div role="tabpanel" class="tab-pane active" id="bsquarterly">
                                                        <table class="table datatable table-condensed table-hover table-striped with-border">
                                                            <thead>
                                                                <tr>
                                                                    <th>In Thousands</th>
                                                                    @foreach($report['balanceSheet']['quarter'] as $key=>$bs)
                                                                        <th class="text-right">{{$bs->first()->qlabel}}</th>
                                                                    @endforeach
                                                                </tr>
																<tr>
																	<th>(except for per share items)</th>
																	@foreach($report['balanceSheet']['quarter'] as $key=>$bs)
                                                                        <th class="text-right">{{$bs->first()->fylabel}}</th>
                                                                    @endforeach
																</tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($reportLabel->where('type','bs')->lists('label','id') as $rid=>$label)
                                                                    <tr>
                                                                        <td>{{$label}}</td>
                                                                        @foreach($report['balanceSheet']['quarter'] as $bs)
                                                                            <?php $flag = 0;?>
                                                                            <td class="text-right">
                                                                                @foreach($bs as $sheet)
                                                                                    @if($sheet->label_id == $rid)
                                                                                        {{$sheet->value}}
                                                                                        <?php $flag=1 ?>
                                                                                    @endif
                                                                                @endforeach
                                                                                @if($flag==0)
                                                                                    {{'-'}}
                                                                                @endif
                                                                            </td>
                                                                        @endforeach
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane" id="bsannual">
                                                        <table class="table datatable table-condensed table-hover table-striped with-border">
                                                            <thead>
                                                                <tr>
                                                                    <th>In Thousands</th>
                                                                    @foreach($report['balanceSheet']['annual'] as $key=>$bs)
                                                                        <th class="text-right">{{$bs->first()->fylabel}}</th>
                                                                    @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($reportLabel->where('type','bs')->lists('label','id') as $rid=>$label)
                                                                    <tr>
                                                                        <td>{{$label}}</td>
                                                                        @foreach($report['balanceSheet']['annual'] as $bs)
                                                                            <?php $flag = 0;?>
                                                                            <td class="text-right">
                                                                                @foreach($bs as $sheet)
                                                                                    @if($sheet->label_id == $rid)
                                                                                        {{$sheet->value}}
                                                                                        <?php $flag=1 ?>
                                                                                    @endif
                                                                                @endforeach
                                                                                @if($flag==0)
                                                                                    {{'-'}}
                                                                                @endif
                                                                            </td>
                                                                        @endforeach
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(array_key_exists('profitLoss',$report))
                                                <div role="tabpanel" class="tab-pane" id="profitLoss">
                                                    <div class="tab-content">
                                                        <ul class="nav nav-pills sub-menu" id="profitLoss_tabs">
                                                            <li class="active"><a href="#plquarterly" data-toggle="tab">Quarterly Report</a></li>
                                                            <li><a href="#plannual" data-toggle="tab">Annual Report</a></li>
                                                        </ul>
                                                        <div role="tabpanel" class="tab-pane active" id="plquarterly">
                                                            <table class="table datatable table-condensed table-hover table-striped with-border">
                                                                <thead>
                                                                    <tr>
                                                                        <th>In Thousands</th>
                                                                        @foreach($report['profitLoss']['quarter'] as $key=>$pl)
                                                                            <th class="text-right">{{$pl->first()->qlabel}}</th>
                                                                        @endforeach
                                                                    </tr>
																	<tr>
                                                                        <th>(except for per share items)</th>
                                                                        @foreach($report['profitLoss']['quarter'] as $key=>$pl)
                                                                            <th class="text-right">{{$pl->first()->fylabel}}</th>
                                                                        @endforeach
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($reportLabel->where('type','pl')->lists('label','id') as $rid=>$label)
                                                                        <tr>
                                                                            <td>{{$label}}</td>
                                                                            @foreach($report['profitLoss']['quarter'] as $pl)
                                                                                <?php $flag = 0;?>
                                                                                <td class="text-right">
                                                                                    @foreach($pl as $sheet)
                                                                                        @if($sheet->label_id == $rid)
                                                                                            {{$sheet->value}}
                                                                                            <?php $flag=1 ?>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    @if($flag==0)
                                                                                        {{'-'}}
                                                                                    @endif
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div role="tabpanel" class="tab-pane" id="plannual">
                                                            <table class="table datatable table-condensed table-hover table-striped with-border">
                                                                <thead>
                                                                    <tr>
                                                                        <th>In Thousands (except for per share items)</th>
                                                                        @foreach($report['profitLoss']['annual'] as $key=>$pl)
                                                                            <th class="text-right">{{$pl->first()->fylabel}}</th>
                                                                        @endforeach
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($reportLabel->where('type','pl')->lists('label','id') as $rid=>$label)
                                                                        <tr>
                                                                            <td>{{$label}}</td>
                                                                            @foreach($report['profitLoss']['annual'] as $pl)
                                                                                <?php $flag = 0;?>
                                                                                <td class="text-right">
                                                                                    @foreach($pl as $sheet)
                                                                                        @if($sheet->label_id == $rid)
                                                                                            {{$sheet->value}}
                                                                                            <?php $flag=1 ?>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    @if($flag==0)
                                                                                        {{'-'}}
                                                                                    @endif
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(array_key_exists('principalIndicators',$report))
                                                <div role="tabpanel" class="tab-pane" id="principalIndicators">
                                                    <div class="tab-content">
                                                        <ul class="nav nav-pills sub-menu" id="principalIndicators_tabs">
                                                            <li class="active"><a href="#piannual" data-toggle="tab">Annual Report</a></li>
                                                        </ul>
                                                        <div role="tabpanel" class="tab-pane active" id="piannual">
                                                            <table class="table datatable table-condensed table-hover table-striped with-border">
                                                                <thead>
                                                                    <tr>
                                                                        <th>In Thousands (except for per share items)</th>
                                                                        @foreach($report['principalIndicators']['annual'] as $key=>$pi)
                                                                            <th class="text-right">{{$pi->first()->fylabel}}</th>
                                                                        @endforeach
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($reportLabel->where('type','pi')->lists('label','id') as $rid=>$label)
                                                                        <tr>
                                                                            <td>{{$label}}</td>
                                                                            @foreach($report['principalIndicators']['annual'] as $pi)
                                                                                <?php $flag = 0;?>
                                                                                <td class="text-right">
                                                                                    @foreach($pi as $sheet)
                                                                                        @if($sheet->label_id == $rid)
                                                                                            {{$sheet->value}}
                                                                                            <?php $flag=1 ?>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    @if($flag==0)
                                                                                        {{'-'}}
                                                                                    @endif
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(array_key_exists('incomeStatement',$report))
                                                <div role="tabpanel" class="tab-pane" id="incomeStatement">
                                                    <div class="tab-content">
                                                        <ul class="nav nav-pills sub-menu" id="incomeStatement_tabs">
                                                            <li class="active"><a href="#isquarterly" data-toggle="tab">Quarterly Report</a></li>
                                                            <li><a href="#isannual" data-toggle="tab">Annual Report</a></li>
                                                        </ul>
                                                        <div role="tabpanel" class="tab-pane active" id="isquarterly">
                                                            <table class="table datable table-condensed table-hover table-striped with-border">
                                                                <thead>
                                                                    <tr>
                                                                        <th>In Thousands</th>
                                                                        @foreach($report['incomeStatement']['quarter'] as $key=>$is)
                                                                            <th class="text-right">{{$is->first()->qlabel}}</th>
                                                                        @endforeach
                                                                    </tr>
																	<tr>
                                                                        <th>(except for per share items)</th>
                                                                        @foreach($report['incomeStatement']['quarter'] as $key=>$is)
                                                                            <th class="text-right">{{$is->first()->fylabel}}</th>
                                                                        @endforeach
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($reportLabel->where('type','is')->lists('label','id') as $rid=>$label)
                                                                        <tr>
                                                                            <td>{{$label}}</td>
                                                                            @foreach($report['incomeStatement']['quarter'] as $is)
                                                                                <?php $flag = 0;?>
                                                                                <td class="text-right">
                                                                                    @foreach($is as $sheet)
                                                                                        @if($sheet->label_id == $rid)
                                                                                            {{$sheet->value}}
                                                                                            <?php $flag=1 ?>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    @if($flag==0)
                                                                                        {{'-'}}
                                                                                    @endif
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div role="tabpanel" class="tab-pane" id="isannual">
                                                            <table class="table datable table-condensed table-hover table-striped with-border">
                                                                <thead>
                                                                    <tr>
                                                                        <th>In Thousands (except for per share items)</th>
                                                                        @foreach($report['incomeStatement']['annual'] as $key=>$is)
                                                                            <th class="text-right">{{$is->first()->fylabel}}</th>
                                                                        @endforeach
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($reportLabel->where('type','is')->lists('label','id') as $rid=>$label)
                                                                        <tr>
                                                                            <td>{{$label}}</td>
                                                                            @foreach($report['incomeStatement']['annual'] as $is)
                                                                                <?php $flag = 0;?>
                                                                                <td class="text-right">
                                                                                    @foreach($is as $sheet)
                                                                                        @if($sheet->label_id == $rid)
                                                                                            {{$sheet->value}}
                                                                                            <?php $flag=1 ?>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    @if($flag==0)
                                                                                        {{'-'}}
                                                                                    @endif
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(array_key_exists('consolidateRevenue',$report))
                                                <div role="tabpanel" class="tab-pane" id="consolidateRevenue">
                                                    <div class="tab-content">
                                                        <ul class="nav nav-pills sub-menu" id="consolidateRevenue_tabs">
                                                            <li class="active"><a href="#crquarterly" data-toggle="tab">Quarterly Report</a></li>
                                                            <li><a href="#crannual" data-toggle="tab">Annual Report</a></li>
                                                        </ul>
                                                        <div role="tabpanel" class="tab-pane" id="crquarterly">
                                                            <table class="table datatable table-condensed table-hover table-striped with-border">
                                                                <thead>
                                                                    <tr>
                                                                        <th>In Thousands (except for per share items)</th>
                                                                        @foreach($report['consolidateRevenue']['quarter'] as $key=>$cr)
                                                                            <th class="text-right">{{$cr->first()->qlabel}}</th>
                                                                        @endforeach
                                                                    </tr>
																	<tr>
                                                                        <th>(except for per share items)</th>
                                                                        @foreach($report['consolidateRevenue']['quarter'] as $key=>$cr)
                                                                            <th class="text-right">{{$cr->first()->fylabel}}</th>
                                                                        @endforeach
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($reportLabel->where('type','cr')->lists('label','id') as $rid=>$label)
                                                                        <tr>
                                                                            <td>{{$label}}</td>
                                                                            @foreach($report['consolidateRevenue']['quarter'] as $cr)
                                                                                <?php $flag = 0;?>
                                                                                <td class="text-right">
                                                                                    @foreach($cr as $sheet)
                                                                                        @if($sheet->label_id == $rid)
                                                                                            {{$sheet->value}}
                                                                                            <?php $flag=1 ?>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    @if($flag==0)
                                                                                        {{'-'}}
                                                                                    @endif
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div role="tabpanel" class="tab-pane" id="crannual">
                                                            <table class="table datatable table-condensed table-hover table-striped with-border">
                                                                <thead>
                                                                    <tr>
                                                                        <th>In Thousands (except for per share items)</th>
                                                                        @foreach($report['consolidateRevenue']['annual'] as $key=>$cr)
                                                                            <th class="text-right" style="width:25%;">{{$cr->first()->fylabel}}</th>
                                                                        @endforeach
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($reportLabel->where('type','cr')->lists('label','id') as $rid=>$label)
                                                                        <tr>
                                                                            <td>{{$label}}</td>
                                                                            @foreach($report['consolidateRevenue']['annual'] as $cr)
                                                                                <?php $flag = 0;?>
                                                                                <td class="text-right">
                                                                                    @foreach($is as $sheet)
                                                                                        @if($sheet->label_id == $rid)
                                                                                            {{$sheet->value}}
                                                                                            <?php $flag=1 ?>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    @if($flag==0)
                                                                                        {{'-'}}
                                                                                    @endif
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div role="tabpanel" class="tab-pane" id="published-report">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label>Fiscal Year</label>
                                        {!! Form::select('fiscal_year_id',$publishedReports->pluck('financialHighlight.fiscalYear.label', 'financialHighlight.fiscalYear.id'), null, ['class' => 'form-control fy_id search_pub'] ) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Duration</label>
                                            <?php
                                                $subType = $publishedReports->pluck('subType.label', 'subType.id');
                                                $subType[""] = 'Any';
                                            ?>
                                            {!! Form::select('sub_type_id', $subType, null, ['class' => 'form-control subt_id search_pub'] ) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="publishedDatatable" class="table datatable table-condensed table-striped table-responsive with-border display no-wrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Fiscal Year</th>
                                                    <th>Duration</th>
                                                    <th>Title</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div role="tabpanel" class="tab-pane" id="floorsheet">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row" id="floorsheet-range">
                                    <div class="col-sm-6">
                                        <div class='input-group date datepicker searchdate_floor fromdatepicker'>
                                            <input type='text' class="form-control" value="" id="fromdate" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class='input-group date datepicker searchdate_floor todatepicker'>
                                            <input type='text' class="form-control" value="" id="todate" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="floorsheetDatatable" class="table datatable table-condensed table-striped table-responsive with-border display no-wrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th class="hidden-xs hidden-sm">Buyer Broker</th>
                                                    <th class="hidden-xs hidden-sm">Seller Broker</th>
                                                    <th>Quantity</th>
                                                    <th>Rate</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="closeprice">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row" id="closeprice-range">
                                    <div class="col-sm-6">
                                        <div class='input-group date datepicker searchdate_close closefromdatepicker'>
                                            <input type='text' class="form-control" id="fromdate_close" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class='input-group date datepicker searchdate_close closetodatepicker'>
                                            <input type='text' class="form-control" id="todate_close" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="closepriceDatatable" class="table datatable table-condensed table-striped table-responsive with-border display no-wrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th class="hidden-xs hidden-sm">Transaction Count</th>
                                                    <th class="hidden-xs hidden-sm">Open</th>
                                                    <th class="hidden-xs hidden-sm">High</th>
                                                    <th class="hidden-xs hidden-sm">Low</th>
                                                    <th>Close</th>
                                                    <th>Volume</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!$company->bod->isEmpty())
                    <div role="tabpanel" class="tab-pane" id="bods">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                @foreach($company->latestBods() as $type=>$bods)
                                    <?php $cat = $type==1 ? 'Management':'Board of Directors' ?>
                                    <div class="col-sm-12 bod">
                                        <table class="table table-condensed table-hover no-margin">
                                            <thead>
                                                <tr>
                                                    <th>{{$cat}}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bods as $bod)
                                                <tr style="border-bottom:1px #eee solid;">
                                                    <td class="fh-value">
                                                        <a 
                                                            href="#" 
                                                            class="show-details" 
                                                            data-name="{{$bod->name}}" 
                                                            data-fiscal-year="{{$bod->label}}"
                                                            data-name="{{$bod->name}}" 
                                                            data-photo="{{$bod->photo != ''? url('/').'/bod_photo/'.$bod->photo:'http://placehold.it/300x300?text=X'}}" 
                                                            data-profile="{{$bod->profile}}"
                                                            data-cat="{{$company->quote.' '.$cat}}"
                                                        >
                                                            {{$bod->name}}
                                                        </a>
                                                    </td>
                                                    <td class="fh-label text-right" style="vertical-align:middle;">
                                                        {{$bod->bodlabel}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div role="tabpanel" class="tab-pane" id="competitor">
                        @if(!is_null($competitor))
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row" style="padding: 0 15px;">
                                        <table class="table datatable competitor table-condensed table-striped table-responsive with-border" width="100%">
                                            <thead>
                                                <tr>
                                                    <td>SN</td>
                                                    <td class="hidden-sm hidden-xs">Company</td>
                                                    <td class="hidden-lg">Quote</td>
                                                    <td>Traded Date</td>
                                                    <td>Last Price</td>
                                                    <td class="hidden-sm hidden-xs">Listed Share</td>
                                                    <td>Mkt Cap (Mil)</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($competitor as $key=>$com)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td class="hidden-sm hidden-xs">
                                                            <a href="{{route('quote',$com->quote)}}" target="_blank" class="link">{{$com->name}}</a>
                                                        </td>
                                                        <td class="hidden-lg">
                                                            <a href="{{route('quote',$com->quote)}}" target="_blank" class="link">{{$com->quote}}</a>
                                                        </td>
                                                        <td>{{date_create($com->latestTradedPrice->date)->format('M d, Y')}}</td>
                                                        <td>{{$com->latestTradedPrice->value}}</td>
                                                        <td class="hidden-sm hidden-xs">{{$com->listed_shares==0 || $com->listed_shares==null ? '-' : $com->listed_shares}}</td>
														<?php $mktcap = ($com->listed_shares * $com->latestTradedPrice->value)/1000000; ?>
                                                        <td>{{$com->listed_shares==0?'-':number_format($mktcap,2,'.',',')}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="panel panel-default no-margin">
                                <div class="panel-body">
                                    <div class="well well-sm no-margin">
                                        <center>Competitors unavailable.</center>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#review" aria-controls="review" role="tab" data-toggle="tab"><h3 class="no-margin">Review</h3></a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="review">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 no-padding">
                                    <div class="review-container"></div>
                                </div>
                                <div class="col-md-6">
                                    <div id="reviewChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="memberDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="memberHead"></h4>
            </div>
            <div class="modal-body" id="memberCont">
            ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('endscript')
	<script type="text/javascript">
		var getTodaysPriceDayURL = '{{route("api-get-todays-price-day")}}';
        var getTodaysPriceOHLCURL = '{{route("api-get-todays-price-ohlc")}}';
		var fullOHLCURL = '{{route("technical-analysis-ohlc", $company->quote)}}';
		var company_id = "{{$company->id}}";
        var currentUser = "{{Auth::check()?Auth::id():''}}";
		var fromDate = "{{Carbon\Carbon::parse($lastDate)->startOfMonth()->format('Y-m-d')}}";
		var lastDate = "{{$lastDate}}";
		var quote = "{{strtoupper($company->quote)}}";
		var getCompanyTransURL = '{{route("api-get-company-transactions")}}';
        var reviewURL = '{{route("front.review")}}';
        var voteURL = '{{route("front.review.vote")}}';
        var getReviewsURL = '{{route("front.review.show")}}';
        var getReviewsChartURL = '{{route("front.review.chart")}}';
        var floorsheetURL = "{{route('api-get-floorsheet')}}";
        var closepriceURL = "{{route('api-get-todays-price-day')}}";
        var watchlistURL = '{{route("front.watchlist")}}';
        var bonusDividendURL = '{{route("bonus.dividend")}}';
        var publishedReportURL = '{{route("published.report")}}';

        var floorsheetDatatable, closepriceDatatable, bonusDividendDatatable, publishedDatatable;
	</script>
    <script href="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/highstock.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/modules/exporting.js" type="text/javascript"></script>
    {!! HTML::script('vendors/highstock/js/highstock.darkunica.js') !!}
	{!! HTML::script('vendors/notify/notify.min.js') !!}
    {!! HTML::script('vendors/tabdrop/js/bootstrap-tabdrop.js') !!}
    {!! HTML::script('assets/nsm/front/js/quote.js') !!}
    <script type="text/javascript">
        function loadMktCap(lastClose){
            var listed = $('#mktcap').data('listed-shares');
            $('#mktcap').text(addCommas((parseFloat(lastClose)*parseFloat(listed)).toFixed(2)));
        }
    </script>
@endsection
@section('content')