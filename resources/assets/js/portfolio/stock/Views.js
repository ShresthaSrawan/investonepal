import * as TPN from './constants/tab-pane-names.js'
import * as MN from './constants/modal-names.js'
//import StockBuyModal from './modals/stock-buy-modal.js'
import {finder} from '../../helpers.js'

export default class Views {
	constructor (App, VuePaneList){
		this.app = App;
		this.views = VuePaneList;
		this.current = {
			view: null,
			params: {},
		};

		this.listenEvents();

		this.show(TPN.GROUPED);
	}

	show (name, params = {}, element) {
		this.current = {name, params};
		console.log(this.views[name]);
		this.views[name].show(params, element);
	}

	listenEvents () {
		//change to buy view when clicked on
		this.listenViewChangeEvents();
		this.listenModalEvents();
	}

	listenViewChangeEvents () {
		let _this = this;
		$(document).on('click','[data-change-view]', function(){
			let target = $(this);
			let view = target.data('change-view');

			let id = target.data('id');
			let name = target.data('name');

			let params = id && name ? {id,name} : {};

			console.log(view, params);

			switch(target.data('change-view')) {
				case TPN.GROUPED:
					_this.show(TPN.GROUPED, params, target);
					break;

				case TPN.BUY:
					_this.show(TPN.BUY, params, target);
					break;

				case TPN.SELL:
					_this.show(TPN.SELL, params, target);
					break;

				case TPN.DETAILS:
					_this.show(TPN.DETAILS, params, target);
					break;
			}
		})
	}
	listenModalEvents () {
		let _this = this;

		$(document).on('click', '[data-modal]', function(e) {
			let target = $(this);
			let id = target.data('id');
			let modalName = target.data('modal');

			console.info('Opening Modal', modalName);
			console.log(_this.app.modals[modalName]);
			_this.app.modals[modalName].open(id);
		});
	}
}