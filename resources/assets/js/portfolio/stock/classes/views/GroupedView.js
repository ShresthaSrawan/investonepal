import ViewPane from '../ViewPane.js';
import * as DTN from '../../constants/data-table-names.js'

export default class GroupedView extends ViewPane {

  show (data, element) {
    super.show(data, element);
  }

	listenEvents () {
		super.listenEvents();
		
		this.listenBasketChangeEvent();
		this.listenDatatableEvents();

	}

	listenDatatableEvents () {
		this.datatable().$el.on('processing.dt', (e, setting, processing) => {
			console.debug('Grouped Table Processing:',processing)
		});
	}

	listenBasketChangeEvent () {
		let _this = this;
		$(document).on('change', 'select[data-name="baskets"]', function(){
			let selected = $(this).find('option:selected').text();
			_this.app.datatables[DTN.GROUPED].reload();
			_this.$el.find('span[data-title]').text(selected);
		});

		this.$el.find('span[data-title]').text(
			$('select[data-name="baskets"] > option:selected').text()
		);

    this.$el.on('change','input#toggle-sold-stock', () => {
      this.datatable().reload()
    });
	}
}