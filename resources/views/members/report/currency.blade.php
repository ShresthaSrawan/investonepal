@extends('members.layout.master')

@section('title')Currency Report
@endsection

@section('specificheader')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" data-css="print">
    {!! HTML::style('vendors/animate/animate.css') !!}
    <style>
        .dataTables_scrollHead{
            overflow: visible !important;
        }
        .content{
            overflow: hidden;
        }

    </style>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-line-chart"></i> Currency Report</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-box-tool" href="{{route('member.currency.index')}}"><i class="fa fa-chevron-circle-left"></i> Currency Portfolio</a>
            <button class="btn btn-box-tool" id="print-btn"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
    <div class="box-body">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#buy_report" data-toggle="tab">Buy Report</a></li>
            <li><a href="#sell_report" data-toggle="tab">Sell Report</a></li>
            <li><a href="#summary" data-toggle="tab">Summary Report</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active in" id="buy_report">
                <div class="row" style="padding-top: 10px">
                    {!! Form::open(['route'=>'member.report.buyCurrency','class'=>'form-horizontal col-xs-12','id'=>'currency-buy-report-form']) !!}
                    <div class="col-md-5 col-xs-12 col-md-offset-1">
                        <div class="form-group">
                            <label class="control-label" for="buy_from_date">From</label>
                            <div class="input-group">
                                <input class="form-control" name="from" type="date" id="buy_from_date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="buy_to_date">To</label>
                            <div class="input-group">
                                <input class="form-control" name="to" type="date" id="buy_to_date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success ajax-submit" id="filter-currency-buy-btn"><i class="fa fa-filter"></i> Filter</button>   
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="currency-buy-report-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Buy Date</th>
                                <th>Currency</th>
                                <th>Quantity</th>
                                <th>Buy Rate</th>
                                <th>Investment</th>
                                <th>Market Rate <small>(Sell)</small></th>
                                <th>Market Value</th>
                                <th>Profit/Loss</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><span id="totalBuyInvestment">Total Investment</span></th>
                                <th></th>
                                <th><span id="totalBuyMarketValue">Total Market Value</span></th>
                                <th><span id="totalBuyChange">Total Profit/Loss</span></th>
                            </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane fade" id="sell_report">
                <div class="row" style="padding-top: 10px">
                    {!! Form::open(['route'=>'member.report.sellCurrency','class'=>'form-horizontal col-xs-12','id'=>'currency-sell-report-form']) !!}
                    <div class="col-md-5 col-xs-12 col-md-offset-1">
                        <div class="form-group">
                            <label class="control-label" for="sell_from_date">From</label>
                            <div class="input-group">
                                <input class="form-control" name="from" type="date" id="sell_from_date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="sell_to_date">To</label>
                            <div class="input-group">
                                <input class="form-control" name="to" type="date" id="sell_to_date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success ajax-submit" id="filter-currency-sell-btn"><i class="fa fa-filter"></i> Filter</button>   
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="currency-sell-report-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Date <small>(Sell)</small></th>
                                <th>Currency</th>
                                <th>Quantity</th>
                                <th>Buy Rate</th>
                                <th>Investment</th>
                                <th>Sell Rate</th>
                                <th>Sell Value</th>
                                <th>Profit/Loss</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><span id="totalSellInvestment">Total Investment</span></th>
                                <th></th>
                                <th><span id="totalSellValue">Total Sell Value</span></th>
                                <th><span id="currency-sell-profit-loss">Total Profit/Loss</span></th>
                            </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="summary">
                <div class="row" style="padding-top: 10px">
                    {!! Form::open(['route'=>'member.report.currencySummary','class'=>'form-horizontal col-xs-12','id'=>'currency-summary-report-form']) !!}
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="summary_currency_type">Currency</label>
                            {!! Form::select('currency',[''=>'All']+$currency,null,['class'=>'form-control','id'=>'summary_currency_type']) !!}
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="summary_buy_from_date">From</label>
                            <div class="input-group">
                                <input class="form-control" name="from" type="date" id="summary_buy_from_date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="summary_buy_to_date">To</label>
                            <div class="input-group">
                                <input class="form-control" name="to" type="date" id="summary_buy_to_date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success ajax-submit" id="filter-currency-summary-btn"><i class="fa fa-filter"></i> Filter</button>   
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="currency-summary-report-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Buy Date</th>
                                <th>Currency</th>
                                <th>Quantity</th>
                                <th>Rate <small>(buy)</small></th>
                                <th>Investment</th>
                                <th>Rate <small>(Market)</small></th>
                                <th>Market Value</th>
                                <th>Profit/Loss</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><span id="totalSummaryInvestment">Total Investment</span></th>
                                <th></th>
                                <th><span id="totalSummaryMarketValue">Total Market Value</span></th>
                                <th><span id="totalSummaryChange">Total Profit/Loss</span></th>
                            </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section id="modal-container"></section>
