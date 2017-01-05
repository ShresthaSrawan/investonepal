@extends('front.main')

@section('title')
    {{$announcement->title}}
@endsection

@section('specificheader')
<meta property="og:url" content="{{$announcement->getLink('front.announcement.show',$announcement->type->label)}}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{$announcement->title}}" />
<meta property="og:description" content="{{strip_tags($announcement->details)}}" />
<meta property="og:image" content="{{$announcement->imageThumbnail(500,500)}}" />
<meta property="og:image:width" content="500" />
<meta property="og:image:height" content="500" />
    <style>
        .table{background: #fff;}
		.page-title{display:none;}
		.indi-item .item-body{font-size:inherit;}
		.indi-item .item-date{padding: 12px 24px 0 0px;}
    </style>
@endsection

@section('content')
    <?php
        $anonType = $announcement->type->label;
		if(is_null($announcement->subtype)):
			$anonSubType = '';
		else:
			$anonSubType = '/ '.$announcement->subtype->label;
		endif;
    ?>
    <section class="announcement-show col-md-9 col-xs-12">
        <div class="box indi-item">
            <header>
                <a href="{{route('front.announcement.category',str_slug($announcement->type->label))}}" class="link category-link">{{ucwords($announcement->type->label)}} {{ucwords($anonSubType)}}</a>
                <h1 class="headline">{{$announcement->title}}</h1>
            </header>
            <div class="item-social-media">
                <a href="http://www.facebook.com/sharer.php?u={{urlencode($announcement->getLink('front.announcement.show',$announcement->type->label))}}" target="_blank" class="js-social-share facebook">
                    <i class="fa fa-facebook-square fa-2x"></i>
                </a> 
                <a href="https://twitter.com/intent/tweet?text={{urlencode($announcement->title)}}&url={{urlencode($announcement->getLink('front.announcement.show',$announcement->type->label))}}&via=investonepal" target="_blank" class="js-social-share twitter">
                    <i class="fa fa-twitter-square fa-2x"></i>
                </a>
				<span class="item-date">{{date_create($announcement->pub_date)->format('F d, Y')}}. {{$announcement->user->userInfo->first_name}} {{$announcement->user->userInfo->last_name}}</span>
            </div>
            <div class="item-body">
				<div class="row">
                {!!$announcement->details!!}
				<span class="pull-right" style="padding-right:20px;"><small><i>Rs in '000'</i></small></span>
					@if(!is_null($announcement->agm))
						<div class="col-lg-12">
							<table class="table datatable table-striped table-condensed table-hover with-border">
								<tbody>
								<tr>
									<th>AGM Date</th>
									<td>{{is_null($announcement->agm->agm_date) ? 'NA' : date("F j, Y ", strtotime($announcement->agm->agm_date))}}</td>
								</tr>
								<tr>
									<th>Meeting Time</th>
									<td>{{is_null($announcement->agm->time) || $announcement->agm->time=="00:00:00" ? 'NA' : date_create($announcement->agm->time)->format('h:i A')}}</td>
								</tr>
								<tr>
									<th>Venue</th>
									<td>{{is_null($announcement->agm->venue) ? 'NA' : $announcement->agm->venue}}</td>
								</tr>
								<tr>
									<th>Count</th>
									<td>{{is_null($announcement->agm->count) ? 'NA' : $announcement->agm->count}}</td>
								</tr>
								<tr>
									<th>Bonus</th>
									<td>{{is_null($announcement->agm->bonus) || $announcement->agm->bonus==0 ? 'NA' : $announcement->agm->bonus}}</td>
								</tr>
								<tr>
									<th>Dividend</th>
									<td>{{is_null($announcement->agm->dividend) || $announcement->agm->dividend==0 ? 'NA' : $announcement->agm->dividend}}</td>
								</tr>
								<tr>
									<th>Book Closer From</th>
									<td>{{is_null($announcement->agm->book_closer_from) || $announcement->agm->book_closer_from=="0000-00-00" ? 'NA' : date("F j, Y ", strtotime($announcement->agm->book_closer_from))}}</td>
								</tr>
								<tr>
									<th>Book Closer To</th>
									<td>{{is_null($announcement->agm->book_closer_to) || $announcement->agm->book_closer_to=="0000-00-00" ? 'NA' : date("F j, Y ", strtotime($announcement->agm->book_closer_to))}}</td>
								</tr>
								<tr>
									<th>Agenda</th>
									<td>{{is_null($announcement->agm->agenda) || $announcement->agm->agenda=="" ? 'NA' : $announcement->agm->agenda}}</td>
								</tr>
								</tbody>
							</table>
						</div>
						@elseif(!is_null($announcement->issue))
							<div class="col-lg-12">
								<table class="table datatable table-striped table-condensed table-hover with-border">
									<thead>
									<tr>
										<th colspan="2">Issue</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<th>Financial Year</th>
										<td>{{is_null($announcement->issue->fiscalYear->label) ? 'NA' : $announcement->issue->fiscalYear->label}}</td>
									</tr>
									<tr>
										<th>Issue Type</th>
										<td>{{is_null($announcement->subtype) ? 'NA' : $announcement->subtype->label}}</td>
									</tr>
									<tr>
										<th>Face Value</th>
										<td>{{is_null($announcement->issue->face_value) ? 'NA' : $announcement->issue->face_value}}</td>
									</tr>
									<?php $auction = $announcement->issue->auction; ?>
									@if(!is_null($auction))
										@if($auction->ordinary != 0)
											<tr>
												<th>Ordinary</th>
												<td>{{$auction->ordinary}}</td>
											</tr>
										@endif
										@if($auction->promoter != 0)
											<tr>
												<th>Promoter</th>
												<td>{{$auction->promoter}}</td>
											</tr>
										@endif
									@else
										<tr>
											<th>Kitta</th>
											<td>{{is_null($announcement->issue->kitta) ? 'NA' : $announcement->issue->kitta}}</td>
										</tr>
									@endif

									@if($announcement->subtype->label == 'right')
										<tr>
											<th>Ratio</th>
											<td>{{is_null($announcement->issue->ratio) ? 'NA' : $announcement->issue->ratio}}</td>
										</tr>
									@endif
									<tr>
										<th>Issue Date</th>
										<td>{{is_null($announcement->issue->issue_date) || $announcement->issue->issue_date=="0000-00-00" ? 'NA' : date("F j, Y ", strtotime($announcement->issue->issue_date))}}</td>
									</tr>
									<tr>
										<th>Close Date</th>
										<td>{{is_null($announcement->issue->close_date) || $announcement->issue->close_date=="0000-00-00" ? 'NA' : date("F j, Y ", strtotime($announcement->issue->close_date))}}</td>
									</tr>
									</tbody>
								</table>
							</div>
						@elseif(!is_null($announcement->bonusDividend))
							<div class="col-lg-12">
								<table class="table datatable table-striped table-condensed table-hover with-border">
									<thead>
									<tr>
										<th colspan="2">Bonus Dividend and Distribution</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<th>Financial Year</th>
										<?php  $fisYears = $announcement->bonusDividend->fiscalYear; ?>
										@if(!empty($fisYears->toArray()))
											<td>
												@foreach($fisYears as $fy)
													{{$fy->label}}<br>
												@endforeach
											</td>
										@endif

									</tr>
									<tr>
										<th>Bonus Share</th>
										<td>{{is_null($announcement->bonusDividend->bonus_share) || $announcement->bonusDividend->bonus_share==0 ? 'NA' : $announcement->bonusDividend->bonus_share}}</td>
									</tr>
									<tr>
										<th>Cash Dividend</th>
										<td>{{is_null($announcement->bonusDividend->cash_dividend) || $announcement->bonusDividend->cash_dividend==0  ? 'NA' : $announcement->bonusDividend->cash_dividend }}</td>
									</tr>
									<tr>
										<th>Distribution Date</th>
										<td>{{is_null($announcement->bonusDividend->distribution_date) || $announcement->bonusDividend->distribution_date=="0000-00-00"  ? 'NA' : date("F j, Y ", strtotime($announcement->bonusDividend->distribution_date))}}</td>
									</tr>
									</tbody>
								</table>
							</div>
						@elseif(!is_null($announcement->bondDebenture))
							<div class="col-lg-12">
								<table class="table datatable table-striped table-condensed table-hover with-border">
									<thead>
									<tr>
										<th colspan="2">Bond and Debenture</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<th>Title of Securities</th>
										<td>{{is_null($announcement->bondDebenture->title_of_securities) ? 'NA' : $announcement->bondDebenture->title_of_securities}}</td>

									</tr>
									<tr>
										<th>Face Value</th>
										<td>{{is_null($announcement->bondDebenture->face_value) || $announcement->bondDebenture->face_value==0 ? 'NA' : $announcement->bondDebenture->face_value}}</td>
									</tr>
									<tr>
										<th>Quantity (Kitta)</th>
										<td>{{is_null($announcement->bondDebenture->kitta) || $announcement->bondDebenture->kitta==0 ? 'NA' : $announcement->bondDebenture->kitta }}</td>
									</tr>
									<tr>
										<th>Maturity Period</th>
										<td>{{is_null($announcement->bondDebenture->maturity_period) || $announcement->bondDebenture->maturity_period=0 ? 'NA' : $announcement->bondDebenture->maturity_period}}</td>
									</tr>
									<tr>
										<th>Issue Open Date</th>
										<td>{{is_null($announcement->bondDebenture->issue_open_date) ? 'NA' : date("F j, Y ", strtotime($announcement->bondDebenture->issue_open_date))}}</td>
									</tr>
									<tr>
										<th>Issue Close Date</th>
										<td>{{is_null($announcement->bondDebenture->issue_close_date) ? 'NA' : date("F j, Y ", strtotime($announcement->bondDebenture->issue_close_date))}}</td>
									</tr>
									<tr>
										<th>Coupon Interest Rate</th>
										<td>{{is_null($announcement->bondDebenture->coupon_interest_rate) ? 'NA' : $announcement->bondDebenture->coupon_interest_rate}}</td>
									</tr>
									<tr>
										<th>Interest Payment Method</th>
										<td>{{is_null($announcement->bondDebenture->interest_payment_method) ? 'NA' : $announcement->bondDebenture->interest_payment_method}}</td>
									</tr>
									</tbody>
								</table>
							</div>
						@elseif(!is_null($announcement->treasuryBill))
							<?php $treasuryBill = $announcement->treasuryBill; ?>
							<div class="col-lg-12">
								<table class="table datatable table-striped table-condensed table-hover with-border">
									<tbody>
									<tr>
										<th>Serial Number</th>
										<td>{{is_null($treasuryBill->serial_number) ? 'NA' : $treasuryBill->serial_number}}</td>

									</tr>
									<tr>
										<th>Highest Discount Rate</th>
										<td>{{is_null($treasuryBill->highest_discount_rate) || $treasuryBill->highest_discount_rate==0 ? 'NA' : $treasuryBill->highest_discount_rate}}</td>
									</tr>
									<tr>
										<th>Lowest Discount Rate</th>
										<td>{{is_null($treasuryBill->lowest_discount_rate) || $treasuryBill->lowest_discount_rate==0 ? 'NA' : $treasuryBill->lowest_discount_rate }}</td>
									</tr>
									<tr>
										<th>Bill Days</th>
										<td>{{is_null($treasuryBill->bill_days) ? 'NA' : $treasuryBill->bill_days}}</td>
									</tr>
									<tr>
										<th>Issue Open Date</th>
										<td>{{is_null($treasuryBill->issue_open_date) || $treasuryBill->issue_open_date=="0000-00-00" ? 'NA' : date("F j, Y ", strtotime($treasuryBill->issue_open_date))}}</td>
									</tr>
									<tr>
										<th>Issue Close Date</th>
										<td>{{is_null($treasuryBill->issue_close_date) || $treasuryBill->issue_close_date=="0000-00-00" ? 'NA' : date("F j, Y ", strtotime($treasuryBill->issue_close_date))}}</td>
									</tr>
									<tr>
										<th>Weighted Average Rate</th>
										<td>{{is_null($treasuryBill->weighted_average_rate) || $treasuryBill->weighted_average_rate==0 ? 'NA' : $treasuryBill->weighted_average_rate}}</td>
									</tr>
									<tr>
										<th>SLR Rate</th>
										<td>{{is_null($treasuryBill->slr_rate) || $treasuryBill->slr_rate==0 ? 'NA' : $treasuryBill->slr_rate}}</td>
									</tr>
									<tr>
										<th>Issue Amount</th>
										<td>{{is_null($treasuryBill->issue_amount) || $treasuryBill->issue_amount==0 ? 'NA' : $treasuryBill->issue_amount}}</td>
									</tr>
									</tbody>
								</table>
							</div>
						@elseif(!is_null($announcement->financialHighlight))
							<?php $financialHighlight = $announcement->financialHighlight; ?>
							<div class="col-lg-12">
								<table class="table datatable table-striped table-condensed table-hover with-border">
									<thead>
									</thead>
									<tbody>
									<tr>
										<th>Fiscal Year</th>
										<td>{{is_null($financialHighlight->fiscalYear) ? 'NA' : $financialHighlight->fiscalYear->label}}</td>
									</tr>
									<tr>
										<th>Paid up Capital</th>
										<td>{{is_null($financialHighlight->paid_up_capital) || $financialHighlight->paid_up_capital==0 ? 'NA' : $financialHighlight->paid_up_capital}}</td>
									</tr>
									<tr>
										<th>Reserve and Surplus</th>
										<td>{{is_null($financialHighlight->reserve_and_surplus) || $financialHighlight->reserve_and_surplus==0 ? 'NA' : $financialHighlight->reserve_and_surplus}}</td>
									</tr>
									<tr>
										<th>Operating Profit</th>
										<td>{{is_null($financialHighlight->operating_profit) || $financialHighlight->operating_profit==0 ? 'NA' : $financialHighlight->operating_profit }}</td>
									</tr>
									<tr>
										<th>Net Profit</th>
										<td>{{is_null($financialHighlight->net_profit) || $financialHighlight->net_profit==0 ? 'NA' : $financialHighlight->net_profit }}</td>
									</tr>
									<tr>
										<th>Earning Per Share</th>
										<td>{{is_null($financialHighlight->earning_per_share) ? 'NA' : $financialHighlight->earning_per_share }}</td>
									</tr>
									<tr>
										<th>Net Assets Per Share</th>
										<td>{{is_null($financialHighlight->book_value_per_share) || $financialHighlight->book_value_per_share==0 ? 'NA' : $financialHighlight->book_value_per_share}}</td>
									</tr>
									<tr>
										<th>Price Earning Ratio</th>
										<td>{{is_null($financialHighlight->price_earning_ratio) || $financialHighlight->price_earning_ratio==0 ? 'NA' : $financialHighlight->price_earning_ratio }}</td>
									</tr>
									<tr>
										<th>Liquidity Ratio</th>
										<td>{{is_null($financialHighlight->liquidity_ratio) ? 'NA' : $financialHighlight->liquidity_ratio }}</td>
									</tr>
									<tr>
										<th>Net Worth Per Share</th>
										<td>{{is_null($financialHighlight->net_worth_per_share) || $financialHighlight->net_worth_per_share==0 ? 'NA' : $financialHighlight->net_worth_per_share}}</td>
									</tr>
									</tbody>
								</table>
							</div>
						@elseif(!is_null($announcement->bodApproved))
							<div class="col-lg-12">
								<table class="table datatable table-striped table-condensed table-hover with-border">
									<tbody>
									<tr>
										<th>Financial Year</th>
										<?php  $fisYears = $announcement->bodApproved->fiscalYear; ?>
										@if(!empty($fisYears->toArray()))
											<td>
												@foreach($fisYears as $fy)
													{{$fy->label}}<br>
												@endforeach
											</td>
										@endif

									</tr>
									<tr>
										<th>Bonus Share</th>
										<td>{{is_null($announcement->bodApproved->bonus_share) || $announcement->bodApproved->bonus_share==0 ? 'NA' : $announcement->bodApproved->bonus_share}}</td>
									</tr>
									<tr>
										<th>Cash Dividend</th>
										<td>{{is_null($announcement->bodApproved->cash_dividend) || $announcement->bodApproved->cash_dividend==0 ? 'NA' : $announcement->bodApproved->cash_dividend }}</td>
									</tr>
									<tr>
										<th>BOD Approved Date</th>
										<td>{{is_null($announcement->bodApproved->distribution_date) || $announcement->bodApproved->distribution_date=="0000-00-00" ? 'NA' : date("F j, Y ", strtotime($announcement->bodApproved->distribution_date))}}</td>
									</tr>
									</tbody>
								</table>
							</div>
					@endif
				</div>
            </div>
            @if(!$announcement->bodApproved)
				<div class="row">
					<div class="col-xs-12">
						<a href="{{$announcement->image()}}" class="link" target="_blank">
							<img src="{{$announcement->image()}}" alt="{{$announcement->title}}" class="img-responsive">
						</a>
						<div class="source">
							Source: <span class="text-info">{{$announcement->source}}</span>
						</div>
					</div>
				</div>
            @endif
            <div class="item-comments">
                <h3>Have Your Say</h3>
                <div class="fb-comments" data-href="{{\Illuminate\Support\Facades\Request::url()}}" data-numposts="5" width="100%"></div>
            </div>
            <span class="clearfix"></span>
        </div>
    </section>
    @if(!$announcementList->isEmpty())
    <aside class="col-md-3 col-xs-12">
        <div class="panel panel-default no-padding">
            <div class="panel-heading">
                <strong>Similar Announcement</strong>
            </div>
            <div class="panel-body no-padding">
                <ul class="unlist no-padding">
                    <li>
                        <h4 class="aside-heading"><a href="{{route('front.announcement.category',str_slug($announcement->type->label))}}" class="link">{{ucwords($announcement->type->label)}}</a></h4>
                        <ul class="news-media-list unlist no-padding">
                            @foreach($announcementList as $i=>$a)
                                <li class="aside-item">
                                    <div class="media">
                                        <div class="media-left">
                                            <img class="media-object announcement-image" src="{{$a->imageThumbnail(75,75)}}">
                                        </div>
                                        <div class="media-body">
                                            <h5 class="media-heading">
                                                <a href="{{$a->getLink('front.announcement.show',$a->type->label)}}" class="link">
                                                    {{mb_strimwidth($a->title,0,65,"...")}} <small>({{date_create($a->pub_date)->format('M-d')}})</small>
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
    @endif
@endsection

@section('endscript')
@endsection