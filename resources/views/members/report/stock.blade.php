@extends('members.layout.master')

@section('title')Stock Report
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
        .dataTables_scrollHead{
            overflow: visible !important;
        }
    </style>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-line-chart"></i>Stock Report</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-box-tool" href="{{route('member.stock.index')}}"><i class="fa fa-chevron-circle-left"></i> Stock Portfolio</a>
            <button class="btn btn-box-tool" id="print-btn"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
    <div class="box-body">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#company_report" data-toggle="tab">Stock Performance</a></li>
            <li><a href="#buy_report" data-toggle="tab">Buy Report</a></li>
            <li><a href="#sell_report" data-toggle="tab">Sell Report</a></li>
            <li><a href="#fundamental_analysis" data-toggle="tab">Fundamental Analysis</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="company_report">
                <div class="col-xs-12 col-md-6 col-md-offset-3" style="padding-top: 10px">
                    {!! Form::open(['route'=>'member.report.stockPerformance','class'=>'form-horizontal','id'=>'stock-performance-form']) !!}
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Select Company</div>
                            {!! Form::select('company_quote',$company,null,['class'=>'form-control','id'=>'company_quote']) !!}
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary ajax-submit" id="filter-stock-performance-btn"><i class="fa fa-filter"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-condensed table-striped" id="stock-performance-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Buy Date</th>
                                <th>Basket</th>
                                <th>Buy Rate</th>
                                <th>Quantity</th>
                                <th>Investment</th>
                                <th>Close Price</th>
                                <th>Portfolio Value</th>
                                <th>Profit/Loss</th>
                                <th>Percentage</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th><span id="company-average-rate">Average Rate</span> <small>(Average)</small></th>
                                <th><span id="company-total-quantity">Total Quantity</span></th>
                                <th><span id="totalInvestment">Total Investment</span></th>
                                <th></th>
                                <th><span id="totalValue">Total Portfolio</span></th>
                                <th><span id="company-profit-loss">Total Profit/Loss</span></th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="buy_report">
                {!! Form::open(['route'=>'member.report.buyReport','class'=>'form-horizontal','id'=>'stock-buy-report-form']) !!}
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="select_basket">Select Basket</label>
                        {!! Form::select('basket',$basket,null,['class'=>'form-control','id'=>'select_basket']) !!}
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="from_date">From</label>
                        <div class="input-group">
                            {!! Form::input('date','from_date',null,['class'=>'form-control']) !!}
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="to_date">To</label>
                        <div class="input-group">
                            {!! Form::input('date','to_date',null,['class'=>'form-control']) !!}
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary ajax-submit" id="filter-stock-buy-report-btn"><i class="fa fa-filter"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="stock-buy-report-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Company</th>
                                <th>Buy Date</th>
                                <th>Owner</th>
                                <th>Type</th>
                                <th>DP Company</th>
                                <th>Demat ID</th>
                                <th>Buy Rate</th>
                                <th>Quantity</th>
                                <th>Close Price</th>
                                <th>Commission</th>
                                <th>Investment</th>
                                <th>Market Value</th>
                                <th>Change</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><span id="buy-quantity">Total Quantity</span></th>
                                <th></th>
                                <th><span id="buy-commission">Total Commission</span></th>
                                <th><span id="buy-totalInvestment">Total Investment</span></th>
                                <th><span id="buy-total-market-value">Total Market Value</span></th>
                                <th><span id="buy-total-change">Total Change</span></th>
                            </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="sell_report">
                {!! Form::open(['route'=>'member.report.sellReport','class'=>'form-horizontal','id'=>'stock-sell-report-form']) !!}
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="sell_select_basket">Select Basket</label>
                        {!! Form::select('basket',$basket,null,['class'=>'form-control','id'=>'sell_select_basket']) !!}
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="sell_from_date">From</label>
                        <div class="input-group">
                            {!! Form::input('date','sell_from_date',null,['class'=>'form-control']) !!}
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="sell_to_date">To</label>
                        <div class="input-group">
                            {!! Form::input('date','sell_to_date',null,['class'=>'form-control']) !!}
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary ajax-submit" id="filter-stock-sell-report-btn"><i class="fa fa-filter"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="stock-sell-report-table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Company</th>
                                <th>Date</th>
                                <th>Quantity</th>
                                <th>Rate <small>(sell)</small></th>
                                <th>Commission <small>(Sales)</small></th>
                                <th><span data-toggle="tooltip" data-placement="right" title="Capital Gain">C.G.TAX</span></th>
                                <th>Rate <small>(buy)</small></th>
                                <th>Total Buy</th>
                                <th>Total Sales</th>
                                <th>Profit/Loss</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th><span id="total-sell-quantity">Total Quantity</span></th>
                                <th></th>
                                <th><span id="total-sell-commission">Total Commission</span></th>
                                <th><span id="total-sell-tax">Total C.G.TAX</span></th>
                                <th></th>
                                <th><span id="total-sell-buy">Total Buy</span></th>
                                <th><span id="total-sell-value">Total Sales</span></th>
                                <th><span id="total-sell-income">Total Income</span></th>
                            </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="fundamental_analysis">
                {!! Form::open(['route'=>'member.report.fundamentalAnalysis','class'=>'form-horizontal','id'=>'fundamental-analysis-form']) !!}
                <div class="col-xs-12 col-md-6 col-md-offset-3" style="padding-top: 10px">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Select Sector</div>
                            {!! Form::select('sector',$sector,null,['class'=>'form-control','id'=>'sector']) !!}
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary ajax-submit" id="filter-fundamental-analysis-btn"><i class="fa fa-filter"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="row">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-striped table-condensed" id="fundamental-report-table" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Company</th>
                                <th>Price <small>(Close)</small></th>
                                <th>Paid Up Capital</th>
                                <th>Reserve & Surplus</th>
                                <th>Earning Per Share</th>
                                <th>Net Worth Per Share</th>
                                <th>Book Value Per Share</th>
                                <th>Net Profit</th>
                                <th>Liquidity Ratio</th>
                                <th>Price Earning Ratio</th>
                                <th>Operating Profit</th>
                                <th>Fiscal Year</th>
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
<section id="modal-container"></section>
@endsection