@endsection

@section('endscript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    loadBuyReport();
    loadSellReport();
    loadSummaryReport();
});

function loadBuyReport(){
    BUY_TABLE = $('#currency-buy-report-table').DataTable({
        processing: true,
        paging: false,
        serverSide: true,
        ajax: {
            url: $('#currency-buy-report-form').attr('action'),
            type: 'POST',
            data: {from:function(){ return $('#buy_from_date').val(); },to:function(){ return $('#buy_to_date').val(); }}
        }, 
        columns: [
            {data: 'buy_date',name:'buy_date',render:function(data,type,row,meta){return moment(data).format('D/MMM/YY');}},
            {data: 'currency_name',name:'currency_name'},
            {data: 'quantity',name:'quantity'},
            {data: 'buy_rate',name:'buy_rate',render:function(data,type,row,meta){
                return data+'/<small>'+row.currency_name+'</small>';
            }},
            {data: 'investment',name:'investment',render:function(data){return floatParse(data);}},
            {data: 'last_sell',name:'last_sell',render:function(data,type,row,meta){
                var fixed = (row.currency_name == 'Indian Rupee') ? 4 : 2;
                var unit = parseFloat(row.currency_unit).toFixed(fixed);
                return (data == null) ? '--' : parseFloat(data/unit).toFixed(fixed) +'/<small>'+row.currency_name+'</small>'+'  <small>('+moment(row.last_date).format('D MMM')+')</small>';
            }},
            {data: 'market_value',name:'market_value',render:function(data){return floatParse(data);}},
            {data: null,name:null,render:function(data,type,row,meta){
                row.change = (row.market_value/row.currency_unit) - row.investment;
                return percentify(row.change,row.investment);
            }},
        ],
        footerCallback: function ( row, data, start, end, display) {
            var self = this;
            this.totalInvest = this.totalMktVal = this.profitLoss = 0;
            $.each(data,function(i,row){
                self.totalInvest += row.investment;
                self.totalMktVal += row.market_value || row.investment;
                self.profitLoss += row.change || 0;
            });

            // Update footer
            $("#totalBuyInvestment").text(floatParse(this.totalInvest));
            $("#totalBuyMarketValue").text(floatParse(this.totalMktVal));
            $("#totalBuyChange").html(percentify(this.profitLoss,this.totalInvest));
        }
    });

    $('#filter-currency-buy-btn').click(function(){
        BUY_TABLE.ajax.reload();
    });
}

