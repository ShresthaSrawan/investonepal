import Modal from './Modal.js';
import {ajaxForm} from '../utils.js';
import * as TPE from '../constants/tab-pane-elements.js';
import * as TEMPLATE from '../constants/template-html.js';
import {SELL_CREATED_EVENT, SELL_UPDATED_EVENT} from '../constants/event-names.js';

export default class SellModal extends Modal {

	open (id = null) {
		id ? this.edit(id) : this.create();
	}

	create () {
		if(this.isOpen || this.$el) return;

    let html = Mustache.to_html(TEMPLATE.SELL_MODAL, {
    	title: 'Sell Stock', 
  		basket_id: $('[data-name="baskets"]').val(),
  		stock_id: TPE.SELL.find('input[name=buy_id]').val(),
  		btnLabel: '<i class="ion-ios-plus-outline"></i> Add'
    });

    this.$el = $(html);

    this.renderBuyData(); 

    super.open(() => {
    	console.log(this.$el.find('.date'));
    	//this.$el.find('.date').datetimepicker({format: 'YYYY-MM-DD'});
    	this.ajaxSubmit();
    });
	}

	edit (id) {
		if(this.isOpen || this.$el || !id) return;

		let data = this.datatable.find('id', id);

    if(!data) return;

		let html = Mustache.to_html(TEMPLATE.SELL_MODAL, {
      title : 'Edit Sold Stock',
      method: 'put',
      basket_id: $('[data-name="baskets"]').val(),
      stock_id: TPE.SELL.find('input[name=buy_id]').val(),
      btnLabel: '<i class="ion-compose"></i> Update',
      sell_date: data.sell_date,
      sell_quantity: data.sell_quantity,
      sell_rate: data.sell_rate,
      sell_commission: data.sell_commission,
      sell_tax: data.sell_tax,
      sell_note: data.sell_note,
    });

    this.$el = $(html);

    this.renderBuyData();

    this.$el.find(`select[name=company] option[value=${data.company_id}]`).prop('selected', true);

    super.open(() => {
    	this.$el.find('select[name=company]').chosen();
    	this.ajaxSubmit(id);
    });
	}

  renderBuyData () {
    var html = this.app.views.views.sell.$el.find('.box-header:eq(1)').html();
    var originalHeader = this.$el.find('.modal-header:eq(0)');
    var clonedHeader = originalHeader.clone();

    this.$el.find('.modal-header:eq(1)').remove();

    clonedHeader.empty().html(html);

    originalHeader.after(clonedHeader);
  }

	ajaxSubmit (id = null) {
    this.form = this.$el.find('form');
    console.log('Processing Form');

    let ajax = ajaxForm(this.app, this.form, id)
    .onSuccess((response) => {
    	this.close();
    	id ? this.app.event.occured(SELL_UPDATED_EVENT) : this.app.event.occured(SELL_CREATED_EVENT);
    });
  }
}