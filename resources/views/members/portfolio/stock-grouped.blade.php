@extends('members.layout.master')

@section('title')Stock
@endsection

@section('specificheader')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    {!! HTML::style('vendors/animate/animate.css') !!}
    <style>
        *{
            border-radius: 0 !important;;
        }
        .tab-pane .form-group{
            width: 100%;
            margin-bottom: 5px !important;
        }
        .tab-pane .form-group .form-control{
            width: 100% !important;
        }
        .text-left{
            text-align: left !important;
        }
        [data-change]{
            font-weight: 600;
        }
        [data-change="up"]{
            color: #309A30;
        }
        [data-change="up"]:before{
            content: '+';
        }
        [data-change="down"]{
            color: #F59393;
        }
        [data-change="nutral"]{
            color: #BDBDBD;
        }
    </style>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            <form action="#" class="form form-inline">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-shopping-cart"></i> Stock Basket
                        </div>
                        {!! Form::select('basketList',$baskets->lists('name','id')->toArray(),$selected,['class'=>'input-sm','id'=>'basketList']) !!}
                    </div>
                </div>
            </form>
        </div>
        <div class="box-tools pull-right">
            <div class="btn-group">
                <a class="btn btn-box-tool" href="{{route('member.report.stock')}}"><i class="fa fa-area-chart"></i> Report</a>
                <button class="btn btn-box-tool" id="buy-stock"><i class="fa fa-plus-circle"></i> Add Stock</button>
            </div>
        </div>
    </div>
    <div class="box-body" style='{{$baskets->isEmpty() ? "position:relative;background:#D2D6DE" : ""}}'>
        <ul class="nav nav-tabs hide" role="tablist">
            <li class="active"><a data-toggle="tab" href="#portfolio-all-grouped">All</a></li>
            <li><a data-toggle="tab" href="#protfolio-stock-group">Stock</a></li>
            <li><a data-toggle="tab" href="#protfolio-stock-sell-group">Sell</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="portfolio-all-grouped"
            >
                <h4 style="text-align: center; margin-top: 0">Basket Name: <span id="basketHeader" style="font-weight: 600"></span></h4>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="toggle-sold-stock"> Show/Hide Sold Stock
                            </label>
                        </div>
                    </div>
                    <div class="table-responsive col-xs-12">    
                        <table class="table table-condensed table-striped" id="am-stock-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Stock Quote">Quote</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Average Buy Rate">Buy Rate</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Quantity">Qty</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Last Close Price">Close Price</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Investment">Investment</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Market Value">Market Value</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Change">Change</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Child Stocks">Stocks</span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Stock Quote">Quote</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Average Buy Rate">Buy Rate</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Quantity">Qty</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Last Close Price">Close Price</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Investment">Investment</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Market Value">Market Value</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Change">Change</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Child Stocks">Stocks</span></th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th><span id="totalInvestment">Total Investment</span></th>
                                    <th><span id="totalValue">Total Portfolio</span></th>
                                    <th><span id="totalChange">Total Change</span></th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" role="tabpanel" id="protfolio-stock-group">
                <button class="btn btn-box-tool pull-right" data-back="#portfolio-all-grouped">
                    <i class="fa fa-chevron-circle-left"></i> Back
                </button>
                <h4 style="text-align: center; margin-top: 0">Stock Quote: <span id="header-stock-quote" style="font-weight: 600"></span></h4>
                <div class="row">
                    <div class="col-xs-12">
                        <input type="hidden" name="stock_company_id">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="toggle-sold-stock"> Show/Hide Sold Stock
                            </label>
                        </div>
                    </div>
                    <div class="table-responsive col-xs-12">    
                        <table class="table table-condensed table-striped" id="group-stock-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Stock Quote">Quote</span></th>
                                    <th>Buy Rate</th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Quantity">Qty</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Last Close Price">Close Price</span></th>
                                    <th>Investment</th>
                                    <th>Market Value</th>
                                    <th>Change</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Stock Quote">Quote</span></th>
                                    <th>Buy Rate</th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Total Quantity">Qty</span></th>
                                    <th><span data-toggle="tooltip" data-placement="top" title="Last Close Price">Close Price</span></th>
                                    <th>Investment</th>
                                    <th>Market Value</th>
                                    <th>Change</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th><span data-investment>Investment</span></th>
                                    <th><span data-market-value>Market Value</span></th>
                                    <th><span data-change>Change</span></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" role="tabpanel" id="protfolio-stock-sell-group">
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
<!-- Modal -->
    <div id="modal-container"></div>