function loadSummaryReport(){
    SUMMARY_TABLE = $('#currency-summary-report-table').DataTable({
        processing: true,
        paging: false,
        serverSide: true,
        ajax: {
            url: $('#currency-summary-report-form').attr('action'),
            type: 'POST',
            data: {
                from:function(){ return $('#summary_buy_from_date').val(); },
                to:function(){ return $('#summary_buy_to_date').val(); },
                currency: function(){ return $('#summary_currency_type').val()}
            }
        }, 
        columns: [
            {data: 'buy_date',name:'buy_date',render:function(data){
                return moment(data).format('D MMM YY');
            }},
            {data: 'currency_name',name:'currency_name', render: function (data,type,row) {
                var target = data.toLowerCase().split(' ');
                return '<a href="/currency/'+target[0].replace('$','')+'" target="_blank">'+data+'</a>';
            }},
            {data: 'remaining_quantity',name:'remaining_quantity'},
            {data: 'buy_rate',name:'buy_rate',render:function(data,type,row,meta){
                return floatParse(data)+'/<small>'+row.currency_name+'</small>';
            }},
            {data: 'investment',name:'investment',render:function(data, type, row){
                row.investment = row.remaining_quantity * row.buy_rate;

                return floatParse(row.investment);
            }},
            {data: 'last_sell',name:'last_sell',render:function(data,type,row,meta){
                return floatParse(data)+'  <small>('+moment(row.last_date).format('D MMM')+')</small>';
            }},
            {data: 'market_value',name:'market_value',render:function(data){ return floatParse(data); }},
            {data: null ,name: null,render:function(data,type,row,meta){
                var change = row.market_value - row.investment;
                return percentify(change,row.investment);
            },orderable:false,searchable:false}
        ],
        footerCallback: function ( row, data, start, end, display) {
            var self = this;
            this.totalInvest = this.totalMktVal = this.profitLoss = 0;
            $.each(data,function(i,row){
                var investment = row.remaining_quantity * row.buy_rate;
                var market_value = row.market_value || investment;
                self.totalInvest += investment;
                self.totalMktVal += row.market_value || investment;
                self.profitLoss += market_value - investment;
            });
            // Update footer
            $("#totalSummaryInvestment").text(floatParse(this.totalInvest));
            $("#totalSummaryMarketValue").text(floatParse(this.totalMktVal));
            $("#totalSummaryChange").html(percentify(this.profitLoss,this.totalInvest));
        }
    });

    $('#filter-currency-summary-btn').click(function(){
        SUMMARY_TABLE.ajax.reload();
    });
}

function loadSellReport(){
    SELL_TABLE = $('#currency-sell-report-table').DataTable({
        processing: true,
        paging: false,
        serverSide: true,
        ajax: {
            url: $('#currency-sell-report-form').attr('action'),
            type: 'POST',
            data: {from:function(){ return $('#sell_from_date').val(); },to:function(){ return $('#sell_to_date').val(); }}
        }, columns: [
            {data: 'sell_date',name:'sell_date',render:function(data,type,row,meta){ return moment(data).format('D/MMM/YY');}},
            {data: 'name',name:'name'},
            {data: 'sell_quantity',name:'sell_quantity'},
            {data: 'buy_rate',name:'buy_rate',render:function(data,type,row,meta){ return data+'/<small>'+row.name+'</small>';}},
            {data: 'investment',name:'investment',render:function(data){return floatParse(data);}},
            {data: 'sell_rate',name:'sell_rate',render:function(data,type,row,meta){ return data+'/<small>'+row.name+'</small>';}},
            {data: 'sell_amount',name:'sell_amount',render:function(data){ return floatParse(data);}},
            {data: 'change',name:'change',render:function(data,type,row,meta){ return percentify(data,row.investment);}},
        ],
        footerCallback: function ( row, data, start, end, display) {
            var self = this;
            this.totalInvest = this.sell_amount = this.profitLoss = 0;
            $.each(data,function(i,row){
                self.totalInvest += row.investment;
                self.sell_amount += row.sell_amount || row.investment;
                self.profitLoss += row.change || 0;
            });
            // Update footer
            $("#totalSellInvestment").text(floatParse(self.totalInvest));
            $("#totalSellValue").text(floatParse(self.sell_amount));
            $("#currency-sell-profit-loss").html(percentify(this.profitLoss,this.totalInvest));
        }
    });

    $('#filter-currency-sell-btn').click(function(){
        SELL_TABLE.ajax.reload();
    });
}
</script>
@endsection