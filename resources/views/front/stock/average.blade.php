@extends('front.main')

@section('specificheader')
    <style type="text/css">
    .tab-content{
        padding: 15px 0;
    }
	.chosen-container-single .chosen-single abbr{
		top:16px;
	}
    </style>
@endsection

@section('title')
    Stock : Average
@endsection

@section('content')
    <section class="main-content col-md-9">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#duration" aria-controls="duration" role="tab" data-toggle="tab">By Duration</a>
                </li>
                <li role="presentation">
                    <a href="#transaction" aria-controls="transaction" role="tab" data-toggle="tab" id="tranbtn">By Transaction</a>
                </li>
            </ul>
        
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="duration">
                    <div class="row" style="padding-top:10px;">
                        <div class="col-sm-6">
                            <label for="fromdate">From Date:</label>
                            <div class="form-group">
                                <div class='input-group date datepicker' id="fromdatepicker">
                                    <input type='text' class="form-control searchdate" id="fromdate" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="todate">To Date:</label>
                            <div class="form-group">
                                <div class='input-group date datepicker' id="todatepicker">
                                    <input type='text' class="form-control searchdate" id="todate" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-margin">
                        <div class="col-sm-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills" role="tablist">
                                <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a></li>
                                <li role="presentation"><a href="#specific" aria-controls="company" role="tab" data-toggle="tab">Company Specific</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane" id="specific">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="company" class="control-label">Company</label>
                                        </div>
                                        <div class="col-sm-9">
                                            {!! Form::select('company',[''=>'']+$companyList,0,['id'=>'company','data-placeholder'=>"Please select a Company"]) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="company" class="control-label">Average Price</label>
                                        </div>
                                        <div class="col-sm-9 avgprice">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">Traded Days: </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <span class="traded_dur"></span> day(s)
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table datatable with-border table-responsive table-condensed table-hover table-striped" id="companyaverage" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th><abbr title="Last Close Price">Close</abbr></th>
                                                    <th><abbr title="Previous">Prev.</abbr></th>
                                                    <th><attr title="Change">Ch.</attr></th>
                                                    <th><attr title="Percent Change">%</attr></th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane active" id="all">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">Calendar Date: </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <span id="fdate"></span> to <span id="tdate"></span> (<span id="dur"></span> days)
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">Traded Days: </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <span class="traded_dur"></span> day(s)
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table datatable with-border table-responsive table-condensed table-hover table-striped" id="allaverage" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="hidden-lg">Quote</th>
                                                    <th class="hidden-sm hidden-xs">Name</th>
                                                    <th><abbr title="Average Price">Avg.</abbr></th>
                                                    <th><abbr title="Last Closing Price">Close</abbr></th>
                                                    <th>Date</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="transaction">
                    <div class="row" style="padding-top:10px;">
                        <div class="col-sm-6">
                            <label for="fromdate">Max Transactions:</label>
                            <div class="form-group">
                               <input type="number" class="form-control" value="180" id="tranlimit">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="todate">As of Date:</label>
                            <div class="form-group">
                                <div class='input-group date datepicker' id="todatepicker2">
                                    <input type='text' class="form-control searchdate" id="todate2" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table datatable with-border table-responsive table-condensed table-hover table-striped" id="transactionaverage" width="100%">
                                <thead>
                                <tr>
                                    <th>Quote</th>
                                    <th>Company</th>
                                    <th>Average</th>
                                    <th>Count</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('endscript')
<script type="text/javascript">
    var averageTodayPriceListByCompany = "{{route('api-get-average-todays-price-list-by-company')}}";
    var averageTodayPriceByTransaction = "{{route('api-get-average-todays-price-by-transaction')}}";
    var averageTodaysPrice = "{{route('api-get-average-todays-price')}}";
    var companyAverageTodaysPriceByDuration = "{{route('api-get-company-average-todays-price-by-duration')}}";
    var table, table2;
    var mindate = '{{ \Carbon\Carbon::parse($lastDate)->subWeek()->format("Y-m-d") }}';
    var maxdate = '{{$lastDate}}';
    var tradedDaysURL="{{route('api-get-traded-days')}}";
</script>
    <script href="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js" type="text/javascript"></script>
    {!! HTML::script('assets/nsm/front/js/averagePrice.js') !!}
@endsection