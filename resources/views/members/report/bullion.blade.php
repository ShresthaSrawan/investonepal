@extends('members.layout.master')

@section('title')Bullion Report
@endsection

@section('specificheader')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" data-css="print"> !!}
    {!! HTML::style('vendors/datatables/Buttons-1.0.3/css/buttons.dataTables.min.css') !!}
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
        <h3 class="box-title"><i class="fa fa-line-chart"></i> Bullion Report</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-box-tool" href="{{route('member.bullion.index')}}"><i class="fa fa-chevron-circle-left"></i> Bullion Portfolio</a>
            <button class="btn btn-box-tool" id="print-btn"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
    <div class="box-body">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#buy_report" data-toggle="tab">Buy Report</a></li>
            <li><a href="#sell_report" data-toggle="tab">Sell Report</a></li>
            <li><a href="#summary_report" data-toggle="tab">Summary Report</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active in" id="buy_report">
                <div class="row" style="padding-top: 10px">
                    {!! Form::open(['route'=>'member.report.buyBullion','class'=>'form-horizontal col-xs-12','id'=>'bullion-buy-report-form']) !!}
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
                                    <button type="button" class="btn btn-success ajax-submit" id="filter-bullion-buy-btn"><i class="fa fa-filter"></i> Filter</button>   
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="bullion-buy-report-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Buy Date</th>
                                <th>Bullion</th>
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
                    {!! Form::open(['route'=>'member.report.sellBullion','class'=>'form-horizontal col-xs-12','id'=>'bullion-sell-report-form']) !!}
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
                                    <button type="button" class="btn btn-success ajax-submit" id="filter-bullion-sell-btn"><i class="fa fa-filter"></i> Filter</button>   
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="bullion-sell-report-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Date <small>(Sell)</small></th>
                                <th>Bullion</th>
                                <th>Quantity</th>
                                <th>Rate <small>(Buy)</small></th>
                                <th>Investment</th>
                                <th>Rate <small>(Sell)</small></th>
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
                                <th><span id="bullion-sell-profit-loss">Total Profit/Loss</span></th>
                            </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="summary_report">
                <div class="row" style="padding-top: 10px">
                    {!! Form::open(['route'=>'member.report.bullionSummary','class'=>'form-horizontal col-xs-12','id'=>'bullion-summary-report-form']) !!}
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="summary_bullion_type">Bullion</label>
                            {!! Form::select('bullion',[''=>'All']+$bullion,null,['class'=>'form-control','id'=>'summary_bullion_type']) !!}
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="summary_from_date">From</label>
                            <div class="input-group">
                                <input class="form-control" name="from" type="date" id="summary_from_date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="summary_to_date">To</label>
                            <div class="input-group">
                                <input class="form-control" name="to" type="date" id="summary_to_date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success ajax-submit" id="filter-bullion-summary-btn"><i class="fa fa-filter"></i> Filter</button>   
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="bullion-summary-report-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Buy Date</th>
                                <th>Bullion</th>
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
    {!! HTML::script('vendors/datatables/Buttons-1.0.3/js/dataTables.buttons.min.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/dataTables.bootstrap.min.js"></script>
    {!! HTML::script('vendors/mustache/mustache.min.js') !!}
    {!! HTML::script('vendors/moment/moment.min.js') !!}    
<script>
$(document).ready(function(){
    loadBuyReport();
    loadSellReport();
    loadSummaryReport();
});

function loadBuyReport(){
    BUY_TABLE = $('#bullion-buy-report-table').DataTable({
        processing: true,
        paging: false,
        serverSide: false,
        ajax: {
            url: $('#bullion-buy-report-form').attr('action'),
            type: 'POST',
            data: {from:function(){ return $('#buy_from_date').val(); },to:function(){ return $('#buy_to_date').val(); }}
        }, columns: [
            {data: 'buy_date',name:'buy_date',render:function(data,type,row,meta){
                return moment(data).format('D/MMM/YY');
            }},
            {data: 'type.name',name:'type.name'},
            {data: 'quantity',name:'quantity'},
            {data: 'buy_rate',name:'buy_rate',render:function(data,type,row,meta){
                return parseFloat(data).toFixed(2);
            }},
            {data: 'investment',name:'investment',render:function(data,type,row,meta){
                return parseFloat(data).toFixed(2);
            }},
            {data: 'market_rate',name:'market_rate',render:function(data,type,row,meta){
                if(data === null) return '--';
                var suffix = row.type.unit.split(' ');
                suffix = '/'+(suffix.length === 2 ? suffix[1] : 'Unit');
                return data + suffix +'  <small>('+moment(row.last_date).format('D/MMM/YY')+')</small>';
            }},
            {data: 'market_value',name:'market_value',render: function (data,type,row,meta) {
                return parseFloat(data).toFixed(2);
            }},
            {data: 'difference',name:'difference',render:function(data,type,row,meta){
                return percentify(data,row.investment);
            }},
        ],
        footerCallback: function ( row, data, start, end, display) {
            var self = this;
            this.totalInvest = this.totalMktVal = this.profitLoss = this.percent = 0;
            $.each(data,function(i,row){
                self.totalInvest += row.investment;
                self.totalMktVal += row.market_value;
                self.profitLoss += row.difference || 0;
            });


            this.percent = parseFloat((self.totalMktVal - self.totalInvest)*100/self.totalInvest).toFixed(2);
            self.dataChange = (self.profitLoss > 0) ? 'up' : ((self.profitLoss < 0) ? 'down' : 'neutral');
            self.profitLoss = '<span data-change="'+self.dataChange+'">'+parseFloat(self.profitLoss).toFixed(2)+' <small>('+self.percent+'%)</small></span>'
            // Update footer
            $("#totalBuyInvestment").text(parseFloat(self.totalInvest).toFixed(2));
            $("#totalBuyMarketValue").text(parseFloat(self.totalMktVal).toFixed(2));
            $("#totalBuyChange").html(self.profitLoss);
        }
    });

    $('#filter-bullion-buy-btn').click(function(){
        BUY_TABLE.ajax.reload();
    });
}
function loadSellReport(){
    SELL_TABLE = $('#bullion-sell-report-table').DataTable({
        processing: true,
        paging: false,
        serverSide: false,
        ajax: {
            url: $('#bullion-sell-report-form').attr('action'),
            type: 'POST',
            data: {from:function(){ return $('#sell_from_date').val(); },to:function(){ return $('#sell_to_date').val(); }}
        }, columns: [
            {data: 'sell_date',name:'sell_date',render:function(data,type,row,meta){
                return moment(data).format('D/MMM/YY');
            }},
            {data: 'name',name:'name'},
            {data: 'sell_quantity',name:'sell_quantity'},
            {data: 'buy_rate',name:'buy_rate',render:function(data,type,row,meta){
                return row.sbuy_rate;
            }},
            {data: 'investment',name:'investment'},
            {data: 'sell_rate',name:'sell_rate',render:function(data,type,row,meta){
                return row.ssell_rate;
            }},
            {data: 'sell_price',name:'sell_price'},
            {data: 'change',name:'change',render:function(data,type,row,meta){ 
                this.dataChange =  (data > 0) ? 'up' : ((data < 0) ? 'down' : 'neutral');
                return '<span data-change="'+this.dataChange+'">'+data+'  <small>('+parseFloat(row.change_percent).toFixed(2)+'%)</small>'+'</span>';  
            }},
        ],
        footerCallback: function ( row, data, start, end, display) {
            var self = this;
            this.totalInvest = this.sell_amount = this.profitLoss = 0;
            $.each(data,function(i,row){
                self.totalInvest += row.investment;
                self.sell_amount += row.sell_price || row.investment;
                self.profitLoss += row.change || 0;
            });

            this.percent = parseFloat((self.sell_amount - self.totalInvest)*100/self.totalInvest).toFixed(2);
            self.dataChange = (self.profitLoss > 0) 
                ? 'up' 
                : ((self.profitLoss < 0) ? 'down' : 'neutral'); 
            // Update footer
            self.profitLoss = '<span data-change="'+self.dataChange+'">'+parseFloat(self.profitLoss).toFixed(2)+' <small>('+self.percent+'%)</small></span>'
            $("#totalSellInvestment").text(parseFloat(self.totalInvest).toFixed(2));
            $("#totalSellValue").text(parseFloat(self.sell_amount).toFixed(2));
            $("#bullion-sell-profit-loss").html(self.profitLoss);
        }
    });

    $('#filter-bullion-sell-btn').click(function(){
        SELL_TABLE.ajax.reload();
    });
}
function loadSummaryReport(){
    SUMMARY_TABLE = $('#bullion-summary-report-table').DataTable({
        processing: true,
        paging: false,
        serverSide: false,
        ajax: {
            url: $('#bullion-summary-report-form').attr('action'),
            type: 'POST',
            data: {
                from:function(){ return $('#summary_from_date').val(); },
                to:function(){ return $('#summary_to_date').val(); },
                bullion: function(){ return $('#summary_bullion_type').val() }
            }
        },
        columns: [
            {data: 'buy_date',name:'buy_date',render:function(data){
                return moment(data).format('D MMM YY');
            }},
            {data: 'type.name',name:'type.name',render:function (data,type,row,meta) {
                var target = data.toLowerCase().split(' ');
                return '<a href="/bullion/'+target[0]+'" target="_blank">'+data+'</a>';
            }},
            {data: 'buy_rate',name:'buy_rate',render:function(data,type,row,meta){
                affix = row.type.unit.split(' ');
                return data+'/'+affix[affix.length - 1];
            }},
            {data: 'remaining_quantity',name:'remaining_quantity',render:function(data,type,row,meta){
                affix = row.type.unit.split(' ');
                return data+' '+affix[affix.length - 1];
            }},
            {data: 'investment',name:'investment',render:function(data){
                return parseFloat(data).toFixed(2);
            }},
            {data: 'last_price',name:'last_price',render:function(data,type,row,meta){
                affix = row.type.unit.split(' ');
                return row.market_rate+'/'+affix[affix.length - 1]+'  <small>('+moment(row.last_date).format('D MMM')+')</small>';
            }},
            {data: 'market_value',name:'market_value',render:function(data){
                return parseFloat(data).toFixed(2);
            }},
            {data: 'change.amount',name:'change.amount',render:function(data,type,row,meta){
                return percentify(data,row.investment);
            }},
        ],
        footerCallback: function ( row, data, start, end, display) {
            var self = this;
            this.totalInvest = this.totalMktVal = this.profitLoss = this.percent = 0;
            $.each(data,function(i,row){
                self.totalInvest += row.total_amount;
                self.totalMktVal += row.market_value || row.total_amount;
                self.profitLoss += row.change.amount || 0;
            });


            this.percent = parseFloat((self.totalMktVal - self.totalInvest)*100/self.totalInvest).toFixed(2);
            self.dataChange = (self.profitLoss > 0) ? 'up' : ((self.profitLoss < 0) ? 'down' : 'neutral');
            self.profitLoss = '<span data-change="'+self.dataChange+'">'+parseFloat(self.profitLoss).toFixed(2)+' <small>('+self.percent+'%)</small></span>'
            // Update footer
            $("#totalSummaryInvestment").text(parseFloat(self.totalInvest).toFixed(2));
            $("#totalSummaryMarketValue").text(parseFloat(self.totalMktVal).toFixed(2));
            $("#totalSummaryChange").html(self.profitLoss);
        }
    });

    $('#filter-bullion-summary-btn').click(function(){
        SUMMARY_TABLE.ajax.reload();
    });
}
</script>
@endsection