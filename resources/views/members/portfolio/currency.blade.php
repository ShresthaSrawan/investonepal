@extends('members.layout.master')

@section('title')Currency
@endsection

@section('specificheader')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    {!! HTML::style('vendors/animate/animate.css') !!}
@endsection

@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-money"></i> Currency</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-box-tool" href="{{route('member.report.currency')}}"><i class="fa fa-area-chart"></i> Report</a>
            <button class="btn btn-box-tool" id="add-currency-btn" data-toggle="modal" data-target="#add-currency-modal"><i class="fa fa-plus-circle"></i> Add Currency</button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="row">
			<div class="table-responsive col-xs-12">
                <table class="table table-condensed table-striped" id="currency-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Buy Rate</th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Quantity">Qty</span></th>
                            <th>Investment</th>
                            <th>Market Rate <small>(Sell)</small></th>
                            <th>Market Value</th>
                            <th>Change</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Buy Rate</th>
                        <th><span data-toggle="tooltip" data-placement="top" title="Quantity">Qty</span></th>
                        <th>Investment</th>
                        <th>Market Rate <small>(Sell)</small></th>
                        <th>Market Value</th>
                        <th>Change</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <th colspan="4">Total</th>
                        <th><span id="total-invest">Total Invest</span></th>
                        <th></th>
                        <th><span id="market-value">Total Market Value</span></th>
                        <th><span id="total-change">Total Change</span></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div><!-- ./box-body -->
