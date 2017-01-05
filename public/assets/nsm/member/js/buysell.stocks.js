var state;
var table;
var StockDetailsTemplate;
// Array to track the ids of the details displayed rows
var detailRows = [];
var currentRow = {};

var dtSettings = {
    processing: true,
    paging: true,
    serverSide: true,
    "aLengthMenu": [[50, 100, 150, 200], [50, 100, 150, 200]],
    "iDisplayLength": 50,
    ajax: {
        url: FETCH_STOCK_URL,
        type: 'POST',
        data: {
            basket_id: function(){return $('#basketList').val()},
            show_sold:function(){ return $(document).find('#toggle-sold-stock').is(':checked') ? 1 : 0;}
        }
    },
    "drawCallback": function(settings) {
        if(typeof state != 'undefined'){
            $('[data-stock-details='+state+']').click();
            state = undefined;
        }
        $(window).trigger('resize');
    },
    footerCallback: function ( row, data, start, end, display) {
        var self = this;

        this.totalInvest = 0;
        this.totalPort = 0;
        this.totalChange = {'change': 0,'percent':0};
        $.each(data,function(i,row){
            self.commissionRate = parseFloat(row.commission)/parseFloat(row.quantity);
            self.totalRate = self.commissionRate + parseFloat(row.buy_rate);
            self.totalInvest = (parseFloat(self.totalInvest)+(self.totalRate * row.quantity)).toFixed(2);

            self.close_price = (row.close_price == null) ? 0 : row.close_price;
            self.totalPort = (parseFloat(self.totalPort) + parseFloat(self.close_price * row.quantity)).toFixed(2);

            self.totalChange.change =  self.totalPort - self.totalInvest;
            self.totalChange.percent = self.totalInvest == 0 ? 0 : parseFloat((self.totalChange.change/self.totalInvest) * 100).toFixed(2);
        });

        // Update footer
        var dataChange = self.totalChange.change > 0
            ? "up"
            : (self.totalChange.change < 0 ? 'down' : 'neutral');

        $("#totalInvestment").html(self.totalInvest);
        $("#totalValue").html(self.totalPort);
        $("#totalChange").html('<span data-change="'+dataChange+'">'+self.totalChange.change+'  <small>('+self.totalChange.percent+' %)</small></span>');
    },
    columns: [
        {data: 'company.name',render: function(data,type,row,meta){
            return '<a href="/quote/'+row.company.quote+'" target="_blank"><span data-toggle="tooltip" data-placement="down" title="'+row.company.name+'">'+row.company.quote+'</span></a>';
        }},
        {data: 'buy_rate',render: function(data,type,row,meta){
            this.commissionRate = row.commission/row.quantity;
            currentRow.rate = parseFloat(this.commissionRate + row.buy_rate).toFixed(2); //rate
            return currentRow.rate;
        }},
        {data: 'quantity', render: function(data,type,row,meta){
            currentRow.quantity = data;
            $.each(row.sell,function(i,v){
                currentRow.quantity -= v.quantity;
            });
            return currentRow.quantity;
        }},
        {data: 'close_price', render: function(data,type,row,meta){
            currentRow.closeDate = moment(row.close_date).format('D MMM. YY');
            return (data == null) ? 'NA' : (data + ' <small>('+currentRow.closeDate+')</small>');
        }},
        {data: 'commission', render: function(data,type,row,meta){
            currentRow.initialInvestment = parseFloat(currentRow.rate * currentRow.quantity).toFixed(2); //initial investment
            return currentRow.initialInvestment;
        }},

        {data: 'commission', render: function(data,type,row,meta){
            if(row.close_price == null) return 'NA';
            currentRow.portfolioValue = parseFloat(row.close_price * currentRow.quantity).toFixed(2); //portfolio value
            return currentRow.portfolioValue;
        }},
        {data: 'commission', render: function(data,type,row,meta){
            if(row.close_price == null) return 'NA';

            var totChange = currentRow.initialInvestment == 0 ? 0 : parseFloat(currentRow.portfolioValue - currentRow.initialInvestment).toFixed(2); // total change
            var changePercent = currentRow.initialInvestment == 0
                ? 0 : parseFloat((totChange/currentRow.initialInvestment)* 100).toFixed(2);

            var dataChange = totChange > 0 ? 'up' : (totChange < 0 ? 'down' : 'neutral');

            return '<span data-change="'+dataChange+'">'+totChange+' <small>('+changePercent+'%)</small></span>';
        }},
        {
            "class":          "details-control",
            "orderable":      false,
            "data":           'id',
            "render": function(data,type,row,meta){
                this.template = $('#action-btns-tmpl').html();
                this.data = {id:row.id,url:STOCK_UPDATE_URL.replace(':id',row.id)};
                return Mustache.to_html(this.template,this.data);
            }
        }
    ]
};

$(document).ready(function(){
    StockDetailsTemplate = $('#stock-details-tmpl').html();
    Mustache.parse(StockDetailsTemplate);
    showBasketHeader();
});

function showBasketHeader(){
    this.header = $('#basketList').find('option:selected').text();
    $('#basketHeader').text(this.header);
}

$('#basketList').change(function(){
    table.ajax.reload();
    showBasketHeader();
});

$(document).on( 'click', 'tr td.details-control .moreStockDetails', function () {
    $(this).children('i').toggleClass('fa-plus-square fa-minus-square');
    var tr = $(this).closest('tr');
    var row = table.row( tr );
    var idx = $.inArray( tr.attr('id'), detailRows );

    if ( row.child.isShown() ) {
        tr.removeClass( 'details' ).removeAttr('style');
        row.child.hide();

        // Remove from the 'open' array
        detailRows.splice( idx, 1 );
    }
    else {
        tr.addClass( 'details' ).css({background:'rgb(250, 250, 250)'});
        row.child( format( row.data() ) ).show();

        // Add to the 'open' array
        if ( idx === -1 ) {
            detailRows.push( tr.attr('id') );
        }
        
        $.each($(document).find('table#am-stock-table > tbody > tr.details'),function (i,tr) {
            $(tr).next().css({background : 'rgba(200, 200, 200, 0.4)'});
        });
    }
});

function format ( data ) {
    $.each(data.sell,function(i,v){
        v.sell_date = moment(v.sell_date).format('D MMM YY');
        v.note = v.note || '--';
        v.url = STOCK_SELL_UPDATE.replace(':id',v.id);
    });

    $.each(data.details,function(i,v){
        v.url = STOCK_DETAILS_UPDATE.replace(':id',v.id);
        v._right_share = (v.right_share != null && v.right_share != '') ? v.right_share : '--';
        v._stock_dividend = (v.stock_dividend != null && v.stock_dividend != '') ? v.stock_dividend : '--';
        v._cash_dividend = (v.cash_dividend != null && v.cash_dividend != '') ? v.cash_dividend : '--';
        v._remarks = (v.remarks != null && v.remarks != '') ? v.remarks : '--';
    });
    
    return Mustache.render(StockDetailsTemplate, data);
}

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
    table = $('#am-stock-table').DataTable(dtSettings);
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

    $.each(table.ajax.json().data,function(pos,data){
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