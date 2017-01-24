@extends('members.layout.master')

@section('title')Stock
@endsection

@section('modal')
    <div id="modal-container"></div>
@endsection

@section('content')
<style type="text/css">
  .description-block > span {display: block;}
  .description-block > .description-text {font-weight: 600;}
</style>
<ul class="nav nav-tabs hide">
  <li class="active"><a href="#grouped-view" data-toggle="tab" aria-expanded="true"></a></li>
  <li><a href="#buy-view" data-toggle="tab" aria-expanded="false"></a></li>
  <li><a href="#sell-view" data-toggle="tab" aria-expanded="false"></a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="grouped-view">
    @include('members.portfolio.tables.stock.grouped')
  </div>
  <div class="tab-pane" id="buy-view">
    @include('members.portfolio.tables.stock.buy')
  </div>
  <div class="tab-pane" id="sell-view">
    @include('members.portfolio.tables.stock.sell')
  </div>
</div>

@endsection

@section('specificheader')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    {!! HTML::style('vendors/animate/animate.css') !!}
    {!! HTML::style('vendors/chosen/chosen.min.css') !!}
    <style type="text/css">
        .chosen-container-single > .chosen-single{
            background: #fff;
            line-height: 26px;
            height: 28px;
        }
    </style>
@endsection

