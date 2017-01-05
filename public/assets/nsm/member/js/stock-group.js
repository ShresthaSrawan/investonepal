var state;
var table;
var dtStockGroup;
var StockDetailsTemplate;
// Array to track the ids of the details displayed rows
var detailRows = [];
var currentRow = {};

var dtSettingsAll = {
    processing: true,
    paging: true,
    serverSide: true,
    "aLengthMenu": [[50, 100, 150, 200], [50, 100, 150, 200]],
    "iDisplayLength": 50,
    ajax: {
        url: FETCH_STOCK_GROUPED,
        type: 'POST',
        data: {
            basket_id: function(){return $('#basketList').val()}
        }
    },
    drawCallback: function(settings) {
        $(window).trigger('resize');
    },
    footerCallback: function ( row, data, start, end, display) {
        var self = this;

        var investment = 0;
        var market_value = 0;
        var profit_loss = {
            change: 0,
            percent:0
        };
        $.each(data,function(i,row){
            investment += row.investment;
            market_value += row.market_value;
            profit_loss.change += row.profit_loss;
        });

        profit_loss.percent = parseFloat(Math.abs((market_value - investment) * 100 / investment)).toFixed(2);
        profit_loss.change = parseFloat(profit_loss.change).toFixed(2);
        investment = parseFloat(investment).toFixed(2);
        market_value = parseFloat(market_value).toFixed(2);

        // Update footer
        var dataChange = profit_loss.change > 0 ? "up" : (profit_loss.change < 0 ? 'down' : 'neutral');

        $("#totalInvestment").html(investment);
        $("#totalValue").html(market_value);
        $("#totalChange").html('<span data-change="'+dataChange+'">'+profit_loss.change+'  <small>('+profit_loss.percent+' %)</small></span>');
    },
    columns: [
        {data: 'company_quote',render: function(data,type,row,meta){
            return '<a href="/quote/'+data+'" target="_blank"><span data-toggle="tooltip" data-placement="down" title="'+row.company_name+'">'+data+'</span></a>';
        }},
        {data: 'buy_rate',render: function(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'remaining_quantity'},
        {data: 'close_price', render: function(data,type,row,meta){
            var closeDate = moment(row.close_date).format('D MMM. YY');
            return (data == null) ? 'NA' : (data + ' <small>('+closeDate+')</small>');
        }},
        {data: 'investment', render: function(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'market_value', render: function(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'profit_loss', render: function(data,type,row,meta){
            if(!data) return 'NA';

            var changePercent = Math.abs(parseFloat(100* (row.market_value - row.investment)/row.investment).toFixed(2));

            var dataChange = data > 0 ? 'up' : (data < 0 ? 'down' : 'neutral');

            return '<span data-change="'+dataChange+'">'+parseFloat(data).toFixed(2)+' <small>('+changePercent+'%)</small></span>';
        }},
        {data: 'total_stocks'},
        {data: null, orderable: false, searchable: false, render: function(data,type,row,meta){
            return '<button class="btn btn-box-tool display-stock-group" data-quote="'+row.company_quote+'" data-company="'+row.company_id+'" data-toggle="tooltip" data-placement="top" title="More Details"><i class="fa fa-chevron-circle-right"></i></button>';
        }}
    ]
};

var dtSettingsCompany = {
    processing: true,
    paging: true,
    serverSide: true,
    "aLengthMenu": [[50, 100, 150, 200], [50, 100, 150, 200]],
    "iDisplayLength": 50,
    ajax: {
        url: FETCH_STOCK_GROUP_COMPANY,
        type: 'POST',
        data: {
            basket_id: function(){return $('#basketList').val()},
            company_id: function(){return $('input[name=stock_company_id]').val()}
        }
    },
    drawCallback: function(settings) {
        $(window).trigger('resize');
    },
    footerCallback: function ( row, data, start, end, display) {
        var self = this;

        var investment = 0;
        var market_value = 0;
        var profit_loss = {
            change: 0,
            percent:0
        };
        $.each(data,function(i,row){
            investment += row.investment;
            market_value += row.market_value;
            profit_loss.change += row.profit_loss;
        });

        profit_loss.percent = parseFloat(Math.abs((market_value - investment) * 100 / investment)).toFixed(2);
        profit_loss.change = parseFloat(profit_loss.change).toFixed(2);
        investment = parseFloat(investment).toFixed(2);
        market_value = parseFloat(market_value).toFixed(2);

        // Update footer
        var dataChange = profit_loss.change > 0 ? "up" : (profit_loss.change < 0 ? 'down' : 'neutral');
        $('#group-stock-table span[data-investment]').text(investment);
        $('#group-stock-table span[data-market-value]').text(market_value);
        $('#group-stock-table span[data-change]').html('<span data-change="'+dataChange+'">'+profit_loss.change+'  <small>('+profit_loss.percent+' %)</small></span>');
    },
    columns: [
        {data: 'company_quote',render: function(data,type,row,meta){
            return '<a href="/quote/'+data+'" target="_blank"><span data-toggle="tooltip" data-placement="down" title="'+row.company_name+'">'+data+'</span></a>';
        }},
        {data: 'buy_rate',render: function(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'remaining_quantity'},
        {data: 'close_price', render: function(data,type,row,meta){
            var closeDate = moment(row.close_date).format('D MMM. YY');
            return (data == null) ? 'NA' : (data + ' <small>('+closeDate+')</small>');
        }},
        {data: 'investment', render: function(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'market_value', render: function(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'profit_loss', render: function(data,type,row,meta){
            if(!data) return 'NA';

            var changePercent = Math.abs(parseFloat(100* (row.market_value - row.investment)/(row.investment || row.market_value)).toFixed(2));

            var dataChange = data > 0 ? 'up' : (data < 0 ? 'down' : 'neutral');

            return '<span data-change="'+dataChange+'">'+parseFloat(data).toFixed(2)+' <small>('+changePercent+'%)</small></span>';
        }},
        {data: null, orderable: false, searchable: false, render: function(data,type,row,meta){
            return '<button class="btn btn-box-tool display-stock-group" data-company="'+row.company_id+'" data-toggle="tooltip" data-placement="top" title="More Details"><i class="fa fa-chevron-circle-right"></i></button>';
        }}
    ]
};

$(document).ready(function(){
    StockDetailsTemplate = $('#stock-details-tmpl').html();
    Mustache.parse(StockDetailsTemplate);
    showBasketHeader();
});

$(document).on('click','.display-stock-group', function(){
    var company = $(this).data('company');
    var quote = $(this).data('quote');
    var current_company = $('input[name=stock_company_id]').val();

    if(!company) return;

    $('input[name=stock_company_id]').val(company);
    showPortfolioStockGroup(quote);
});

$(document).on('click', '[data-back]', function(){
    var back = $(this).data('back');
    $('a[href="'+back+'"]').click();
});

function showPortfolioStockGroup(reloadTable, quote) {
    $('a[href="#protfolio-stock-group"]').click();
    $('#header-stock-quote').text(quote);
    if(!dtStockGroup) {
        dtStockGroup = $('#group-stock-table').DataTable(dtSettingsCompany);
    }else{
        dtStockGroup.ajax.reload();
    }
}

function showBasketHeader(){
    this.header = $('#basketList').find('option:selected').text();
    $('#basketHeader').text(this.header);
}

$('#basketList').change(function(){
    table.ajax.reload();
    showBasketHeader();
});

$(document).on('click','.ajax-submit',function(e){
    e.preventDefault();
    var self = this;
    this.$form = $(this).data('parent-form') || false;
    if(this.$form == false){
        this.$form = $(this).closest('form');
    }else{
        this.$form = $(this.$form);
    }

    this.$formParentNode = this.$form.parent();
    this.formHtml = this.$form.parent().html();
    toggleAjaxSubmitButtonIcon($(self),'i','ion-ios-plus-outline');

    submitForm(this.$form,$(this),function(response){
        self.$form.find("input, textarea").val("");
        if(self.$form.hasClass('inModal')){
            $('button[data-dismiss=modal]').click();
        }

        if($(self).data('target-later')){
            toggleAjaxSubmitButtonIcon($(self),'i','ion-ios-plus-outline');

            var that = this;
            that.target = $(self).data('target-later');
            that.toggle = $(self).data('toggle');
            that.data = {
                type: 'success',
                heading: 'Success, Stock Sold',
                description: 'Stock, sales details has been successfully created. Click <button type="button" class="btn btn-default btn-sm restore" data-toggle="'+that.toggle+'" data-target="'+that.target+'">here</button> to view sales list.'
            };
            self.$formParentNode.html(Mustache.to_html($('#callout-tmpl').html(),this.data));
            $(document).on('click','.restore',function(){
                self.$formParentNode.html(self.formHtml);
            });

            state = $(self).data('stock');
            table.ajax.reload();
        }

        if($(self).data('reload-datatable') === undefined){
            table.ajax.reload();
        }
    }, function(response){
        var resp = this;
        if(response.status == 422){
            $('.text-danger').remove();
            this.json = $.parseJSON(response.responseText);
            this.callout = self.$form.find('.alert');
            if(this.callout.length > 0){
                this.callout.remove();
            }

            this.getData = function(){
                var __getData = this;
                this.warnings = '<ul>';
                this.counter =  0;
                $.each(this.json,function(i,v){
                    __getData.warnings += '<li>'+v[0]+'</li>' ;
                });

                this.warnings += '</ul>';
                return this.warnings;
            };

            this.callout = Mustache.to_html($('#callout-tmpl').html(),
                {
                    type: 'warning',
                    heading: 'Validation Errors!',
                    description: resp.getData()
                }
            );

            self.$form.prepend(this.callout);

            if(self.$form.hasClass('inModal')){
                this.toggle = self.$form.closest('.modal-dialog');
            }else{
                this.toggle = self.$form;
            }

            this.toggle.addClass('shake animated').css({'animation-duration': '250ms'});
            setTimeout(function(){
                resp.toggle.removeClass('shake animated');
            },250);
        }
    });
});

$(document).ready(function(){
    table = $('#am-stock-table').DataTable(dtSettingsAll);
    $(document).on('change','#toggle-sold-stock', function(){
        table.ajax.reload();
    });
    // On each draw, loop over the `detailRows` array and show any child rows
    table.on( 'draw', function (abc) {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    });
});

$(document).on('click','[data-toggle=tab]',function(){
    this.target = $(this).attr('href') || $(this).data('target');
    $(this.target).addClass('animated fadeInLeft').css({'animation-duration': '250ms'});
});

$(document).on('click','#buy-stock',function(){
    data = {title: 'Add Stock', basket: $('#basketList').val(), btnLabel: '<i class="ion-ios-plus-outline"></i> Add'};
    this.html = Mustache.to_html($('#add-edit-modal').html(), data);
    this.$modal = $(this.html).modal({keyboard: true, backdrop: false});
});

$(document).on('click','.editStock',function(){
    var self = this;
    this.stock_id = $(this).parent().data('id');

    $.each(dtStockGroup.ajax.json().data,function(pos,data){
        if(data.id == self.stock_id){
            self.data = {
                title : 'Edit Stock',
                btnLabel: '<i class="ion-compose"></i> Update',
                basket: data.basket_id,
                method: 'put',
                certificate_number: data.certificate_number,
                shareholder_number: data.shareholder_number,
                owner_name: data.owner_name,
                buy_rate: data.buy_rate,
                buy_date: data.buy_date,
                company: data.company_id,
                type: data.type_id,
                quantity: data.quantity,
                commission: data.commission
            };
        }
    });
    this.html = Mustache.to_html($('#add-edit-modal').html(), this.data);
    this.$modal = $(this.html).modal({keyboard: true, backdrop: false});
    this.$modal.find("form").attr('action', this.$modal.find("form").attr('action')+'/'+this.stock_id);
    this.$modal.find("#companyList option[value='"+this.data.company+"']").attr('selected', true);
    this.$modal.find("#stockTypeList option[value='"+this.data.type+"']").attr('selected', true);
});

$(document).on('hide.bs.modal',function(e){
    e.preventDefault();
    var $modal = $(this);
    $modal.find('.modal-content').toggleClass('zoomIn zoomOut');
    setTimeout(function(){
        $('body').removeClass('modal-open').removeAttr('style');
        $(document).find('.modal-backdrop').remove();
        $(document).find('.modal').remove();
    },250);
});

function _delete(btn){
    var parentNode = btn; 
    bootbox.dialog({
      message: "Are you sure you want to delete this recored?",
      title: "Confirm Delete",
      animate: false,
      className: 'animated ZoomIn',
      backdrop: false,
      buttons:{
        dismiss: {
          label: "Cancel",
          className: "btn-default",
        },
        danger: {
          label: "<i class='fa fa-trash'></i> Delete",
          className: "btn-danger",
          callback: function(e) {
            var self =  this;
            this.target = e.currentTarget;
            this.url = $(parentNode).parent().data('url');
            $(this.target).prop('disabled',true);
            $(this.target).children('i').toggleClass('fa-trash fa-spinner fa-pulse');
            $.post(this.url,{'_method':'delete'})
                .done(function(response){
                    if(response.error == false){
                        $(self.target).prev().click();
                        $.notify({icon:'fa fa-bell',title: 'Success',message: response.message},NOTIFY_CONFIG).update('type','pastel-success'); 
                        table.ajax.reload();
                    }else{
                        $.notify({icon:'fa fa-warning',title: 'Warning',message: response.message},NOTIFY_CONFIG).update('type','pastel-warning'); 
                    }
                }).fail(function(response){
                    $.notify({icon:'fa fa-warning',title: 'Danger',message:response.statusText },NOTIFY_CONFIG).update('type','pastel-danger'); 
                });
          }
        }
      }
    });
}
$(document).on('click','.deleteStockDetails, .deleteStockSales , .deleteStock',function(){
    _delete(this);
});

$(document).on('change','#basketList',function(){
    $('#basket_id').val($(this).val());
});


function toggleAjaxSubmitButtonIcon($btn,child,defaultIcon) {
    $input = $btn.parent().prev();
    $btn.find(child).toggleClass(defaultIcon)
        .toggleClass('fa fa-spinner fa-pulse');

    $input.prop('disabled', function (_, val) { return ! val; });
    $btn.prop('disabled', function (_, val) { return ! val; });
}

function submitForm($form,$btn,success,fail){
    var data = $form.serialize();
    var url = $form.attr('action');
    var method = ($form.find('_method').length == 1 ) ? $form.find('_method').val() : $form.attr('method');
    $.ajax({
        method: method,
        url: url,
        data: data
    }).done(function(response) {
        if(response.error == false){
            $.notify({icon:'fa fa-bell',title: 'Success',message: response.message},NOTIFY_CONFIG).update('type','pastel-success');
            if(success !== undefined)  success(response);
        }else{
            $.notify({icon:'fa fa-warning',title: 'Warning', message: response.message},NOTIFY_CONFIG).update('type','pastel-warning');
            if(fail !== undefined)  fail(response);
        }
        toggleAjaxSubmitButtonIcon($btn,'i','ion-ios-plus-outline')
    }).fail(function(response) {
        if(response.status != 422){
            $.notify({icon:'fa fa-warning',title: 'Error: '+response.status, message: response.statusText},NOTIFY_CONFIG).update('type','pastel-danger');
        }
        toggleAjaxSubmitButtonIcon($btn,'i','ion-ios-plus-outline');

        if(fail !== undefined)  fail(response);
    });
}