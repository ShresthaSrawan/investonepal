import ViewPane from '../ViewPane.js';

export default class BuyView extends ViewPane {
	show (data) {
		this.setViewData(data);

		super.show();
	}

	setViewData ({id, name}) {
		if(!id || !name) return;

		this.$el.find('input[name=company_id]').val(id);
		this.$el.find('span[data-title]').text(name);

		this.datatable().reload();
	}

	listenEvents () {
		this.listenDatatableEvents();
	}

	listenDatatableEvents() {
		this.datatable().$el.on('processing.dt', (e, setting, processing) => {
			console.debug('Buy Table Processing:',processing)
      let sellView = this.app.views.views.sell;

      if(!processing && sellView.buy_data && typeof sellView.buy_data === 'object' && sellView.buy_data.id) {
        let buy_data = this.datatable().find('id', sellView.buy_data.id);

        sellView.buy_data = buy_data;
        sellView.setViewData(buy_data);
      }
		});

    this.$el.on('change','input[name="toggle-sold"]', () => {
      this.datatable().reload()
    });
	}
}