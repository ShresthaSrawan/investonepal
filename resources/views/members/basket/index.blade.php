@extends('members.layout.master')

@section('title')Stock Baskets
@endsection

@section('specificheader')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    {!! HTML::style('vendors/animate/animate.css') !!}
@endsection
@section('content')
<div class="hide" id="stockApp">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Stock Baskets</h3>
                    <div class="box-tools pull-right">
                        <div class="btn-group">
                            <button class="btn btn-box-tool" data-toggle="modal" data-target="#addStockModal"><i class="fa fa-plus-circle"></i> Add Stock</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div v-for="message in messages" class="alert alert-@{{message.type}} alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong><i class="fa @{{message.icon}}"></i></strong>@{{message.text}}</div>
                    <div id="add-basket">
                        <div class="col-xs-8 col-xs-offset-2">
                            {!! Form::open(['route'=>['member.basket.store'],'class'=>'form-horizontal']) !!}
                            <div class="form-group">
                                <label for="basket_name" class="control-label">Enter Basket Name</label>
                                <div class="input-group">
                                    <input type="text" name="basket_name" class="form-control">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add</button>
                                    </div>
                                </div>
                                @if($errors->has('basket_name'))
                                    <p class="text-danger">{{$errors->first('basket_name')}}</p>
                                @endif
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive col-xs-12">
                            <table class="table table-hover table-condensed" style="width: 100%;" id="baskets-table">
                                <thead>
                                <tr>
                                    <th>Sn</th>
                                    <th>Basket Name</th>
                                    <th>Investment</th>
                                    <th>Market Value</th>
                                    <th>Profit/Loss</th>
                                    <th>Percentage (%)</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th id="totInv"></th>
                                    <th id="totVal"></th>
                                    <th id="totChange"></th>
                                    <th></th>
                                    <th></th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="addStockModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route'=>['member.stock.store'], 'class'=>'form form-horizontal','method'=>'post','@submit.prevent'=>'submit()']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Stock</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        <div class="form-group @{{hasError('basket_id') ? 'has-error' : ''}}">
                            <label for="basketList" class="control-label">Basket</label>
                            {!! Form::select('basket_id',$basket ,null,['class'=>'form-control','v-model'=>'stock.basket_id','id'=>'basketList']) !!}
                            <p v-if="hasError('basket_id')"class="help-block">@{{getError('basket_id')}}</p>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group @{{hasError('company') ? 'has-error' : ''}}">
                            <label for="companyList" class="control-label">Company</label>
                            {!! Form::select('company',$company ,null,['class'=>'form-control','v-model'=>'stock.company','id'=>'companyList']) !!}
                            <p v-if="hasError('company')"class="help-block">@{{getError('company')}}</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group @{{hasError('type') ? 'has-error' : ''}}">
                            <label for="stockTypeList" class="control-label">Type</label>
                            {!! Form::select('type',$stockTypes ,null,['class'=>'form-control','id'=>'stockTypeList','v-model'=>'stock.type']) !!}
                            <p v-if="hasError('type')"class="help-block">@{{getError('type')}}</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group @{{hasError('quantity') ? 'has-error' : ''}}">
                            <label for="quantity" class="control-label">Quantity (Kitta)</label>
                            {!! Form::input('number','quantity',null,['class'=>'form-control','step'=>1,'v-model'=>'stock.quantity']) !!}
                            <p v-if="hasError('quantity')"class="help-block">@{{getError('quantity')}}</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group @{{hasError('buy_rate') ? 'has-error' : ''}}">
                            <label for="buy_rate" class="control-label">Buy Rate</label>
                            {!! Form::input('number','buy_rate',null,['class'=>'form-control','step'=>0.01,'v-model'=>'stock.buy_rate']) !!}
                            <p v-if="hasError('buy_rate')"class="help-block">@{{getError('buy_rate')}}</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group @{{hasError('commission') ? 'has-error' : ''}}">
                            <label for="commission" class="control-label">Total Commission</label>
                            {!! Form::input('number','commission',null,['class'=>'form-control','step'=>0.01,'v-model'=>'stock.commission']) !!}
                            <p v-if="hasError('commission')"class="help-block">@{{getError('commission')}}</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group @{{hasError('buy_date') ? 'has-error' : ''}}">
                            <label for="buy_date" class="control-label">Buy Date</label>
                            {!! Form::input('date','buy_date',null,['class'=>'form-control','v-model'=>'stock.buy_date']) !!}
                            <p v-if="hasError('buy_date')"class="help-block">@{{getError('buy_date')}}</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="owner_name" class="control-label">Owner Name</label>
                            {!! Form::input('text','owner_name',null,['class'=>'form-control','v-model'=>'stock.owner_name']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="shareholder_number" class="control-label">Shareholder No.</label>
                            {!! Form::input('text','shareholder_number',null,['class'=>'form-control','v-model'=>'stock.shareholder_number']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="certificate_number" class="control-label">Certificate No.</label>
                            {!! Form::input('text','certificate_number',null,['class'=>'form-control','v-model'=>'stock.certificate_number']) !!}
                        </div>
                    </div>
                    <span class="clearfix"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Add Stock</button>
                </div>
                {!! Form::close()  !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('endscript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.9/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    {!! HTML::script('vendors/mustache/mustache.min.js') !!}
    {!! HTML::script('vendors/bootbox/bootbox.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.15/vue.min.js" type="text/javascript"></script>
    <script type="text/html" id="update-modal-tmpl">
        <form action="@{{& action }}" class="form-horizontal" method="post" id="update-basket-@{{id}}">
            <div class="modal fade in">
                <div class="modal-dialog">
                    <div class="modal-content animated zoomIn" style="animation-duration: 250ms">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Basket</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            @{{#method}}
                            <input type="hidden" name="_method" value="@{{ method }}">
                            @{{/method}}
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="modal_basket_name" class="control-label">Basket Name</label>
                                    <input type="text" name="basket_name" value="@{{ basket }}" class="form-control" id="modal_basket_name">
                                </div>
                            </div>
                            <span class="clearfix"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary ajax-submit" data-form="#update-basket-@{{id}}">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </script>
    <script type="text/html" id="btn-group-tmpl">
        <div class="box-tools" data-id="@{{ id }}" data-name="@{{ name }}" data-url="@{{url}}">
            <button class="btn btn-box-tool" data-toggle="modal" data-target="#addStockModal"><i class="fa fa-plus"></i></button>
            <a class="btn btn-box-tool" href="{{route('member.stock.index')}}/@{{id}}"><i class="fa fa-eye"></i></a>
            <button class="btn btn-box-tool editBasket"><i class="fa fa-edit"></i></button>
            <button class="btn btn-box-tool deleteBasket"><i class="fa fa-trash"></i></button>
        </div>
    </script>
    <script type="text/html" id="delete-modal-tmpl">
        <form action="@{{& action }}" class="form-horizontal" method="post" id="update-basket-@{{id}}">
            <div class="modal fade in">
                <div class="modal-dialog">
                    <div class="modal-content animated zoomIn" style="animation-duration: 250ms">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Confirm Delete</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            @{{#method}}
                            <input type="hidden" name="_method" value="@{{ method }}">
                            @{{/method}}
                            <p class="text-warning">Are you sure you want to delete <strong>@{{ basket }}</strong> basket?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger ajax-submit" data-form="#update-basket-@{{id}}"><i class="fa fa-trash"></i> Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </script>
    <script type="text/javascript">
    var BASKET_URL = '{{route("member.basket.fetch")}}';
    var STOCK_URL = '{{route("member.stock.store")}}';
    var table;
    var incrementer = 0;

    $(document).ready(function(){
        table = $('#baskets-table').DataTable({
            processing: true,
            paging: true,
            serverSide: false,
            "aLengthMenu": [[50, 100, 150, 200], [50, 100, 150, 200]],
            "iDisplayLength": 50,
            ajax: {
                url: BASKET_URL,
                type: 'POST'
            },
            drawCallback : function() {
                incrementer = 0;
            },
            columns: [
                {data: 'id',name:'id',searchable:false, render: function(){
                    return ++incrementer;
                }},
                {data: 'name',name:'name',render:function(data,type,row,meta){
                    return '<a href="'+'{{route("member.stock.index")}}'+'/'+row.id+'" class="link">'+data+'</a>';
                }},
                {data: 'Investment', name:'name',render:function(data,type,row,meta){
                    row.dataChange = 'neutral';
                    row.investment = 0;
                    row.value = 0;
                    $.each(row.stock_buy,function(i,stock){
                        stock.calc_rate = stock.buy_rate + (parseFloat(stock.commission).toFixed(2)/stock.quantity);
                        stock.calc_quantity = stock.quantity;
                        $.each(stock.sell,function(j,sell){
                            stock.calc_quantity -= sell.quantity;
                        });
                        row.value += stock.calc_quantity * stock.close_price;
                        row.investment += stock.calc_quantity * stock.calc_rate;
                    });

                    if(row.value > row.investment){
                        row.dataChange = 'up';
                    }else if(row.value < row.investment){
                        row.dataChange = 'down';
                    }

                    return parseFloat(row.investment).toFixed(2);
                }},
                {data: 'Value',name:'name',render:function(data,type,row,meta){
                    return parseFloat(row.value).toFixed(2);
                }},
                {data: 'Profit/Loss',name:'name',render:function(data,type,row,meta){
                    row.profit_loss = (row.investment == 0) ? 0 : (row.value - row.investment);
                    return '<span data-change="'+row.dataChange+'">'+parseFloat(row.profit_loss).toFixed(2)+'</span>';

                }},
                {data: 'Percentage',name:'name',render:function(data,type,row,meta){
                    row.percentage = (row.investment == 0) ? 0 : parseFloat((row.value - row.investment) * 100 / row.investment).toFixed(2);
                    return '<span data-change="'+row.dataChange+'">'+row.percentage+'<small style="font-size:0.8em">%</small></span>';
                }},
                {
                    data: 'Action',
                    name:'id',
                    searchable:false,
                    orderable:false,
                    render:function(id,type,row,meta){
                        return Mustache.to_html($('#btn-group-tmpl').html(), {
                            id:row.id, name:row.name,
                            url:'{{route("member.basket.update",":id")}}'.replace(':id',row.id)}
                        )
                    }
                }
            ],
            footerCallback: function ( row, data, start, end, display) {
                var self = this;

                this.totInv = 0;
                this.totVal = 0;
                $.each(data,function(i,row){
                    $.each(row.stock_buy,function(i,stock){
                        stock.calc_rate = stock.buy_rate + (parseFloat(stock.commission).toFixed(2)/stock.quantity);
                        stock.calc_quantity = stock.quantity;
                        $.each(stock.sell,function(j,sell){
                            stock.calc_quantity -= sell.quantity;
                        });
                        self.totVal += stock.calc_quantity * stock.close_price;
                        self.totInv += stock.calc_quantity * stock.calc_rate;
                    });
                });

                this.change = this.totVal - this.totInv
                this.dataChange = 'neutral';
                if(this.change > 0){ this.dataChange = 'up'; }
                else if(this.change < 0){ this.dataChange = 'down'; }

                // Update footer
                $("#totInv").text(parseFloat(this.totInv).toFixed(2));
                $("#totVal").text(parseFloat(this.totVal).toFixed(2));
                $("#totChange").html('<span data-change="'+this.dataChange+'">'+parseFloat(this.change).toFixed(2)+'</span>');
            }
        });
    });

    $(document).on('click','.editBasket',function(){
        var self = this;
        this.firstNode = $(this).closest('.box-tools');
        this.data = {
            id: self.firstNode.data('id'),
            method: 'put',
            basket: self.firstNode.data('name'),
            action: self.firstNode.data('url')
        };
        this.modalConainer = $('section#modal-container');
        this.modalConainer.html(Mustache.to_html($('#update-modal-tmpl').html(), self.data));
        this.modalConainer.find('.modal').modal({keyboard:true, backdrop: false});
    });

    $(document).on('click','.deleteBasket',function(){
        var self = this;
        this.firstNode = $(this).closest('.box-tools');
        this.data = {
            method: 'delete',
            basket: self.firstNode.data('name'),
            action: self.firstNode.data('url')
        };
        this.modalConainer = $('section#modal-container');
        this.modalConainer.html(Mustache.to_html($('#delete-modal-tmpl').html(), self.data));
        this.modalConainer.find('.modal').modal({keyboard:true, backdrop: false});
    });

    $(document).on('click','.ajax-submit',function(e){
        e.preventDefault();
        var self = this;
        this.form = $(this).data('form');
        this.data = $(this.form).serialize();
        this.dismiss = $(this).prev();
        $.post($(self.form).attr('action'),self.data,function(response){
            self.dismiss.click();
        });

        table.ajax.reload();
    });

    new Vue({
        el: '#stockApp',
        data: {
            stock: {
                buy_rate: '',
                basket_id: '',
                company: '',
                type: '',
                quantity: '',
                certificate_number: '',
                commission: '',
                buy_date: '',
                owner_name: '',
                shareholder_number: ''
            },
            messages:[],
            validations: {}
        },
        methods:{
            submit: function(){
                console.log('click');
                $.post(STOCK_URL,this.stock)
                .success(function(response){
                    this.reset();
                    $('#addStockModal').find('button [data-dismiss=modal]').click();
                    this.setMessage({
                        type: 'success',
                        icon: 'fa-check-circle-o',
                        text: response.message || 'Stock has been successfully added to your basket.'
                    });
                    $('.modal').find('button[data-dismiss=modal]').click();
                    table.ajax.reload();
                }.bind(this))
                .fail(function(response){
                    if(response.status === 422){
                        this.$set('validations',response.responseJSON);
                        setTimeout(function(){
                            this.$set('validations',{});
                        }.bind(this),10000);
                    }else{
                        this.setMessage({
                            type: 'danger',
                            icon: 'fa-danger',
                            text: response.statusText
                        });
                        $('.modal').find('button[data-dismiss=modal]').click();
                    }
                }.bind(this));
            },
            reset: function(){
                this.$set('stock',{buy_rate: '',basket: '',company: '',stock: '',quantity: '',certificate_number: '',commission: '',buy_date: '',owner_name: '',shareholder_number: ''});
            },
            setMessage: function(message){
                this.messages.push(message);
                setTimeout(function(){
                    this.messages.slice(0,1)
                }.bind(this),10000);
            },
            hasError: function(field){
                return this.validations.hasOwnProperty(field);
            },
            getError: function(field){
                return this.hasError(field) ? this.validations[field][0] : '';
            }
        },
        ready: function(){
            $('#stockApp').removeClass('hide');
        }
    });
    </script>
@endsection