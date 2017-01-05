@extends('members.layout.master')

@section('title')Property
@endsection

@section('specificheader')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    {!! HTML::style('vendors/animate/animate.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-building"></i> Property</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-box-tool" href="{{route('member.report.property')}}"><i class="fa fa-area-chart"></i> Report</a>
                        <button class="btn btn-box-tool" id="add-property-btn" data-toggle="modal" data-target="#add-property-modal"><i class="fa fa-plus-circle"></i> Add Property</button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="table-responsive col-xs-12">
                            <table class="table table-condensed table-striped" id="property-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Asset</th>
                                        <th>Owner</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Buy Rate</th>
                                        <th>Investment</th>
                                        <th>Rate <small>(Market)</small></th>
                                        <th>Market Value</th>
                                        <th>Change</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot><tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><span id="total-invest">Total Invest</span></th>
                                    <th></th>
                                    <th><span id="market-value">Total Market Value</span></th>
                                    <th><span id="total-change">Total Change</span></th>
                                    <th></th>
                                </tr></tfoot>
                                <tbody></tbody>
                            </table>
                        </div>  
                    </div>  
                </div><!-- ./box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="add-property-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    {!! Form::open(['route'=>['member.property.store'],'class'=>'form-horizontal','id'=>'property-create-form']) !!}
    <input type="hidden" name="_method" value="post">
    <div class="modal-content animated">
      <div class="validation-error"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Property</h4>
      </div>
      <div class="modal-body">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-asset-name" class="control-label">Asset Name</label>
                {!! Form::input('text','asset_name',null,['class'=>'form-control','id'=>'p-asset-name']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-buy-quantity" class="control-label">Quantity</label>
                <input type="number" class="form-control" id="p-buy-quantity" name="quantity" step="any">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-unit" class="control-label">Unit</label>
                <input type="text" class="form-control" id="p-unit" name="unit" placeholder="eg. Ropani, Pcs">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-buy-rate" class="control-label">Buy Rate <small>(per unit)</small></label>
                <input type="number" class="form-control" id="p-buy-rate" name="buy_rate" step="any">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-buy-date" class="control-label">Buy Date</label>
                <input type="date" class="form-control" id="p-buy-date" name="buy_date">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-owner-name" class="control-label">Owner Name</label>
                <input type="text" class="form-control" id="p-owner-name" name="owner_name">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-market-rate" class="control-label">Market Rate</label>
                <input type="number" class="form-control" id="p-market-rate" name="market_rate" step="any">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-market-date" class="control-label">Market Date</label>
                <input type="date" class="form-control" id="p-market-date" name="market_date" step="any">
            </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success ajax-submit" id="add-property-form-submit"><i class="fa fa-plus-circle"></i> Add</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>

<div class="modal fade" id="edit-property-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    {!! Form::open(['route'=>['member.property.store'],'class'=>'form-horizontal','id'=>'property-edit-form']) !!}
    <input type="hidden" name="_method" value="post">
    <div class="modal-content animated">
      <div class="validation-error"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit property</h4>
      </div>
      <div class="modal-body">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-asset-name" class="control-label">Asset Name</label>
                {!! Form::input('text','asset_name',null,['class'=>'form-control','id'=>'p-asset-name']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-buy-quantity" class="control-label">Quantity</label>
                <input type="number" class="form-control" id="p-buy-quantity" name="quantity" step="any">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-unit" class="control-label">Unit</label>
                <input type="text" class="form-control" id="p-unit" name="unit" placeholder="eg. Ropani, Pcs">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-buy-rate" class="control-label">Buy Rate <small>(per unit)</small></label>
                <input type="number" class="form-control" id="p-buy-rate" name="buy_rate" step="any">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-buy-date" class="control-label">Buy Date</label>
                <input type="date" class="form-control" id="p-buy-date" name="buy_date">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-owner-name" class="control-label">Owner Name</label>
                <input type="text" class="form-control" id="p-owner-name" name="owner_name">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-market-rate" class="control-label">Market Rate</label>
                <input type="number" class="form-control" id="p-market-rate" name="market_rate" step="any">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="p-market-date" class="control-label">Market Date</label>
                <input type="date" class="form-control" id="p-market-date" name="market_date" step="any">
            </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success ajax-submit" id="edit-property-form-submit"><i class="fa fa-edit"></i> Update</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete-property-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want delete this item?</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="#" id="delete-property-form">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="_method" value="delete">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger ajax-submit"><i class="fa fa-trash"></i> Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="delete-propertySell-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want delete this item?</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="#" id="delete-propertySell-form">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="_method" value="delete">
            <input type="hidden" name="property" value="">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger ajax-submit"><i class="fa fa-trash"></i> Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('endscript')
<script type="text/html" id="validation-error-tmpl">
    <div class="alert alert-@{{ type }} alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><span aria-hidden="true">&#215;</span></button>
        <h4>@{{ heading }}</h4>
        <p>@{{{ description }}}</p>
    </div>
</script>
<script type="text/html" id="action-btns-tmpl">
    <div class="box-tools" data-id="@{{id}}" data-url="@{{url}}">
        <span data-toggle="tooltip" data-placement="top" title="Sell">
            <button class="btn btn-box-tool sellproperty" data-property-id="@{{id}}"><i class="fa fa-money"></i></button>
        </span>
        <span data-toggle="tooltip" data-placement="top" title="Edit">
            <button class="btn btn-box-tool editproperty" data-toggle="modal" data-target="#edit-property-modal"><i class="fa fa-edit"></i></button>
        </span>
        <span data-toggle="tooltip" data-placement="top" title="Delete">
            <button class="btn btn-box-tool deleteproperty" data-toggle="modal" data-target="#delete-property-modal"><i class="fa fa-trash"></i></button>
        </span>
    </div>
</script>
<script type="text/html" id="property-details-tmpl">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#property-sold@{{ id }}" data-toggle="tab" aria-expanded="true">View</a></li>
                <li class=""><a href="#add-property-sales@{{ id }}" data-toggle="tab" aria-expanded="false">Sell</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="property-sold@{{ id }}">
                    @{{#sell.length}}
                    <table class="table table-condensed stock-sales">
                        <thead>
                        <tr>
                            <th>Sold On</th><th>Quantity</th><th>Rate</th>
                            <th>Investment</th><th>Sell Amount</th>
                            <th>Profit/Loss</th><th>Remarks</th><th>Action</th>
                        </tr>
                        </thead>
                        <tfoot><tr><th>Total</th><th></th><th></th>
                        <th>@{{_sellInvest}}</th><th>@{{_sellAmount}}</th>
                        <th data-change="@{{dataChange}}">@{{_sellProfit}} <small>(@{{_changePercent}}%)</small></th><th></th><th></th></tr></tfoot>
                        <tbody>
                        @{{#sell}}
                        <tr>
                            <td>@{{ _sell_date }}</td>
                            <td>@{{ sell_quantity }}</td>
                            <td>@{{ _sell_rate }}</td>
                            <td>@{{ _investment }}</td>
                            <td>@{{ _value }}</td>
                            <td data-change="@{{_dataChange}}">@{{_change}} <small>(@{{_change_percent}}%)</small></td>
                            <td>@{{ _remarks }}</td>
                            <td>
                                <div class="box-tools" data-id=@{{id}} data-url="@{{url}}" data-property-id=@{{property_id}}>
                                    <span data-toggle="tooltip" data-placement="top" title="Delete">
                                        <button class="btn btn-box-tool deletePropertySells" data-toggle="modal" data-target="#delete-propertySell-modal"><i class="fa fa-trash"></i></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @{{/sell}}
                        </tbody>
                    </table>
                    @{{/sell.length}}
                    @{{^sell.length}}
                    <div class="callout callout-info">
                        <h4>No property sales details available.</h4>
                        <p>Click <button type="button" class="btn btn-default btn-xs" data-target="#add-property-sales@{{ id }}"><i class="fa fa-plus-circle"></i> Add</button> to add new property sales record.</p>
                    </div>
                    @{{/sell.length}}
                </div>
                <div class="tab-pane" id="add-property-sales@{{ id }}">
                    <form class="form-horizontal" role="form" method="post" action="{{route('member.property-sell.store')}}" id="sell_property_form@{{ id }}">
                        <div class="validation-error"></div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="property_id" value="@{{ id }}">
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
                                {!! Form::label('sell_quantity', 'Quantity',['class'=>'col-xs-12 control-label text-left']) !!}
                                <div class="col-lg-12">
                                    {!! Form::input('number','sell_quantity',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="sell_rate" class="col-xs-12 control-label text-left">Sell Rate <small>(Per Unit)</small></label>
                                <div class="col-lg-12">
                                    {!! Form::input('number','sell_rate',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                {!! Form::label('sell_remarke', 'Remarks',['class'=>'col-xs-12 control-label text-left']) !!}
                                <div class="col-lg-12">
                                    {!! Form::textarea('sell_remarks',null,['class'=>'form-control','rows'=>'3']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="btn btn-primary ajax-submit pull-right noModal" type="submit" data-target-later="#stock-sold@{{ id }}" data-parent-form="#sell_property_form@{{ id }}" data-stock="@{{ id }}"><i class="fa fa-plus-circle"></i> Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <span class="clearfix"></span>
                </div>
            </div>
        </div>
</script>

{!! HTML::script('vendors/notify/notify.min.js') !!}
{!! HTML::script('vendors/mustache/mustache.min.js') !!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var PROPERTY_FETCH = "{{route('member.property.fetch')}}";
    var PROPERTY_CREATE_FORM = $('#property-create-form').html();
    var TABLE;
    var detailRows = [];

    var dtSettings = {
        processing: true,
        paging: false,
        serverSide: true,
        dom: '<".row"<"col-xs-6"<"#prop-toggle-row.pull-left">> <".col-xs-6"<"pull-right"f>>><".row"<".col-xs-12"tr>><".row"<".col-xs-12"ip>>',
        ajax: {
            url: PROPERTY_FETCH,
            type: 'POST',
            data: {show_sold:function(){
                return $(document).find('#toggle-sold-property').is(':checked') ? 1 : 0;
            }}
        },
        columns: [
            {data: 'buy_date',name:'buy_date',render:function(data){
                return moment(data).format('D MMM YY');
            }},
            {data: 'asset_name',name:'asset_name'},
            {data: 'owner',name:'owner'},
            {data: 'quantityLeft',name:'quantityLeft'},
            {data: 'unit',name:'unit'},
            {data: 'rate',name:'rate',render:function(data){ return floatParse(data) }},
            {data: 'investment',name:'investment',render:function(data){ return floatParse(data) }},
            {data: 'market_rate',name:'market_rate',render:function(data,type,row,meta){
                if(data = null){ return '--';}

                this.market = floatParse(row.market_rate);
                if(row.market_date != null){ this.market += '  <small>('+moment(row.market_date).format('D MMM YY')+')</small>';}
                return this.market;                
            }},
            {data: 'market_value',name:'market_value',render:function(data){ return (data == null) ? '--' : floatParse(data); }},
            {data: 'change',name:'change',render:function(data,type,row,meta){
                if(data == null) return '--';
                return percentify(data,row.investment);
            }},
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           'id',
                "render": function(id,type,row,meta){
                    var data = {id:row.id,url:row.url};
                    return Mustache.to_html($('#action-btns-tmpl').html(),data);
                }
            }
        ],
        footerCallback: function ( row, data, start, end, display) {
            var self = this;
            this.totalInvest = 0;
            this.marketValue = 0;
            this.change = 0;
            $.each(data,function(i,row){
                self.totalInvest += row.investment;
                self.marketValue += row.market_value || 0;
                self.change += row.change || 0;
            });

            this.percent = (self.change != 0) ? (self.marketValue - self.totalInvest)*100/self.totalInvest : 0;
            // Update footer
            $("#total-invest").text(floatParse(self.totalInvest));
            $("#market-value").text(floatParse(self.marketValue));
            $("#total-change").html(percentify(self.change,self.totalInvest));
        },
    };

    $(document).on('click','.deletePropertySells',function(){
        this.url = $(this).closest('.box-tools').data('url');
        this.id = $(this).closest('.box-tools').data('property-id');
        $('#delete-propertySell-form').attr('action',this.url);
        $('#delete-propertySell-form').find('input[name=property]').val(this.id);
    });

    $(document).on('click','button[data-target*=#add-property-sales]',function(){
        this.target = $(this).data('target');
        $(document).find('a[href='+this.target+']').click();
    });

    $(document).on( 'click', 'tr td.details-control .sellproperty', function () {
        var tr = $(this).closest('tr');
        var row = TABLE.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();

            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );

    function format ( data ) {
        data.dataChange = getDataChange(data.sellProfit);

        $.each(data.sell,function(i,v){
            v._dataChange = getDataChange(v.change);
            v._sell_rate = floatParse(v.sell_rate);
            v._investment = floatParse(v.investment);
            v._value = floatParse(v.value);
            v._change = floatParse(v.change);
            v._change_percent = floatParse(v.change_percent);
            v._sell_date = moment(v.sell_date).format('D MMM YY');
            v._remarks = v.remarks || '-';
        });

        data._sellAmount = floatParse(data.sellAmount);
        data._sellInvest = floatParse(data.sellInvest);
        data._sellProfit = floatParse(data.sellProfit);
        data._changePercent = floatParse(data.sellProfit * 100 / data.sellInvest) ;


        return Mustache.to_html($('#property-details-tmpl').html(), data);
    }

    $(document).ready(function(){
        TABLE = $('#property-table').DataTable(dtSettings);
        $(document).on('click','.details-control>.box-tools button',function(){
            var self = this;
            this.parent = $(this).closest('.box-tools');
            this.url = $(this.parent).data('url');
            this.id = $(this.parent).data('id');

            if($(this).hasClass('editproperty')){
                this.data = false;
                $.each(TABLE.ajax.json().data,function(i,row){
                    if(row.id == self.id){
                        self.data = row;
                    }
                });

                if(this.data == false) return;

                renderEditFrom(this.data);

            }else if($(this).hasClass('deleteproperty')){
                $('#delete-property-form').attr('action',this.url);
            }
        });

        $(document).find('#prop-toggle-row').html('<div class="checkbox"> <label> <input type="checkbox" id="toggle-sold-property"> Show/Hide Sold Property </label> </div>');
        $(document).on('change','#toggle-sold-property', function(){
            TABLE.ajax.reload();
        });
    });

    $('button[data-dismiss=modal]').click(function(){
        var modal = $(this).closest('.modal');
        modal.find('.validation-error').html('');
    });

    $(document).on('click','.ajax-submit',function (e) {
        e.preventDefault();
        var self = this;

        self.toggleClass = 'fa-spinner fa-pulse ';
        $.each($(self).children('.fa').attr('class').split(' '),function(i,v){ if(v != 'fa'){self.toggleClass += v; }});
        toggleSubmit($(self),self.toggleClass);

        self.form = $(self).closest('form');

        postForm(this.form,function(response,status,statusText){
            var post = this;
            toggleSubmit($(self),self.toggleClass);

            this.notify = function(error,message,notifyType){
                if(error === false){
                    $.notify({icon:'fa fa-bell',title: 'Success',message: message},NOTIFY_CONFIG).update('type','pastel-success');      
                }else{
                    this.type = (typeof notifyType == 'undefined') ? 'pastel-warning' : notifyType;
                    $.notify({icon:'fa fa-warning',title: 'Warning', message: message},NOTIFY_CONFIG).update('type',this.type);
                }
            };

            this.animate = function(target,animate,remove,duration){
                this.duration = (typeof duration != 'undefined') ? duration : 300;

                $(target).addClass(animate).css({'animation-duration':this.duration+'ms'});

                if(typeof remove != 'undefined' && remove === true){
                    setTimeout(function(){
                        $(target).removeClass(animate);
                    },this.duration);
                }
                
            };

            this.serverValidation = function(target,message){
                this.template = $('#validation-error-tmpl');
                Mustache.parse(this.template.html())
                var html = '<ul>';
                $.each(message,function(i,v){
                    html += '<li>'+v+'</li>';
                });

                html += '</ul>';
                this.data = {heading:'Validation Error',type:'warning',description:html};

                $(target).html(Mustache.render(this.template.html(),this.data));
            }; 

            this.error = function(response){
                if(response.status == 500){
                    post.notify(true,'There was an <strong>Internal Server Error</strong> while creating property portfolio.','pastel-danger');
                }else if(response.status == 422){
                    var $target = $(self).hasClass('noModal') ? $(self.form) : $(self.form).find('.modal-content');
                    post.animate($target,'shake',true,350);
                    post.serverValidation($($target).find('.validation-error'),JSON.parse(response.responseText));
                }
            };

            this.reset = function (form,html) {
                var a = this;
                TABLE.ajax.reload();
                this.isResetable = false;
                $($(form).attr('id').split('-'),function(i,v){
                    if(v == 'delete') a.isResetable = true;
                });

                if(this.isResetable) return;
                $(form).find('input[name=owner_name]').val('');
                $(form).find('select[name=type] option').each(function(i,option){
                    if($(option).attr('value') == data.type_id){
                        $(option).prop('selected',false);
                    }
                });
                $(form).find('input[name=buy_date]').val('');
                $(form).find('input[name=buy_rate]').val('');
                $(form).find('input[name=quantity]').val('');
            }

            this.success = function(form){
                $(form).find('button[data-dismiss=modal]').click();
                post.reset(form,PROPERTY_CREATE_FORM);
            }

            switch(status){
                case 'success':
                    this.notify(response.error,response.message);
                    if(response.error === false) post.success(self.form);
                    break;
                default:
                    this.error(response);
                    break;
            }
        });
    });

    function rerenderForm(data){
        var $modal = $('#add-property-modal');
        $modal.find('form').attr('action',data.url);
        $modal.find('input[name=_method]').val('put');
        $modal.find('select[name=type] option').each(function(i,option){
            if($(option).attr('value') == data.type_id){
                $(option).prop('selected',true);
            }
        });
        $modal.find('input[name=buy_date]').val(data.buy_date);
        $modal.find('input[name=buy_rate]').val(data.buy_rate);
        $modal.find('input[name=quantity]').val(data.quantity);
    }

    function renderEditFrom(data){
        var $form = $('#property-edit-form');
        $form.attr('action',data.url);
        $form.find('input[name=_method]').val('put');
        $form.find('input[name=asset_name]').val(data.asset_name);
        $form.find('input[name=unit]').val(data.unit);
        $form.find('input[name=buy_date]').val(data.buy_date);
        $form.find('input[name=buy_rate]').val(data.rate);
        $form.find('input[name=quantity]').val(data.quantity);
        $form.find('input[name=owner_name]').val(data.owner);
        $form.find('input[name=market_rate]').val(data.market_rate);
        $form.find('input[name=market_date]').val(data.market_date);
    }

    function toggleSubmit($btn,toggleClass){
        $btn.prop('disabled',!$btn.is(':disabled'));
        $btn.find('.fa').toggleClass(toggleClass);
    }

    function postForm(form,callback){
        this.url = $(form).attr('action');
        this.data = $(form).serialize();
        $.post(this.url,this.data).always(function(response,status,statusText){
            if(typeof callback != 'undefined') callback(response,status,statusText);
        });
    }
    
</script>
@endsection