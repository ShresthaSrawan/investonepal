@extends('members.layout.master')

@section('title')Property Report
@endsection

@section('specificheader')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" data-css="print">
    {!! HTML::style('vendors/datatables/Buttons-1.0.3/css/buttons.dataTables.min.css') !!}
    {!! HTML::style('vendors/animate/animate.css') !!}
    <style>
        *{
            border-radius: 0 !important;
        }
        [data-change]{
            font-weight: 600;
        }
        [data-change="up"]:before{
            content: '+';
        }
        [data-change="up"]{
            color: #188811;
        }
        [data-change="down"]{
            color: #f00000;
        }
        [data-change="neutral"]{
            color: #BDBDBD;
        }
        .content{
            overflow: hidden;
        }
    </style>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-line-chart"></i> Property Report</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-box-tool" href="{{route('member.property.index')}}"><i class="fa fa-chevron-circle-left"></i> Property Portfolio</a>
            <button class="btn btn-box-tool" id="print-btn"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
    <div class="box-body">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#buy_report" data-toggle="tab">Buy Report</a></li>
            <li><a href="#sell_report" data-toggle="tab">Sell Report</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active in" id="buy_report">
                <div class="row" style="padding-top: 10px">
                    {!! Form::open(['route'=>'member.report.buyProperty','class'=>'form-horizontal col-xs-12','id'=>'property-buy-report-form']) !!}
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
                                    <button type="button" class="btn btn-success ajax-submit" id="filter-property-buy-btn"><i class="fa fa-filter"></i> Filter</button>   
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="property-buy-report-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Buy Date</th>
                                <th>Asset Name</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Buy Rate <small>(per unit)</small></th>
                                <th>Investment</th>
                                <th>Mkt. Rate <small>(per unit)</small></th>
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
                                <th></th>
                                <th><span id="totalInvestment">Total Investment</span></th>
                                <th></th>
                                <th><span id="totalValue">Total Portfolio</span></th>
                                <th><span id="company-profit-loss">Total Profit/Loss</span></th>
                            </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane fade" id="sell_report">
                <div class="row" style="padding-top: 10px">
                    {!! Form::open(['route'=>'member.report.sellProperty','class'=>'form-horizontal col-xs-12','id'=>'property-sell-report-form']) !!}
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
                                    <button type="button" class="btn btn-success ajax-submit" id="filter-property-sell-btn"><i class="fa fa-filter"></i> Filter</button>   
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="property-sell-report-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Date <small>(Sell)</small></th>
                                <th>Asset Name</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Buy Rate <small>(per unit)</small></th>
                                <th>Investment</th>
                                <th>Sell Rate <small>(per unit)</small></th>
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
                                <th></th>
                                <th><span id="totalSellInvestment">Total Investment</span></th>
                                <th></th>
                                <th><span id="totalSellValue">Total Portfolio</span></th>
                                <th><span id="company-sell-profit-loss">Total Profit/Loss</span></th>
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
});

function loadBuyReport(){
    BUY_TABLE = $('#property-buy-report-table').DataTable({
        processing: true,
        paging: false,
        serverSide: true,
        ajax: {
            url: $('#property-buy-report-form').attr('action'),
            type: 'POST',
            data: {from:function(){ return $('#buy_from_date').val(); },to:function(){ return $('#buy_to_date').val(); }}
        }, columns: [
            {data: 'buy_date',name:'buy_date',render:function(data,type,row,meta){
                return moment(data).format('D/MMM/YY');
            }},
            {data: 'asset_name',name:'asset_name'},
            {data: 'quantity',name:'quantity'},
            {data: 'unit',name:'unit'},
            {data: 'rate',name:'rate',render:function(data){ return floatParse(data);}},
            {data: 'investment',name:'investment',render:function(data){ return floatParse(data);}},
            {data: 'market_rate',name:'market_rate',render:function(data,type,row,meta){
                if (data == null) {return '--';} 
                this.marketRate = floatParse(row.market_rate);
                if(row.market_date != null){ 
                    this.marketRate+='  <small>('+moment(row.market_date).format('D/MMM/YY')+')</small>';
                }
                return this.marketRate;
            }},
            {data: 'market_value',name:'market_value',render:function(data){ return floatParse(data);}},
            {data: 'change',name:'change',render:function(data,type,row,meta){ return percentify(data,row.investment);}},
        ],
        footerCallback: function ( row, data, start, end, display) {
            var self = this;
            this.totalInvest = this.totalPort = this.totalQuantity = this.totalRate = this.profitLoss = 0;
            $.each(data,function(i,row){
                self.totalInvest += row.investment;
                self.totalPort += row.market_value || row.investment;
                self.profitLoss += row.change || 0;
            });
            this.percent = this.profitLoss * 100 / this.totalInvest;
            // Update footer
            $("#totalInvestment").text(floatParse(self.totalInvest));
            $("#totalValue").text(floatParse(self.totalPort));
            $("#company-profit-loss").html(percentify(self.profitLoss,self.totalInvest));
        }
    });

    $('#filter-property-buy-btn').click(function(){
        BUY_TABLE.ajax.reload();
    });
}

function loadSellReport(){
    SELL_TABLE = $('#property-sell-report-table').DataTable({
        processing: true,
        paging: false,
        serverSide: false,
        ajax: {
            url: $('#property-sell-report-form').attr('action'),
            type: 'POST',
            data: {from:function(){ return $('#sell_from_date').val(); },to:function(){ return $('#sell_to_date').val(); }}
        }, columns: [
            {data: 'sell_date',name:'sell_date',render:function(data,type,row,meta){
                return moment(data).format('D/MMM/YY');
            }},
            {data: 'asset_name',name:'asset_name'},
            {data: 'sell_quantity',name:'sell_quantity'},
            {data: 'unit',name:'unit'},
            {data: 'buy_rate',name:'buy_rate',render:function(data){return floatParse(data);}},
            {data: 'investment',name:'investment',render:function(data){return floatParse(data);}},
            {data: 'sell_rate',name:'sell_rate',render:function(data){return floatParse(data);}},
            {data: 'sell_value',name:'sell_value',render:function(data){return floatParse(data);}},
            {data: 'change',name:'change',render:function(data,type,row,meta){ return percentify(data,row.investment);}},
        ],
        footerCallback: function ( row, data, start, end, display) {
            var self = this;
            this.totalInvest = this.totalPort = this.totalQuantity = this.totalRate = this.profitLoss = 0;
            $.each(data,function(i,row){
                self.totalInvest += row.investment;
                self.totalPort += row.market_value || row.investment;
                self.profitLoss += row.change || 0;
            });

            // Update footer
            $("#totalSellInvestment").text(floatParse(self.totalInvest));
            $("#totalSellValue").text(floatParse(self.totalPort));
            $("#company-sell-profit-loss").html(percentify(self.profitLoss,self.totalInvest));
        }
    });

    $('#filter-property-sell-btn').click(function(){
        SELL_TABLE.ajax.reload();
    });
}

</script>
@endsection