</div><!-- /.box -->
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="add-currency-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    {!! Form::open(['route'=>['member.currency.store'],'class'=>'form-horizontal','id'=>'currency-create-form']) !!}
    <input type="hidden" name="_method" value="post">
    <div class="modal-content animated">
      <div class="validation-error"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add currency</h4>
      </div>
      <div class="modal-body">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="b-type" class="control-label">currency Type</label>
                {!! Form::select('type',$currency,null,['class'=>'form-control','id'=>'b-type']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="b-buy-date" class="control-label">Buy Date</label>
                <input type="date" class="form-control" id="b-buy-date" name="buy_date">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="b-buy-quantity" class="control-label">Quantity</label>
                <input type="number" class="form-control" id="b-buy-quantity" name="quantity" step="1">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="b-total-amount" class="control-label">Total Amount</label>
                <input type="number" class="form-control" id="b-total-amount" name="total_amount" step="any">
            </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success ajax-submit" id="add-currency-form-submit"><i class="fa fa-plus-circle"></i> Add</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>

<div class="modal fade" id="edit-currency-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    {!! Form::open(['route'=>['member.currency.store'],'class'=>'form-horizontal','id'=>'currency-edit-form']) !!}
    <input type="hidden" name="_method" value="post">
    <div class="modal-content animated">
      <div class="validation-error"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit currency</h4>
      </div>
      <div class="modal-body">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="b-type" class="control-label">Currency Type</label>
                {!! Form::select('type',$currency,null,['class'=>'form-control','id'=>'b-type']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="b-buy-date" class="control-label">Buy Date</label>
                <input type="date" class="form-control" id="b-buy-date" name="buy_date">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="b-buy-quantity" class="control-label">Quantity</label>
                <input type="number" class="form-control" id="b-buy-quantity" name="quantity" step="1">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="b-total-amount" class="control-label">Total Amount</label>
                <input type="number" class="form-control" id="b-total-amount" name="total_amount" step="any">
            </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success ajax-submit" id="edit-currency-form-submit"><i class="fa fa-edit"></i> Update</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete-currency-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
        <form method="post" action="#" id="delete-currency-form">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="_method" value="delete">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger ajax-submit"><i class="fa fa-trash"></i> Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="delete-currencySell-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
        <form method="post" action="#" id="delete-currencySell-form">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="_method" value="delete">
            <input type="hidden" name="currency" value="">
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
            <button class="btn btn-box-tool sellcurrency" data-currency-id="@{{id}}"><i class="fa fa-money"></i></button>
        </span>
        <span data-toggle="tooltip" data-placement="top" title="Edit">
            <button class="btn btn-box-tool editcurrency" data-toggle="modal" data-target="#edit-currency-modal"><i class="fa fa-edit"></i></button>
        </span>
        <span data-toggle="tooltip" data-placement="top" title="Delete">
            <button class="btn btn-box-tool deletecurrency" data-toggle="modal" data-target="#delete-currency-modal"><i class="fa fa-trash"></i></button>
        </span>
    </div>
</script>
<script type="text/html" id="currency-details-tmpl">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#currency-sold@{{ id }}" data-toggle="tab" aria-expanded="true">View</a></li>
                <li class=""><a href="#add-currency-sales@{{ id }}" data-toggle="tab" aria-expanded="false">Sell</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="currency-sold@{{ id }}">
                    @{{#sell.length}}
                    <table class="table table-condensed stock-sales">
                        <thead><tr><th>Sell Date</th><th>Quantity <small>(gms.)</small></th><th>Sell Rate</th><th>Sell Value</th><th>Investment</th><th>Remarks</th><th>Change</th><th>Action</th></tr></thead>
                        <tfoot><tr><th>Total</th><th></th><th></th><th>@{{totalSell}}</th><th>@{{totalInvest}}</th><th></th><th>@{{& _sellProfit}}</th><th></th></tr></tfoot>
                        <tbody>
                        @{{#sell}}
                        <tr>
                            <td>@{{ date }}</td>
                            <td>@{{ quantity }}</td>
                            <td>@{{ sRate }}</td>
                            <td>@{{ _sell_amount }}</td>
                            <td>@{{ _investment }}</td>
                            <td>@{{ _remarks }}</td>
                            <td>@{{& _dataChange }}</td>
                            <td>
                                <div class="box-tools" data-id=@{{id}} data-url="@{{url}}" data-currency-id=@{{buy_id}}>
                                    <span data-toggle="tooltip" data-placement="top" title="Delete">
                                        <button class="btn btn-box-tool deletecurrencySells" data-toggle="modal" data-target="#delete-currencySell-modal"><i class="fa fa-trash"></i></button>
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
                        <h4>No currency sales details available.</h4>
                        <p>Click <button type="button" class="btn btn-default btn-xs" data-target="#add-currency-sales@{{ id }}"><i class="fa fa-plus-circle"></i> Add</button> to add new currency sales record.</p>
                    </div>
                    @{{/sell.length}}
                </div>
                <div class="tab-pane" id="add-currency-sales@{{ id }}">
                    <form class="form-horizontal" role="form" method="post" action="{{route('member.currency-sell.store')}}" id="sell_currency_form@{{ id }}">
                        <div class="validation-error"></div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="buy_id" value="@{{ id }}">
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
                                <label for="sell_amount" class="col-xs-12 control-label text-left">Sell Amount <small>(NRP.)</small></label>
                                <div class="col-lg-12">
                                    {!! Form::input('number','sell_amount',null,['class'=>'form-control']) !!}
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
                                    <button class="btn btn-primary ajax-submit pull-right noModal" type="submit" data-target-later="#stock-sold@{{ id }}" data-parent-form="#sell_currency_form@{{ id }}" data-stock="@{{ id }}"><i class="fa fa-plus-circle"></i> Add</button>
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
    var currency_FETCH = "{{route('member.currency.fetch')}}";
    var currency_CREATE_FORM = $('#currency-create-form').html();
    var TABLE;
    var detailRows = [];

    var dtSettings = {
        processing: true,
        paging: false,
        serverSide: true,
        dom: '<".row"<"col-xs-6"<"#prop-toggle-row.pull-left">> <".col-xs-6"<"pull-right"f>>><".row"<".col-xs-12"tr>><".row"<".col-xs-12"ip>>',
        ajax: {
            url: currency_FETCH,
            type: 'POST',
            data: {show_sold:function(){
                return $(document).find('#toggle-sold-currency').is(':checked') ? 1 : 0;
            }}
        },
        columns: [
            {data: 'buy_date',name:'buy_date',render:function(data){
                return moment(data).format('D MMM YY');
            }},
            {data: 'currency_name',name:'currency_name', render: function (data,type,row) {
                var target = data.toLowerCase().split(' ');
                return '<a href="/currency/'+target[0].replace('$','')+'" target="_blank">'+data+'</a>';
            }},
            {data: 'buy_rate',name:'buy_rate',render:function(data,type,row){
                return floatParse(row.total_amount/row.quantity);
            }},
            {data: 'quantity',name:'quantity',render:function(data, type, row){
                return row.remaining_quantity;
            }},
            {data: 'investment',name:'investment',render:function(data){
                return floatParse(data);
            }},
            {data: 'last_sell',name:'last_sell',render:function(data,type,row,meta){
                return floatParse(data)+'  <small>('+moment(row.last_date).format('D MMM')+')</small>';
            }},
            {data: 'market_value',name:'market_value',render:function(data){ return floatParse(data); }},
            {data: 'change',name:'change',render:function(data,type,row,meta){
                return floatParse(data.amount)+'  <small>('+parseFloat(data.percent).toFixed(2)+'%)</small>';
            },orderable:false,searchable:false},
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
                self.marketValue += row.market_value;
                self.change += row.change.amount;
            });
            // Update footer
            $("#total-invest").text(floatParse(self.totalInvest));
            $("#market-value").text(floatParse(self.marketValue));
            $("#total-change").html(percentify(self.change,self.totalInvest));
        }
    };



    $(document).on('click','.deletecurrencySells',function(){
        this.url = $(this).closest('.box-tools').data('url');
        this.id = $(this).closest('.box-tools').data('currency-id');
        $('#delete-currencySell-form').attr('action',this.url);
        $('#delete-currencySell-form').find('input[name=currency]').val(this.id);
    });

    $(document).on('click','button[data-target*=#add-currency-sales]',function(e){
        this.target = $(this).data('target');
        $(document).find('a[href='+this.target+']').click();
    });

    $(document).on( 'click', 'tr td.details-control .sellcurrency', function () {
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
        data.totalInvest = data.totalSell = 0;
        $.each(data.sell,function(i,v){
            v._remarks = v.remarks || '-';
            data.totalInvest += v.investment = v.quantity * data.buy_rate;
            data.totalSell += v.sell_amount;
            v._investment = floatParse(v.investment);
            v._sell_amount = floatParse(v.sell_amount);
            v._dataChange = percentify(v.profit_loss,v.investment);
        });
        data.totalInvest = floatParse(data.totalInvest);
        data.totalSell = floatParse(data.totalSell);
        data._sellProfit = percentify(data.sellProfit,data.sellInvestment);

        return Mustache.to_html($('#currency-details-tmpl').html(), data);
    }

    $(document).ready(function(){
        TABLE = $('#currency-table').DataTable(dtSettings);
        $(document).find('#prop-toggle-row').html('<div class="checkbox"> <label> <input type="checkbox" id="toggle-sold-currency"> Show/Hide Sold Currency</label> </div>');
        $(document).on('change','#toggle-sold-currency', function(){
            TABLE.ajax.reload();
        });
        $(document).on('click','.details-control>.box-tools button',function(){
            var self = this;
            this.parent = $(this).closest('.box-tools');
            this.url = $(this.parent).data('url');
            this.id = $(this.parent).data('id');

            if($(this).hasClass('editcurrency')){
                this.data = false;
                $.each(TABLE.ajax.json().data,function(i,row){
                    if(row.id == self.id){
                        self.data = row;
                    }
                });

                if(this.data == false) return;

                renderEditFrom(this.data);

            }else if($(this).hasClass('deletecurrency')){
                $('#delete-currency-form').attr('action',this.url);
            }
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
                    post.notify(true,'There was an <strong>Internal Server Error</strong> while creating currency portfolio.','pastel-danger');
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
                $(form).find('input[name=total_amount]').val('');
                $(form).find('input[name=quantity]').val('');
            }

            this.success = function(form){
                $(form).find('button[data-dismiss=modal]').click();
                post.reset(form,currency_CREATE_FORM);
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
        var $modal = $('#add-currency-modal');
        $modal.find('form').attr('action',data.url);
        $modal.find('input[name=_method]').val('put');
        $modal.find('select[name=type] option').each(function(i,option){
            if($(option).attr('value') == data.type_id){
                $(option).prop('selected',true);
            }
        });
        $modal.find('input[name=buy_date]').val(data.buy_date);
        $modal.find('input[name=total_amount]').val(data.total_amount);
        $modal.find('input[name=quantity]').val(data.quantity);
    }

    function renderEditFrom(data){
        var $form = $('#currency-edit-form');
        $form.attr('action',data.url);
        $form.find('input[name=_method]').val('put');
        $form.find('select[name=type] option').each(function(i,option){
            if($(option).attr('value') == data.type_id){
                $(option).prop('selected',true);
            }
        });
        $form.find('input[name=buy_date]').val(data.buy_date);
        $form.find('input[name=total_amount]').val(data.total_amount);
        $form.find('input[name=quantity]').val(data.quantity);
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