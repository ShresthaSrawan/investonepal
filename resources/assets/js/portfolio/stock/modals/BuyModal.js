import Modal from './Modal.js';
import {ajaxForm} from '../utils.js';
import * as TEMPLATE from '../constants/template-html.js';
import {BUY_CREATED_EVENT, BUY_UPDATED_EVENT} from '../constants/event-names.js';

export default class BuyModal extends Modal {

	open (id = null) {
		id ? this.edit(id) : this.create();
	}

	create () {
		if(this.isOpen || this.$el) return;
		
	    let html = Mustache.to_html(TEMPLATE.BUY_MODAL, {
	    	title: 'Add Stock', 
			basket: $('[data-name="baskets"]').val(),
			btnLabel: '<i class="ion-ios-plus-outline"></i> Add'
	    });

	    this.$el = $(html);

	    super.open(() => {
	    	this.$el.find('select[name=company]').chosen();
	    	//this.$el.find('input[name=buy_date]').datepicker({dateFormat:'yyyy-mm-dd' , lang: 'en'});
	    	this.ajaxSubmit();
	    });
	}

	edit (id) {
		if(this.isOpen || this.$el || !id) return;

		let data = this.datatable.find('id', id);

		console.log(data);

		if(!data) return;

		let html = Mustache.to_html(TEMPLATE.BUY_MODAL, {
	    	title : 'Edit Stock',
            btnLabel: '<i class="ion-compose"></i> Update',
            method: 'put',
            basket: data.basket_id,
            certificate_number: data.certificate_number,
            shareholder_number: data.shareholder_number,
            owner_name: data.owner_name,
            buy_rate: data.buy_rate,
            buy_date: data.buy_date,
            company: data.company_id,
            type: data.type_id,
            quantity: data.remaining_quantity + data.sell_quantity,
            commission: data.commission
	    });

	    this.$el = $(html);

      this.$el.find(`select[name=company] option[value=${data.company_id}]`).prop('selected', true);
      this.$el.find(`select[name=type] option`).removeAttr('selected');
      this.$el.find(`select[name=type] option[value=${data.type_id}]`).prop('selected', true);

	    super.open(() => {
	    	this.$el.find('select[name=company]').chosen();
	    	this.ajaxSubmit(id);
	    });
	}

	ajaxSubmit (id = null) {
        this.form = this.$el.find('form');
        console.log('Processing Form');

        let ajax = ajaxForm(this.app, this.form, id)
        .onSuccess((response) => {
        	this.close();
        	id ? this.app.event.occured(BUY_UPDATED_EVENT) : this.app.event.occured(BUY_CREATED_EVENT);
        });
    }
}