@section('endscript')
    <script type="text/html" id="stock-buy-create-update-modal-tmpl">
        <div class="modal animated fadeIn" tabindex="-1" role="dialog" style="animation-duration: 300ms;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    {!! Form::open(['route'=>['member.stock.store'], 'class'=>'form form-horizontal','method'=>'post']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@{{ title }}</h4>
                    </div>
                    <div class="form-errors"></div>
                    <div class="modal-body" style="padding-top: 0">
                        @{{#basket}}
                            <input type="hidden" name="basket_id" value="@{{basket}}">
                        @{{/basket}}
                        @{{#method}}
                            <input type="hidden" name="_method" value="@{{method}}">
                        @{{/method}}
                        <div class="col-xs-12">
                            <label for="companyList" class="control-label">Company</label>
                            {!! Form::select('company',$company ,null,['class'=>'form-control','id'=>'companyList']) !!}
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="stockTypeList" class="control-label">Type</label>
                            {!! Form::select('type',$stockTypes , null, [ 'class'=>'form-control', 'id'=>'stockTypeList']) !!}
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="quantity" class="control-label">Quantity (Kitta)</label>
                            {!! Form::input('number','quantity','@{{quantity}}',['class'=>'form-control','step'=>1]) !!}
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="buy_rate" class="control-label">Buy Rate</label>
                            {!! Form::input('number','buy_rate','@{{buy_rate}}',['class'=>'form-control','step'=>0.01]) !!}
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="commission" class="control-label">Total Commission</label>
                            {!! Form::input('number','commission','@{{commission}}',['class'=>'form-control','step'=>0.01]) !!}
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="buy_date" class="control-label">Buy Date</label>
                            <div class='input-group date'>
                                {!! Form::input('date','buy_date','@{{buy_date}}',['class'=>'form-control']) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="owner_name" class="control-label">Owner Name</label>
                            {!! Form::input('text','owner_name','@{{owner_name}}',['class'=>'form-control']) !!}
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="shareholder_number" class="control-label">DP Company</label>
                            {!! Form::input('text','shareholder_number','@{{shareholder_number}}',['class'=>'form-control']) !!}
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="certificate_number" class="control-label">Demat ID</label>
                            {!! Form::input('text','certificate_number','@{{certificate_number}}',['class'=>'form-control']) !!}
                        </div>
                        <span class="clearfix"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"> @{{{btnLabel}}}</button>
                    </div>
                    {!! Form::close()  !!}
                </div>
            </div>
        </div>
    </script>

    <script type="text/html" id="stock-sell-create-update-modal-tmpl">
        <div class="modal animated fadeIn" tabindex="-1" role="dialog" style="animation-duration: 300ms;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    {!! Form::open(['route'=>['member.stock.sell'], 'class'=>'form form-horizontal','method'=>'post']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@{{ title }}</h4>
                    </div>
                    <div class="form-errors"></div>
                    <div class="modal-body" style="padding-top: 0">
                        @{{#stock_id}}
                            <input type="hidden" name="stock_id" value="@{{stock_id}}">
                        @{{/stock_id}}
                        @{{#basket_id}}
                            <input type="hidden" name="basket_id" value="@{{basket_id}}">
                        @{{/basket_id}}
                        @{{#method}}
                            <input type="hidden" name="_method" value="@{{method}}">
                        @{{/method}}
                        <div class="col-xs-12">
                            <label for="sell_date" class="control-label">Sell Date</label>
                            <div class='input-group date'>
                                {!! Form::input('date','sell_date','@{{sell_date}}',['class'=>'form-control']) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="sell_quantity" class="control-label">Quantity</label>
                            {!! Form::input('number','sell_quantity','@{{sell_quantity}}',['class'=>'form-control']) !!}
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="sell_rate" class="control-label">Sell Rate</label>
                            {!! Form::input('number','sell_rate','@{{sell_rate}}',['class'=>'form-control']) !!}
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="sell_commission" class="control-label">Commission</label>
                            {!! Form::input('number','sell_commission','@{{sell_commission}}',['class'=>'form-control']) !!}
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="sell_tax" class="control-label">Tax</label>
                            {!! Form::input('number','sell_tax','@{{sell_tax}}',['class'=>'form-control']) !!}
                        </div>
                        <div class="col-xs-12">
                            <label for="sell_note" class="control-label">Remarks</label>
                            {!! Form::textarea('sell_note','@{{sell_note}}',['class'=>'form-control','rows'=>'3']) !!}
                        </div>
                        <span class="clearfix"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"> @{{{btnLabel}}}</button>
                    </div>
                    {!! Form::close()  !!}
                </div>
            </div>
        </div>
    </script>

    <script type="text/html" id="delete-modal-tmpl">
        <div class="modal animated fadeIn" tabindex="-1" role="dialog" style="animation-duration: 300ms;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['class'=>'form form-horizontal','method'=>'delete']) !!}
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">@{{ title }}</h4>
                    </div>
                    <div class="form-errors"></div>
                    <div class="modal-body" style="padding-top: 0">
                        <p class="text-red">Are you sure want to delete this resource ?</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success"> @{{{btnLabel}}}</button>
                    </div>
                    {!! Form::close()  !!}
                </div>
            </div>
        </div>
    </script>

    <script type="text/html" id="callout-tmpl">
        <div class="alert alert-@{{ type }} alert-dismissable animated" style="animation-duration: 300ms; margin-bottom: 0">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><span aria-hidden="true">&#215;</span></button>
            @{{#heading}}
                <h4>@{{ heading }}</h4>
            @{{/heading}}
            @{{{ description }}}
        </div>
    </script>

    {!! HTML::script('vendors/notify/notify.min.js') !!}
    {!! HTML::script('vendors/bootbox/bootbox.min.js') !!}
    {!! HTML::script('vendors/mustache/mustache.min.js') !!}
    {!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
    {!! HTML::script('vendors/notify/notify.min.js') !!}
    {!! HTML::script('vendors/bootbox/bootbox.min.js') !!}
    {!! HTML::script('vendors/mustache/mustache.min.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script>
        window.routes = {
            stock: {
              buy: '{{route("member.stock.store")}}',
              sell: '{{route("member.stock.sell")}}',
              details: '{{route("member.stock-details.store")}}',
            },
            del: {
              buy: '{{route("member.stock.destroy",":id")}}',
              sell: '{{route("member.stock.sell.delete",":id")}}',
              details: '{{route("member.stock-details.destroy",":id")}}',
            }
        };
        
        $(document).ready(function() {
            $(".chosen-select").chosen();
        });
    </script>
    {!! HTML::script('assets/nsm/member/portfolio/stock.js') !!}
@endsection