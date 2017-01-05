@extends('admin.master')

@section('title')
    Announcement
@endsection

@section('specificheader')
    <style>
        .source{
            font-style: italic;
            font-size: 11px;
            line-height: 15px;
            color: #666;
            margin-bottom: 24px;
            margin-top: -12px;
            display: block;
            width: 100%;
            text-align: right;
            padding-top: 15px;
        }
    </style>
@endsection

@section('content')
    <?php
        $anonType = $announcement->type->label;
        $anonSubType =  (is_null($announcement->subtype) == false) ? ': '.$announcement->subtype->label : '';
    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bullhorn fa-fw"></i> <span class="badge badge-2x">{{$announcement->type->label}} / {{is_null($announcement->subtype) ? 'NA' : $announcement->subtype->label}}</span> <small>{{$announcement->title}}</small></h3>
            <div class="box-tools pull-right">
                <a href="{{route('admin.announcement.edit',$announcement->id)}}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</a>
                <a class="btn btn-info btn-flat btn-xs" href="{{route('admin.announcement.create')}}">Add New</a>
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="col-lg-7" style="text-align: justify">
                <div class="col-lg-12">
                    <p>{!! $announcement->details !!}</p>
                </div>
                @if(!is_null($announcement->agm))
                    <div class="col-lg-12">
                        <table class="table table-bordered table-condensed table-hover">
                            <thead>
                            <tr>
                                <th colspan="2">AGM</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Count</th>
                                <td>{{is_null($announcement->agm->count) ? 'NA' : $announcement->agm->count}}</td>
                            </tr>
                            <tr>
                                <th>Venue</th>
                                <td>{{is_null($announcement->agm->venue) ? 'NA' : $announcement->agm->venue}}</td>
                            </tr>
                            <tr>
                                <th>Bonus</th>
                                <td>{{is_null($announcement->agm->bonus) ? 'NA' : $announcement->agm->bonus}}</td>
                            </tr>
                            <tr>
                                <th>Dividend</th>
                                <td>{{is_null($announcement->agm->dividend) ? 'NA' : $announcement->agm->dividend}}</td>
                            </tr>
                            <tr>
                                <th>Meeting Time</th>
                                <td>{{is_null($announcement->agm->time) ? 'NA' : $announcement->agm->time}}</td>
                            </tr>
                            <tr>
                                <th>Book Closer From</th>
                                <td>{{is_null($announcement->agm->book_closer_from) ? 'NA' : date("F j, Y ", strtotime($announcement->agm->book_closer_from))}}</td>
                            </tr>
                            <tr>
                                <th>Book Closer To</th>
                                <td>{{is_null($announcement->agm->book_closer_to) ? 'NA' : date("F j, Y ", strtotime($announcement->agm->book_closer_to))}}</td>
                            </tr>
                            <tr>
                                <th>AGM Date</th>
                                <td>{{is_null($announcement->agm->agm_date) ? 'NA' : date("F j, Y ", strtotime($announcement->agm->agm_date))}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @elseif(!is_null($announcement->issue))
                    <div class="col-lg-12">
                        <table class="table table-condensed table-bordered table-hover">
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
                                <td>{{is_null($announcement->issue->issue_date) ? 'NA' : date("F j, Y ", strtotime($announcement->issue->issue_date))}}</td>
                            </tr>
                            <tr>
                                <th>Close Date</th>
                                <td>{{is_null($announcement->issue->close_date) ? 'NA' : date("F j, Y ", strtotime($announcement->issue->close_date))}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @elseif(!is_null($announcement->bonusDividend))
                    <div class="col-lg-12">
                        <table class="table table-condensed table-bordered table-hover">
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
                                <td>{{is_null($announcement->bonusDividend->bonus_share) ? 'NA' : $announcement->bonusDividend->bonus_share}}</td>
                            </tr>
                            <tr>
                                <th>Cash Dividend</th>
                                <td>{{is_null($announcement->bonusDividend->cash_dividend) ? 'NA' : $announcement->bonusDividend->cash_dividend }}</td>
                            </tr>
                            <tr>
                                <th>Distribution Date</th>
                                <td>{{is_null($announcement->bonusDividend->distribution_date) ? 'NA' : date("F j, Y ", strtotime($announcement->bonusDividend->distribution_date))}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @elseif(!is_null($announcement->bodApproved))
                    <div class="col-lg-12">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                            <tr>
                                <th colspan="2">BOD Approved</th>
                            </tr>
                            </thead>
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
                                <td>{{is_null($announcement->bodApproved->bonus_share) ? 'NA' : $announcement->bodApproved->bonus_share}}</td>
                            </tr>
                            <tr>
                                <th>Cash Dividend</th>
                                <td>{{is_null($announcement->bodApproved->cash_dividend) ? 'NA' : $announcement->bodApproved->cash_dividend }}</td>
                            </tr>
                            <tr>
                                <th>Distribution Date</th>
                                <td>{{is_null($announcement->bodApproved->distribution_date) ? 'NA' : date("F j, Y ", strtotime($announcement->bodApproved->distribution_date))}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @elseif(!is_null($announcement->bondDebenture))
                    <div class="col-lg-12">
                        <table class="table table-bordered table-condensed table-hover">
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
                                <td>{{is_null($announcement->bondDebenture->face_value) ? 'NA' : $announcement->bondDebenture->face_value}}</td>
                            </tr>
                            <tr>
                                <th>Quantity (Kitta)</th>
                                <td>{{is_null($announcement->bondDebenture->kitta) ? 'NA' : $announcement->bondDebenture->kitta }}</td>
                            </tr>
                            <tr>
                                <th>Maturity Period</th>
                                <td>{{is_null($announcement->bondDebenture->maturity_period) ? 'NA' : $announcement->bondDebenture->maturity_period}}</td>
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
                        <table class="table table-bordered table-condensed table-hover">
                            <thead>
                            <tr>
                                <th colspan="2">Treasury Bill</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Serial Number</th>
                                <td>{{is_null($treasuryBill->serial_number) ? 'NA' : $treasuryBill->serial_number}}</td>

                            </tr>
                            <tr>
                                <th>Highest Discount Rate</th>
                                <td>{{is_null($treasuryBill->highest_discount_rate) ? 'NA' : $treasuryBill->highest_discount_rate}}</td>
                            </tr>
                            <tr>
                                <th>Lowest Discount Rate</th>
                                <td>{{is_null($treasuryBill->lowest_discount_rate) ? 'NA' : $treasuryBill->lowest_discount_rate }}</td>
                            </tr>
                            <tr>
                                <th>Bill Days</th>
                                <td>{{is_null($treasuryBill->bill_days) ? 'NA' : $treasuryBill->bill_days}}</td>
                            </tr>
                            <tr>
                                <th>Issue Open Date</th>
                                <td>{{is_null($treasuryBill->issue_open_date) ? 'NA' : date("F j, Y ", strtotime($treasuryBill->issue_open_date))}}</td>
                            </tr>
                            <tr>
                                <th>Issue Close Date</th>
                                <td>{{is_null($treasuryBill->issue_close_date) ? 'NA' : date("F j, Y ", strtotime($treasuryBill->issue_close_date))}}</td>
                            </tr>
                            <tr>
                                <th>Weighted Average Rate</th>
                                <td>{{is_null($treasuryBill->weighted_average_rate) ? 'NA' : $treasuryBill->weighted_average_rate}}</td>
                            </tr>
                            <tr>
                                <th>SLR Rate</th>
                                <td>{{is_null($treasuryBill->slr_rate) ? 'NA' : $treasuryBill->slr_rate}}</td>
                            </tr>
                            <tr>
                                <th>Issue Amount</th>
                                <td>{{is_null($treasuryBill->issue_amount) ? 'NA' : $treasuryBill->issue_amount}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @elseif(!is_null($announcement->financialHighlight))
                    <?php $financialHighlight = $announcement->financialHighlight; ?>
                    <div class="col-lg-12">
                        <table class="table table-bordered table-condensed table-hover">
                            <thead>
                            <tr>
                                <th colspan="2">Financial Highlight</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Fiscal Year</th>
                                <td>{{is_null($financialHighlight->fiscalYear) ? 'NA' : $financialHighlight->fiscalYear->label}}</td>
                            </tr>
                            <tr>
                                <th>Paid up Capital</th>
                                <td>{{is_null($financialHighlight->paid_up_capital) ? 'NA' : $financialHighlight->paid_up_capital}}</td>
                            </tr>
                            <tr>
                                <th>Reserve and Surplus</th>
                                <td>{{is_null($financialHighlight->reserve_and_surplus) ? 'NA' : $financialHighlight->reserve_and_surplus}}</td>
                            </tr>
                            <tr>
                                <th>Operating Profit</th>
                                <td>{{is_null($financialHighlight->operating_profit) ? 'NA' : $financialHighlight->operating_profit }}</td>
                            </tr>
                            <tr>
                                <th>Net Profit</th>
                                <td>{{is_null($financialHighlight->net_profit) ? 'NA' : $financialHighlight->net_profit }}</td>
                            </tr>
                            <tr>
                                <th>Earning Per Share</th>
                                <td>{{is_null($financialHighlight->earning_per_share) ? 'NA' : $financialHighlight->earning_per_share }}</td>
                            </tr>
                            <tr>
                                <th>Book Value Per Share</th>
                                <td>{{is_null($financialHighlight->book_value_per_share) ? 'NA' : $financialHighlight->book_value_per_share}}</td>
                            </tr>
                            <tr>
                                <th>Price Earning Ratio</th>
                                <td>{{is_null($financialHighlight->price_earning_ratio) ? 'NA' : $financialHighlight->price_earning_ratio }}</td>
                            </tr>
                            <tr>
                                <th>Liquidity Ratio</th>
                                <td>{{is_null($financialHighlight->liquidity_ratio) ? 'NA' : $financialHighlight->liquidity_ratio }}</td>
                            </tr>
                            <tr>
                                <th>Net Worth Per Share</th>
                                <td>{{is_null($financialHighlight->net_worth_per_share) ? 'NA' : $financialHighlight->net_worth_per_share}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="col-lg-5">
                @if(is_null($announcement->featured_image) || $announcement->featured_image == '')
                    <img src="http://placehold.it/350x150" alt="{{$announcement->title}}" class="img-thumbnail">
                    <div class="source">
                        Source: <span class="text-info">{{$announcement->source}}</span>
                    </div>
                @else
                    <img src="{{$announcement->image()}}" alt="{{$announcement->title}}" class="img-thumbnail">
                    <div class="source">
                        Source: <span class="text-info">{{$announcement->source}}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection