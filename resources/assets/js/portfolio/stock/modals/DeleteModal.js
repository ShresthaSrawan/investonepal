import Modal from './Modal.js';
import {ajaxForm} from '../utils.js';
import * as TEMPLATE from '../constants/template-html.js';
import {BUY_DELETED_EVENT, SELL_DELETED_EVENT, DETAILS_DELETED_EVENT} from '../constants/event-names.js';

export default class DeleteModal extends Modal {

  open (id = null) {
    if(this.isOpen || this.$el || !id) return;

    let view = this.app.views.current.name;

    let action = window.routes.del[view].replace(':id', id);

    let html = Mustache.to_html(TEMPLATE.DELETE_MODAL, {
      title : 'Confirm Delete',
      btnLabel: '<i class="ion-trash"></i> Delete'
    });

    this.$el = $(html);

    super.open(() => {
      this.form = this.$el.find('form');

      this.form.attr('action', action);
      
      ajaxForm(this.app, this.form)
        .onSuccess((response) => {
          this.close();

          if(view == 'buy') this.app.event.occured(BUY_DELETED_EVENT);
          if(view == 'sell') this.app.event.occured(SELL_DELETED_EVENT);
          if(view == 'details') this.app.event.occured(DETAILS_DELETED_EVENT);
        }
      );
    });
  }
}