@endsection
@section('endscript')
<script type="text/html" id="add-edit-modal">
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content animated zoomIn" style="animation-duration: 250ms;">
                {!! Form::open(['route'=>['member.stock.store'], 'class'=>'form form-horizontal inModal','method'=>'post']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">@{{ title }}</h4>
                </div>
                <div class="modal-body">
                    @{{#basket}}
                        <input type="hidden" name="basket_id" value="@{{basket}}">
                    @{{/basket}}
                    @{{#method}}
                        <input type="hidden" name="_method" value="@{{method}}">
                    @{{/method}}
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="companyList" class="control-label">Company</label>
                            {!! Form::select('company',$company ,null,['class'=>'form-control','data-value'=>'@{{company}}','id'=>'companyList']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="stockTypeList" class="control-label">Type</label>
                            {!! Form::select('type',$stockTypes ,null,['class'=>'form-control','id'=>'stockTypeList','data-value'=>'@{{stock}}']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="quantity" class="control-label">Quantity (Kitta)</label>
                            {!! Form::input('number','quantity','@{{quantity}}',['class'=>'form-control','step'=>1]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="buy_rate" class="control-label">Buy Rate</label>
                            {!! Form::input('number','buy_rate','@{{buy_rate}}',['class'=>'form-control','step'=>0.01]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="commission" class="control-label">Total Commission</label>
                            {!! Form::input('number','commission','@{{commission}}',['class'=>'form-control','step'=>0.01]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="buy_date" class="control-label">Buy Date</label>
                            {!! Form::input('date','buy_date','@{{buy_date}}',['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="owner_name" class="control-label">Owner Name</label>
                            {!! Form::input('text','owner_name','@{{owner_name}}',['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="shareholder_number" class="control-label">Shareholder No.</label>
                            {!! Form::input('text','shareholder_number','@{{shareholder_number}}',['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="certificate_number" class="control-label">Certificate No.</label>
                            {!! Form::input('text','certificate_number','@{{certificate_number}}',['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <span class="clearfix"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success ajax-submit"> @{{{btnLabel}}}</button>
                </div>
                {!! Form::close()  !!}
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="stock-details-tmpl">
    <div class="nav-tabs-custom" style="margin-bottom:0">
        <ul class="nav nav-tabs">
            <li class="dropdown active">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                    Sell <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="active"><a href="#stock-sold@{{ id }}" data-toggle="tab" aria-expanded="true">View</a></li>
                    <li class=""><a href="#add-stock-sales@{{ id }}" data-toggle="tab" aria-expanded="false">Sell</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                    Details <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#stock-details@{{ id }}" data-toggle="tab" aria-expanded="false">View</a></li>
                    <li class=""><a href="#add-stock-details@{{ id }}" data-toggle="tab" aria-expanded="false">Add</a></li>
                </ul>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="stock-sold@{{ id }}">
                @{{#sell.length}}
                <table class="table table-condensed stock-sales">
                    <thead>
                    <tr>
                        <th>Sold On</th><th>Quantity</th><th>Rate</th>
                        <th>Commission</th><th>Tax</th><th>Remarks</th><th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @{{#sell}}
                    <tr>
                        <td>@{{ sell_date }}</td>
                        <td>@{{ quantity }}</td>
                        <td>@{{ sell_rate }}</td>
                        <td>@{{ commission }}</td>
                        <td>@{{ total_tax }}</td>
                        <td>@{{ note }}</td>
                        <td>
                        <div class="box-tools" data-id="@{{id}}" data-url="@{{url}}">
                            <button class="btn btn-box-tool deleteStockSales" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                        </div>
                        </td>
                    </tr>
                    @{{/sell}}
                    </tbody>
                </table>
                @{{/sell.length}}
                @{{^sell.length}}
                <div class="callout callout-info">
                    <h4>No stock sales details available.</h4>
                    <p>Click <button type="button" class="btn btn-default btn-xs" data-toggle="tab" data-target="#add-stock-sales@{{ id }}"><i class="fa fa-plus-circle"></i> Add</button> to add new stock sales details.</p>
                </div>
                @{{/sell.length}}
            </div>
            <div class="tab-pane" id="stock-details@{{ id }}">
                @{{#details.length}}
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Fiscal Year</th>
                        <th>Stock Dividend</th>
                        <th>Cash Dividend</th>
                        <th>Right Share</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @{{#details}}
                    <tr>
                        <td>@{{ fiscal_year.name }}</td>
                        <td>@{{ _stock_dividend }}</td>
                        <td>@{{ _cash_dividend }}</td>
                        <td>@{{ _right_share }}</td>
                        <td>@{{ _remarks }}</td>
                        <td>
                        <div class="box-tools" data-id="@{{id}}" data-url="@{{url}}">
                            <button class="btn btn-box-tool deleteStockDetails" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                        </div>
                        </td>
                    </tr>
                    @{{/details}}
                    </tbody>
                </table>
                @{{/details.length}}
                @{{^details.length}}
                <div class="callout callout-info">
                    <h4>No stock details available.</h4>
                    <p>Click <button type="button" class="btn btn-default btn-xs" data-toggle="tab" data-target="#add-stock-details@{{ id }}"><i class="fa fa-plus-circle"></i> Add</button> to add new details.</p>
                </div>
                @{{/details.length}}
            </div>

            <div class="tab-pane" id="add-stock-details@{{ id }}">
                <form class="form-horizontal" role="form" method="post" action="{{route('member.stock-details.store')}}" id="stock_details_form@{{ id }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="stock_id" value="@{{ id }}">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            {!! Form::label('sd-fiscal-year', 'Fiscal Year',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::select('fiscal_year',$fiscalYear,null,['class'=>'form-control','id'=>'sd-fiscal-year']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            {!! Form::label('sd-stock-dividend', 'Stock Dividend',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::input('number','stock_dividend',null,['class'=>'form-control','id'=>'sd-stock-dividend','step'=>'any']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            {!! Form::label('sd-cash-dividend', 'Cash Dividend',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::input('number','cash_dividend',null,['class'=>'form-control','id'=>'sd-cash-dividend','step'=>'any']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            {!! Form::label('sd-right-share', 'Right Share',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::input('number','right_share',null,['class'=>'form-control','id'=>'sd-right-share','step'=>'any']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            {!! Form::label('sd-remarks', 'Remarks',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::textarea('remarks',null,['class'=>'form-control','id'=>'sd-remarks','rows'=>"3"]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-primary ajax-submit pull-right" type="submit" data-target-later="#stock-sold@{{ id }}" data-toggle="tab" data-reload-dataTable="false" data-parent-form="#stock_details_form@{{ id }}" data-stock="@{{ id }}"><i class="ion-ios-plus-outline"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>    
            </div>
            
            <div class="tab-pane" id="add-stock-sales@{{ id }}">
                <form class="form-horizontal" role="form" method="post" action="{{route('member.stock.sell')}}" id="sell_stock_form@{{ id }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="stock_id" value="@{{ id }}">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            {!! Form::label('sell_quantity', 'Quantity',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::input('number','sell_quantity',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            {!! Form::label('sell_rate', 'Rate',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::input('number','sell_rate',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            {!! Form::label('sell_commission', 'Commission',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::input('number','sell_commission',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            {!! Form::label('sell_tax', 'Total Tax',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::input('number','sell_tax',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            {!! Form::label('sell-date', 'Date',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::input('date','sell_date',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            {!! Form::label('sell_note', 'Note',['class'=>'col-xs-12 control-label text-left']) !!}
                            <div class="col-lg-12">
                                {!! Form::textarea('sell_note',null,['class'=>'form-control','rows'=>'3']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-primary ajax-submit pull-right" type="submit" data-target-later="#stock-sold@{{ id }}" data-toggle="tab" data-reload-dataTable="false" data-parent-form="#sell_stock_form@{{ id }}" data-stock="@{{ id }}"><i class="ion-ios-plus-outline"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </form>
                <span class="clearfix"></span>
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="callout-tmpl">
    <div class="alert alert-@{{ type }} alert-dismissable animated flipInX">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><span aria-hidden="true">&#215;</span></button>
        <h4>@{{ heading }}</h4>
        <p>@{{{ description }}}</p>
    </div>
</script>
<script type="text/html" id="action-btns-tmpl">
    <div class="box-tools" data-url="@{{url}}" data-id="@{{id}}">
        <button class="btn btn-box-tool moreStockDetails" data-toggle="tooltip" data-placement="top" title="More Details"><i class="fa fa-plus-square"></i></button>
        <button class="btn btn-box-tool editStock" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
        <button class="btn btn-box-tool deleteStock" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
    </div>
</script>
{!! HTML::script('vendors/notify/notify.min.js') !!}
{!! HTML::script('vendors/bootbox/bootbox.min.js') !!}
{!! HTML::script('vendors/mustache/mustache.min.js') !!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script>
    var FETCH_STOCK_URL = '{{route('members.stock.fetch')}}';
    var STOCK_UPDATE_URL = '{{route('member.stock.update',':id')}}';
    var FETCH_STOCK_TYPE_URL = '{{route('members.stock.fetch')}}';
    var STOCK_SELL_UPDATE = '{{route('member.stock.sell.delete',':id')}}';
    var STOCK_DETAILS_UPDATE = '{{route('member.stock.details.delete',':id')}}';
    var FETCH_STOCK_GROUPED = '{{route('members.stock.fetch-grouped')}}';
    var FETCH_STOCK_GROUP_COMPANY = '{{route('members.stock.fetch-grouped-company')}}';
</script>
{!! HTML::script('assets/nsm/member/js/stock-group.js') !!}
@endsection