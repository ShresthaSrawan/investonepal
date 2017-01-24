import * as EN from './constants/event-names.js';
import * as TPN from './constants/tab-pane-names.js';
import * as DTN from './constants/data-table-names.js';

const BUY_CALLBACK = (view, datatables, app) => {
	if(view === TPN.BUY || view === TPN.SELL || view === TPN.DETAILS ) {
		datatables[DTN.BUY].reload();
		datatables[DTN.GROUPED].reload();
	}else if(view === TPN.GROUPED) {
		datatables[DTN.GROUPED].reload();
	}
}

const SELL_CALLBACK = (view, datatables, app) => {
	if(view === TPN.SELL) {
		datatables[DTN.SELL].reload();
		datatables[DTN.BUY].reload();
		datatables[DTN.GROUPED].reload();
    app.views.views.sell.renderBuyData(true);
	}else if(view === TPN.BUY) {
		datatables[DTN.BUY].reload();
		datatables[DTN.GROUPED].reload();
	}else if(view === TPN.GROUPED) {
		datatables[DTN.GROUPED].reload();
	}
}

const DETAILS_CALLBACK = (view, datatables, app) => {
	datatables[DTN.DETAILS].reload();
}

export default class Event {
	constructor (app) {
		this.app = app;
		this.triggered = [];
	}

	exists (event) {
		let eventName = EN[event];

		if(!eventName) {
			console.warn('%cUnidentified Event Occured: ' + '%c' + event, 'color: red;', 'color: red; padding-left: 10px; font-weight: bold');
			return false;
		}

		console.info('%cEvent Occured: ' + '%c' + event, 'color: green;', 'color: green; padding-left: 10px; font-weight: bold');

		return true;
	}

	datatables () {
		return this.app.datatables;
	}

	view () {
		return this.app.views.current.name;
	}

	occured (event) {
		this.triggered.push(event);

		if(!this.exists(event)) return this;

		let CALLBACK = function(){};

		switch(event) {
			case EN.BUY_CREATED_EVENT:
			case EN.BUY_UPDATED_EVENT:
			case EN.BUY_DELETED_EVENT:
				CALLBACK = BUY_CALLBACK;
				break;
			case EN.SELL_CREATED_EVENT:
			case EN.SELL_UPDATED_EVENT:
			case EN.SELL_DELETED_EVENT:
				CALLBACK = SELL_CALLBACK;
				break;
			case EN.DETAILS_CREATED_EVENT:
			case EN.DETAILS_UPDATED_EVENT:
			case EN.DETAILS_DELETED_EVENT:
				CALLBACK = DETAILS_CALLBACK
				break;
		}

		CALLBACK(this.app.views.current.name, this.app.datatables, this.app);

		return this;
	}
}