@section('endscript')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/jquery.dataTables.min.js"></script>
    {!! HTML::script('vendors/datatables/Buttons-1.0.3/js/dataTables.buttons.min.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/dataTables.bootstrap.min.js"></script>
    {!! HTML::script('vendors/mustache/mustache.min.js') !!}
    {!! HTML::script('vendors/moment/moment.min.js') !!}
	
    <script type="text/html" id="printable-table">
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>@{{ title }}</title>
            {!! HTML::style('vendors/bootstrap/css/bootstrap.css') !!}
        </head>
        <body>
        <table class="table table-bordered table-condensed table-striped">
            <thead>
            <tr>
                @{{#header}}
                <th>@{{name}}</th>
                @{{/header}}
            </tr>
            </thead>
            <tbody>
            @{{#body}}
            <tr>
                @{{#row}}
                <td>@{{name}}</td>
                @{{/row}}
            </tr>
            @{{/body}}
            </tbody>
            <tfoot>
            <tr>
                @{{#footer}}
                <th>@{{name}}</th>
                @{{/footer}}
            </tr>
            </tfoot>
        </table>
        </body>
        </html>
    </script>
    <script type="text/html" id="fa-toggle-columns">
        <div class="btn-group">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-eye"></i> Show Columns <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li style="padding: 5px 10px">
                    <div class="checkbox"> <label> <input type="checkbox" class="toggle-fa-vis" data-column="2" checked> Paid Up Capital </label> </div>
                    <div class="checkbox"> <label> <input type="checkbox" class="toggle-fa-vis" data-column="3"> Reserve & Surplus </label> </div>
                    <div class="checkbox"> <label> <input type="checkbox" class="toggle-fa-vis" data-column="4" checked> Earning Per Share </label> </div>
                    <div class="checkbox"> <label> <input type="checkbox" class="toggle-fa-vis" data-column="5"> Net Worth Per Share </label> </div>
                    <div class="checkbox"> <label> <input type="checkbox" class="toggle-fa-vis" data-column="6"> Book Value Per Share </label> </div>
                    <div class="checkbox"> <label> <input type="checkbox" class="toggle-fa-vis" data-column="7" checked> Net Profit </label> </div>
                    <div class="checkbox"> <label> <input type="checkbox" class="toggle-fa-vis" data-column="8"> Liquidity Ratio </label> </div>
                    <div class="checkbox"> <label> <input type="checkbox" class="toggle-fa-vis" data-column="9" checked> Price Earning Ratio </label> </div>
                    <div class="checkbox"> <label> <input type="checkbox" class="toggle-fa-vis" data-column="10"> Operating Profit </label> </div>
                </li>
            </ul>
        </div>
    </script>
    <script>
        var buy_report_table;
        var sell_report_table;
        var fundamental_report_table;
        $(document).ready(function(){
            loadStockPerformance();
            $('#print-btn').click(function(){
                var template = $('#printable-table').html();
                Mustache.parse(template);
                data = {header:[],body:[],footer:[],title:$('ul.nav.nav-tabs > li.active > a').text()};
                $.each($(document).find('.tab-pane.active table'),function(i,tab){
                    if(i == 0){ $.each($(tab).find('thead tr th'),function(j,v){ data.header[j] = {name:$(v).text()}; });}
                    else if(i == 1){ $.each($(tab).find('tbody tr'),function(j,tr){ var row = []; $.each($(tr).find('td'),function(k,td){ row[k] = {name:$(td).text()}; });data.body[j] = {row:row};});}
                    else if(i == 2){ $.each($(tab).find('tfoot tr th'),function(j,v){ data.footer[j] = {name:$(v).text()}; }); }
                });
                var html = Mustache.render(template,data);
                var w = window.open(); w.document.write(html);setTimeout(function(){w.print();w.close()},1500);
            });
        });

        $('a[href=#buy_report]').click(function(){ loadBuyReport(); });
        $('a[href=#sell_report]').click(function(){ loadSellReport(); });
        $('a[href=#fundamental_analysis]').click(function(){ loadFundamentalReport(); });

        $('.ajax-submit').click(function(e){e.preventDefault()});

        function loadStockPerformance(){
            var table = $('#stock-performance-table').DataTable({
                processing: true,
                paging: false,
                serverSide: false,
                lengthMenu: [[100,200,300],[100,200,300]],
                ajax: {
                    url: $('#stock-performance-form').attr('action'),
                    type: 'POST',
                    data: {quote:function(){ return $('#company_quote').val(); }}
                }, 
                columns: [
                    {data: 'buy_date',name:'buy_date',render:function(data,type,row,meta){
                        return moment(data).format('D/MMM/YY');
                    }},
                    {data: 'basket_name',name:'basket_name',render:function(data,type,row,meta){
                        return '<a href="'+"{{route('member.stock.index')}}/"+row.basket_id+'">'+data+'</a>';
                    }},
                    {data: 'buy_rate',name:'buy_rate',render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'r_quantity',name:'r_quantity'},
                    {data: 'investment',name:'investment',render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'close_price',name:'close_price',render:function(data,type,row,meta){
                        return (data == null || data == '' || data < 0) ? '--' : parseFloat(data).toFixed(2)+'<small>('+moment(row.tran_date).format('D MMM')+')</small>';
                    }},
                    {data: 'portfolio_value',name:'portfolio_value',render:function(data,type,row,meta){
                        return (data == null || data == '' || data < 0) ? '--' : parseFloat(data).toFixed(2);
                    }},
                    {data: null,render:function(data,type,row,meta){
                        if(row.portfolio_value == null){return '--';}

                        row.profit_loss = row.portfolio_value - row.investment;
                        row.change = 'neutral';
                        if(row.profit_loss > 0) {row.change = 'up';}
                        else if(row.profit_loss < 0) {row.change = 'down';}

                        return '<span data-change="'+row.change+'">'+parseFloat(row.profit_loss).toFixed(2)+'</span>';
                    }},

                    {data: null,render:function(data,type,row,meta){
                        if(row.portfolio_value == null) return '--';

                        return '<span data-change="'+row.change+'">'+parseFloat(row.profit_loss *100 /row.investment).toFixed(2)+'<small style="font-size: 0.7em">%</small></span>';
                    }}
                ],
                footerCallback: function ( row, data, start, end, display) {
                    var self = this;
                    this.totalInvest = this.totalPort = this.totalQuantity = this.totalRate = this.profitLoss = 0;
                    $.each(data,function(i,row){
                        self.totalQuantity += parseInt(row.r_quantity);
                        self.totalInvest += row.investment;
                        self.totalPort += row.portfolio_value;
                        self.totalRate += row.buy_rate;
                        self.profitLoss += row.profit_loss;
                    });

                    this.averageRate = 0;
                    if(end != 0) this.averageRate = self.totalRate/end;

                    // Update footer
                    $("#company-total-quantity").text(self.totalQuantity);
                    $("#company-average-rate").text(parseFloat(self.averageRate).toFixed(2));
                    $("#totalInvestment").text(parseFloat(self.totalInvest).toFixed(2));
                    $("#totalValue").text(parseFloat(self.totalPort).toFixed(2));
                    $("#company-profit-loss").text(parseFloat(self.profitLoss).toFixed(2));
                }
            });

            $('#filter-stock-performance-btn').click(function(){
                table.ajax.reload();
            });
        }

        function loadBuyReport(){
            if(typeof buy_report_table != 'undefined') return;

            var form = $('#stock-buy-report-form');
            buy_report_table = $('#stock-buy-report-table').DataTable({
                processing: true,
                paging: true,
                serverSide: true,
                lengthMenu: [[100,200,300],[100,200,300]],
                dom: '<".row"<"col-xs-6"<"#fa-buy-basket.pull-left">> <".col-xs-6"<"pull-right"f>>><".row"<".col-xs-12"tr>><".row"<".col-xs-12"ip>>',
                ajax: {
                    url: form.attr('action'),
                    type: 'POST',
                    data: {
                      basket: function(){
                        return form.find('[name=basket]').val();
                      },
                      from_date: function(){
                        return form.find('[name=from_date]').val();
                      },
                      to_date: function(){
                        return form.find('[name=to_date]').val();
                      }
                    }
                }, 
                columns: [
                    {data: 'quote', name: 'quote', render:function(data,type,row,meta){
                      return '<a href="/quote/'+data+'" target="_blank"><span data-toggle="tooltip" data-placement="down" title="'+row.company_name+'">'+data+'</span></a>';
                    }},
                    {data: 'buy_date', searchable: false, render:function(data,type,row,meta){
                        return moment(data).format('D/MMM/YY');
                    }},
                    {data: 'owner_name', render:function(data,type,row,meta){
                        return (data == null || data == '') ? '--' : data;
                    }},
                    {data: 'stock_type_name', name: 'am_stock_types.name'},
                    {data: 'shareholder_number', render:function(data,type,row,meta){
                        return (data == null || data == '') ? '--' : data;
                    }},
                    {data: 'certificate_number', render:function(data,type,row,meta){
                        return (data == null || data == '') ? '--' : data;
                    }},
                    {data: 'buy_rate_with_commission', searchable: false, render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'quantity', searchable: false},
                    {data: 'close_price',searchable: false,render:function(data,type,row,meta){
                      if(!data) return '-NA-';

                      data = parseFloat(data).toFixed(2);

                      return data + ' <small>('+moment(row.close_date).format('Do MMM YY')+')</small>';
                    }},
                    {data: 'commission', searchable: false, render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'investment',searchable: false,render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'market_value',searchable: false,render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'profit_loss',searchable: false,render:function(data,type,row,meta){
                      if (!data) {
                        return '<span data-change="neutral">0.00 <small>(0.00%)</small></span>';
                      }

                      var changePercent = Math.abs(parseFloat(100* (row.market_value - row.investment)/(row.investment || row.market_value)).toFixed(2));

                      var dataChange = data > 0 ? 'up' : (data < 0 ? 'down' : 'neutral');

                      return '<span data-change="'+dataChange+'">'+parseFloat(data).toFixed(2)+' <small>('+changePercent+'%)</small></span>';
                    }},
                ],
                footerCallback: function ( row, data, start, end, display) {
                  var self = this;
                  this.totalInvest = this.totalMarketValue = this.totalQuantity = this.totalCommission = this.totalChange = 0;
                  $.each(data,function(i,row){
                    self.totalInvest += row.investment;
                    self.totalQuantity += row.quantity;
                    self.totalCommission += row.commission;
                    self.totalMarketValue += row.market_value;
                    self.totalChange += row.profit_loss;
                  });

                  var dataChange = this.totalChange > 0 ? "up" : (this.totalChange < 0 ? 'down' : 'neutral');
                  var totalChangePercent = parseFloat(Math.abs((this.totalMarketValue - this.totalInvest) * 100 / (this.totalMarketValue || this.totalInvest))).toFixed(2);

                  // Update footer
                  $("#buy-quantity").text(self.totalQuantity);
                  $("#buy-commission").text(parseFloat(self.totalCommission).toFixed(2));
                  $("#buy-totalInvestment").text(parseFloat(self.totalInvest).toFixed(2));
                  $("#buy-total-market-value").text(parseFloat(self.totalMarketValue).toFixed(2));
                  $("#buy-total-change").html(
                    '<span data-change="'+dataChange+'">'+parseFloat(this.totalChange).toFixed(2)+'  <small>('+totalChangePercent+' %)</small></span>'
                  );
                }
            });
            $('#filter-stock-buy-report-btn').click(function(){
                buy_report_table.ajax.reload();
                updateBuyBasket();
            });

            function updateBuyBasket(){
                this.target = $('#select_basket');
                this.id = this.target.val();
                this.name = this.target.find('option:selected').text();
                $(document).find('#fa-buy-basket').html('Basket Name: <strong><a href="'+"{{route('member.stock.index')}}"+'/'+this.id+'">'+this.name+'</a></strong>');
            }

            updateBuyBasket();
        }

        function loadSellReport(){
            if(typeof sell_report_table != 'undefined') return;
            var form = $('#stock-sell-report-form');

            sell_report_table = $('#stock-sell-report-table').DataTable({
                processing: true,
                paging: true,
                serverSide: true,
                dom: '<".row"<"col-xs-6"<"#fa-sell-basket.pull-left">> <".col-xs-6"<"pull-right"f>>><".row"<".col-xs-12"tr>><".row"<".col-xs-12"ip>>',
                lengthMenu: [[100,200,300],[100,200,300]],
                ajax: {
                    url: form.attr('action'),
                    type: 'POST',
                    data: {
                      basket: function () {
                        return form.find('[name=basket]').val();
                      },
                      sell_from_date: function () {
                        return form.find('[name=sell_from_date]').val();
                      },
                      sell_to_date: function () {
                        return form.find('[name=sell_to_date]').val();
                      }
                    }
                }, columns: [
                    {data: 'company_name', render:function(data,type,row,meta){
                        return '<span data-toggle="tooltip" data-placement="down" title="'+row.company_name+'">'+row.company_quote+'</span>';
                    }},
                    {data: 'sell_date',render:function(data,type,row,meta){
                        return moment(data).format('D/MMM/YY');
                    }},
                    {data: 'sell_quantity'},
                    {data: 'sell_rate',name:'sell_rate',render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'sell_commission',render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'tax',render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'buy_rate',render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'buy_price',render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'total_sales',render:function(data,type,row,meta){
                        return parseFloat(data).toFixed(2);
                    }},
                    {data: 'income',render:function(data,type,row,meta){
                        this.dataChange = 'neutral';
                        if(data > 0){ this.dataChange = 'up'; }
                        else if(data < 0){ this.dataChange = 'down';}
                        return '<span data-change="'+this.dataChange+'">'+parseFloat(data).toFixed(2)+'</span>';
                    }}
                ],

                footerCallback: function ( row, data, start, end, display) {
                    var self = this;
                    this.totalValue =  this.totalSales = this.totalQuantity =
                            this.totalCommission = this.totalTax = this.totalBuy = 0;
                    $.each(data,function(i,row){
                        self.totalQuantity += row.sell_quantity;
                        self.totalTax += row.tax;
                        self.totalCommission += row.sell_commission;
                        self.totalValue += row.total_sales;
                        self.totalSales += row.income;
                        self.totalBuy += row.buy_price;
                    });

                    this.dataChange = 'neutral';
                    if(self.totalSales > 0){ this.dataChange = 'up'; }
                    else if(self.totalSales < 0){ this.dataChange = 'down';}

                    // Update footer
                    $("#total-sell-quantity").text(self.totalQuantity);
                    $("#total-sell-commission").text(parseFloat(self.totalCommission).toFixed(2));
                    $("#total-sell-tax").text(self.totalTax);
                    $("#total-sell-buy").text(parseFloat(self.totalBuy).toFixed(2));

                    $("#total-sell-income").html('<span data-change="'+this.dataChange+'">'+parseFloat(self.totalSales).toFixed(2)+'</span>');
                    $("#total-sell-value").text(parseFloat(self.totalValue).toFixed(2));
                }
            });
            $('#filter-stock-sell-report-btn').click(function(){
                sell_report_table.ajax.reload();
                updateSellBasket();
            });

            function updateSellBasket(){
                this.target = $('#sell_select_basket');
                this.id = this.target.val();
                this.name = this.target.find('option:selected').text();
                $(document).find('#fa-sell-basket').html('Basket Name: <strong><a href="'+"{{route('member.stock.index')}}"+'/'+this.id+'">'+this.name+'</a></strong>');
            }

            updateSellBasket();
        }

        function loadFundamentalReport(){
            if(typeof fundamental_report_table != 'undefined') return;
            var form = $('#fundamental-analysis-form');

            fundamental_report_table = $('#fundamental-report-table').DataTable({
                processing: true,
                paging: false,
                serverSide: false,
                dom: '<".row"<"col-xs-6"<"#fa-toggle-col.pull-left">> <".col-xs-6"<"pull-right"f>>><".row"<".col-xs-12"tr>><".row"<".col-xs-12"ip>>',
                lengthMenu: [[100,200,300],[100,200,300]],
                ajax: {
                    url: form.attr('action'),
                    type: 'POST',
                    data: function(){return form.serialize();}
                }, columns: [
                    {data: 'company_name',name:'company_name',render:function(data,type,row,meta){
                        return '<span data-toggle="tooltip" data-placement="down" title="'+data+'">'+row.company_quote+'</span>';
                    }},
                    {data: 'close_price',name:'close_price',render:function(data,type,row,meta){
                        if(data == null) return '--';
                        return data+'&nbsp;&nbsp;<small>('+moment(row.tran_date).format('D MMM')+')</small>';
                    }},
                    {data: 'paid_up_capital',name:'paid_up_capital',render:function(data,type,row,meta){
                        return (data == null) ? '--' : data;
                    }},
                    {data: 'reserve_and_surplus',name:'reserve_and_surplus',visible:false,render:function(data,type,row,meta){
                        return (data == null) ? '--' : data;
                    }},
                    {data: 'earning_per_share',name:'earning_per_share',render:function(data,type,row,meta){
                        return (data == null) ? '--' : data;
                    }},
                    {data: 'net_worth_per_share',name:'net_worth_per_share',visible:false,render:function(data,type,row,meta){
                        return (data == null) ? '--' : data;
                    }},
                    {data: 'book_value_per_share',name:'book_value_per_share',visible:false,render:function(data,type,row,meta){
                        return (data == null) ? '--' : data;
                    }},
                    {data: 'net_profit',name:'net_profit',render:function(data,type,row,meta){
                        return (data == null) ? '--' : data;
                    }},
                    {data: 'liquidity_ratio',name:'liquidity_ratio',visible:false,render:function(data,type,row,meta){
                        return (data == null) ? '--' : data;
                    }},
                    {data: 'price_earning_ratio',name:'price_earning_ratio',render:function(data,type,row,meta){
                        return (data == null) ? '--' : data;
                    }},
                    {data: 'operating_profit',name:'operating_profit',visible:false,render:function(data,type,row,meta){
                        return (data == null) ? '--' : data;
                    }},
                    {data: 'fiscal_year',name:'fiscal_year',render:function(data,type,row,meta){
                        if (data == null) return '--';
                        return data+'&nbsp;&nbsp;<small>('+row.quarter+')</small>';
                    }}
                ]
            });
            $('#fa-toggle-col').html($('#fa-toggle-columns').html());
            $(document).on('change','input.toggle-fa-vis', function () {
                var column = fundamental_report_table.column( $(this).data('column') );
                if($(this).is(':checked')){
                    column.visible( true );
                }else{
                    column.visible( false );
                }
            });
            $('#filter-fundamental-analysis-btn').click(function(){
                fundamental_report_table.ajax.reload();
            });

            $('.dropdown-menu').click(function(e) {
                e.stopPropagation();
            });
        }
    </script>
@endsection