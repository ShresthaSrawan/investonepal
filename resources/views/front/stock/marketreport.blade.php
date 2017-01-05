@extends('front.main')

@section('title')
Stock : Market Report
@endsection

@section('specificheader')
{!! HTML::style('vendors/dataTables/FixedHeader-3.0.0/css/fixedHeader.bootstrap.min.css') !!}
<style type="text/css">
    .primarytab>.tab-pane{
        padding-top: 15px;
    }
    @media (max-width: 768px)
    {
        #contw{
            margin-top: 10px;
        }
    }
    .datatable{
        width: 100%;
    }
    .tab-content{
        background: #fff;
        padding: 10px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-4">
            <label for="fromdate">From::</label>
            <div class="form-group">
                <div class='input-group date datepicker' id="fromdatepicker">
                    <input type='text' class="form-control searchdate" value="" id="fromdate" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <label for="todate">To::</label>
            <div class="form-group">
                <div class='input-group date datepicker' id="todatepicker">
                    <input type='text' class="form-control searchdate" value="" id="todate" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <label for="sector">Sector::</label>
            {!! Form::select('sector',['0'=>'All']+$sectorList,0,['id'=>'sector','class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="row" id="contw">
    <div class="col-md-12 tabbable">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="mytabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#summary" aria-controls="summary" role="tab" data-toggle="tab" aria-expanded="true">Summary</a></li>
            <li role="presentation">
                <a href="#index" aria-controls="index" role="tab" data-toggle="tab">Index</a>
            </li>
            <li role="presentation"><a href="#report" aria-controls="report" role="tab" data-toggle="tab">Trading
                Report</a></li>
            <li role="presentation"><a href="#sectorwise" aria-controls="sector" role="tab" data-toggle="tab">Sectorwise
                Perf.</a></li>
            <li role="presentation"><a href="#gainer" aria-controls="gainer" role="tab" data-toggle="tab">Gainer</a>
            </li>
            <li role="presentation"><a href="#loser" aria-controls="loser" role="tab" data-toggle="tab">Loser</a>
            </li>
            <li role="presentation"><a href="#active" aria-controls="active" role="tab" data-toggle="tab">Active</a>
            </li>
            <li role="presentation"><a href="#turnover" aria-controls="turnover" role="tab" data-toggle="tab">Turnover</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content primarytab">
            <div role="tabpanel" class="tab-pane active" id="summary">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <table class="table table-hover datatable with-border">
                            <thead>
                                <th>Title</th>
                                <th>Value</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Traded Days</th>
                                    <td class="text-right"><span data-val="nofdays"></span></td>
                                </tr>
                                <tr>
                                    <th>Total Company Traded</th>
                                    <td class="text-right"><span data-val="nofcompany"></span></td>
                                </tr>
                                <tr>
                                    <th>Total Transaction</th>
                                    <td class="text-right"><span data-val="totaltran"></span></td>
                                </tr>
                                <tr>
                                    <th>Total Share Traded</th>
                                    <td class="text-right"><span data-val="totalvol"></span></td>
                                </tr>
                                <tr>
                                    <th>Average Share Traded</th>
                                    <td class="text-right"><span data-val="avgvol"></span></td>
                                </tr>
                                <tr>
                                    <th>Total Amount Traded (Mil)</th>
                                    <td class="text-right"><span data-val="totalamt" class=''></span></td>
                                </tr>
                                <tr>
                                    <th>Average Amount Traded (Mil)</th>
                                    <td class="text-right"><span data-val="avgamt" class=''></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover datatable with-border fh-dt" id="detailed-summary" width="100%">
                            <thead>
                                <th>SN</th>
                                <th>Date</th>
                                <th>Company count</th>
                                <th>Transactions</th>
                                <th>Volume</th>
                                <th>Amount</th>
                                <th>Market Cap. (Mil)</th>
                                <th>Float Market Cap. (Mil)</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="index">
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="#indexsummary" aria-controls="indexsummary"
                      role="tab" data-toggle="tab">Index Summary</a></li>
                    <li role="presentation"><a href="#indexohlc" aria-controls="indexohlc" role="tab"
                         data-toggle="tab">Index OHLC</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active row" id="indexsummary">
                        <table id="indexSummaryDatatable" class="table table-hover datatable with-border table-striped fh-dt">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    @foreach($indexList as $index)
                                    <th>{{ucwords($index)}}</th>
                                    @endforeach
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="indexohlc">
                        <table id="indexOHLCDatatable" class="table with-border table-hover datatable table-condensed table-striped fh-dt">
                            <thead>
                                <tr>
                                    <td>SN</td>
                                    <td>Index</td>
                                    <td>Open</td>
                                    <td>High</td>
                                    <td>Low</td>
                                    <td>Close</td>
                                    <td>Chg.</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="report">
                <table id="reportDatatable" class="table datatable table-condensed table-striped responsive display no-wrap with-border" width="100%">
                    <thead>
                        <tr>
                            <th>Quote</th>
                            <th title="Transaction Count">Tran.</th>
                            <th class="hidden-xs hidden-sm">Open</th>
                            <th class="hidden-xs hidden-sm">High</th>
                            <th class="hidden-xs hidden-sm">Low</th>
                            <th>Close</th>
                            <th title="Traded Shares">Shares</th>
                            <th>Amount</th>
                            <th class="hidden-xs hidden-sm" title="Market Capital">MCap(Mil)</th>
                            <th title="Change">Chg</th>
                            <th class="hidden-xs hidden-sm" title="Percent Change">%Chg</th>
                            <th class="hidden-xs hidden-sm">Average</th>
                            <th class="hidden-xs hidden-sm" title="52 High">52H</th>
                            <th class="hidden-xs hidden-sm" title="52 Low">52L</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="sectorwise">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="sector-chart-container" class="chart-container" style="width:100%; height:400px;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="sectorwiseDatatable" class="table datatable with-border table-condensed table-striped fh-dt">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Sector</th>
                                    <th><abbr title="Market Capital">M.Cap. (Mil)</abbr></th>
                                    <th><abbr titlle="Shared Traded">Shares</abbr></th>
                                    <th><abbr title="Percentage of Total Share">%Share</abbr></th>
                                    <th><abbr title="Amount Traded">AMT(Mil)</abbr></th>
                                    <th><abbr title="Percentage of total Amount">%Amt.</abbr></th>
                                    <th><abbr title="No of Companys">No.</abbr></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="gainer">
                <table id="gainerDatatable" class="table datatable with-border table-condensed table-striped fh-dt">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Quote</th>
                            <th>Name</th>
                            <th>Tran.</th>
                            <th>Open</th>
                            <th>High</th>
                            <th>Low</th>
                            <th>Close</th>
                            <th>Shares</th>
                            <th>AMT(Mil)</th>
                            <th title="Market Capital">MCap(Mil)</th>
                            <th title="Change">Chg</th>
                            <th title="Percent Change">%Chg</th>
                            <th title="Close Average">Close Avg</th>
                            <th title="52 High">52H</th>
                            <th title="52 Low">52L</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="loser">
                <table id="loserDatatable" class="table datatable with-border table-condensed table-striped fh-dt">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Quote</th>
                            <th>Name</th>
                            <th>Tran.</th>
                            <th>Open</th>
                            <th>High</th>
                            <th>Low</th>
                            <th>Close</th>
                            <th>Shares</th>
                            <th>AMT(Mil)</th>
                            <th  title="Market Capital">MCap(Mil)</th>
                            <th>Chg</th>
                            <th title="Percent Change">%Chg</th>
                            <th title="Close Average">Close Avg</th>
                            <th title="52 High">52H</th>
                            <th title="52 Low">52L</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="active">
                <table id="activeDatatable" class="table with-border datatable table-condensed table-striped fh-dt">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Quote</th>
                            <th>Name</th>
                            <th>Tran.</th>
                            <th>Open</th>
                            <th>High</th>
                            <th>Low</th>
                            <th>Close</th>
                            <th>Shares</th>
                            <th>AMT(Mil)</th>
                            <th title="Market Capital">M.Cap. (Mil)</th>
                            <th title="Change">Chg</th>
                            <th title="Percent Change">%Chg</th>
                            <th title="Close Average">Close Avg</th>
                            <th title="52 High">52H</th>
                            <th title="52 Low">52L</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="turnover">
                <table id="turnoverDatatable" class="table with-border datatable table-condensed table-striped fh-dt">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Quote</th>
                            <th>Name</th>
                            <th>Tran.</th>
                            <th>Open</th>
                            <th>High</th>
                            <th>Low</th>
                            <th>Close</th>
                            <th>Shares</th>
                            <th>AMT(Mil)</th>
                            <th title="Market Capital">MCap(Mil)</th>
                            <th title="Change">Chg</th>
                            <th title="Percent Change">%Chg</th>
                            <th title="Close Average">Close Avg</th>
                            <th title="52 High">52H</th>
                            <th title="52 Low">52L</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('endscript')
<script type="text/javascript">
    var todaysPriceURL = "{{route('api-get-todays-price-duration')}}";
    var todaysPriceDurationBySectorURL = "{{route('api-get-todays-price-duration-by-sector')}}";
    var indexOHLCURL = "{{route('api-get-indexes-ohlc')}}";
    var indexSummaryURL = "{{route('api-get-indexes-summary')}}";
    var indexDetailedSummaryURL = "{{route('api-get-detailed-market-summary')}}";
    var marketSummaryURL = "{{route('api-get-market-summary')}}";
    var todaysPriceDurationURL = "{{route('api-get-todays-price-duration')}}";
	var fromDate ="{{ \Carbon\Carbon::parse($lastDate)->subWeek()->format('Y-m-d') }}";
	var toDate ="{{$lastDate}}";
    var table = [], count = 0;
    var indexes = {!! json_encode($indexList) !!} ;

    var indexSummaryCols = [
    {
        data: 'date', searchable: false
    },
    {data: 'date', name: 'date',class:'mydate'},
    @foreach($indexList as $index)
    {data: '{{$index}}', searchable: false,render:function(data){
        if(data===undefined || data==null){
            return " - ";
        }else{
            return addCommas(data);
        }
    }},
    @endforeach
    {data: 'date',render:function(data){
        return " ";
    }},
    ];
    mindate = "{{ \Carbon\Carbon::parse($lastDate)->subWeek()->format('Y-m-d') }}";
    maxdate = "{{$lastDate}}";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/highstock.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/modules/exporting.js" type="text/javascript"></script>
{!! HTML::script('assets/nsm/front/js/marketReport.js') !!}
{!! HTML::script('vendors/tabdrop/js/bootstrap-tabdrop.js') !!}
{!! HTML::script('vendors/dataTables/FixedHeader-3.0.0/js/dataTables.fixedHeader.min.js') !!}
<script type="text/javascript">
    $(function(){
      $('.nav-tabs').tabdrop({text: 'More'});
    })
</script>
@endsection