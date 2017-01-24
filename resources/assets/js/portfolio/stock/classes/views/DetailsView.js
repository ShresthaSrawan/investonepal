import ViewPane from '../ViewPane.js';

export default class DetailsView extends ViewPane {
	show (data) {
		this.setViewData(data);

		super.show();
	}

	setViewData ({id, name}) {
		if(!id || !name) return;

		this.$el.find('input[name=buy_id]').val(id);
		this.$el.find('span[data-title]').text(name);

		this.datatable().reload();
	}

	listenEvents () {
		this.listenDatatableEvents();
	}

	listenDatatableEvents() {
		this.datatable().$el.on('processing.dt', (e, setting, processing) => {
			console.debug('Details Table Processing:',processing)
		});
	}
}