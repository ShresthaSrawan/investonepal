import Modal from './Modal.js';
import {ajaxForm} from '../utils.js';
import * as TEMPLATE from '../constants/template-html.js';
import {DETAILS_CREATED_EVENT, DETAILS_UPDATED_EVENT} from '../constants/event-names.js';
import * as TPE from '../constants/tab-pane-elements.js';

export default class DetailsModal extends Modal {

	open (id = null) {
		id ? this.edit(id) : this.create();
	}

	create () {
		if(this.isOpen || this.$el) return;
	    let html = Mustache.to_html(TEMPLATE.DETAILS_MODAL, {
	    	title: 'Add Stock Details',
			basket_id: $('[data-name="baskets"]').val(),
			stock_id: TPE.DETAILS.find('input[name=buy_id]').val(),
			btnLabel: '<i class="ion-ios-plus-outline"></i> Add'
	    });

	    this.$el = $(html);

	    super.open(() => {
	    	this.ajaxSubmit();
	    });
	}

	edit (id) {
		if(this.isOpen || this.$el || !id) return;

		let data = this.datatable.find('id', id);

		console.log(data);

		if(!data) return;

		let html = Mustache.to_html(TEMPLATE.DETAILS_MODAL, {
	    	title : 'Edit Stock Details',
            method: 'put',
            basket_id: $('[data-name="baskets"]').val(),
			stock_id: TPE.DETAILS.find('input[name=buy_id]').val(),
            btnLabel: '<i class="ion-compose"></i> Update',
			details_id: data.id,
            fiscal_year_id : data.fiscal_year_id,
			stock_dividend : data.stock_dividend,
			cash_dividend : data.cash_dividend,
			right_share : data.right_share,
			remarks : data.remarks
	    });

	    this.$el = $(html);

	    this.$el.find(`select[name=fiscal_year] option[value=${data.fiscal_year_id}]`).prop('selected', true);

	    super.open(() => {
	    	this.$el.find('select[name=fiscal_year]').chosen();
	    	this.ajaxSubmit(id);
	    });
	}

	ajaxSubmit (id = null) {
        this.form = this.$el.find('form');
        console.log('Processing Form');

        let ajax = ajaxForm(this.app, this.form, id)
        .onSuccess((response) => {
        	this.close();
        	id ? this.app.event.occured(DETAILS_UPDATED_EVENT) : this.app.event.occured(DETAILS_CREATED_EVENT);
        });
    }
}