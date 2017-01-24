/* CONSTANTS */
import * as DTN from './constants/data-table-names.js'
import * as DTE from './constants/data-table-elements.js'
import * as DTS from './constants/data-table-settings.js'
import * as TPN from './constants/tab-pane-names.js'
import * as TPE from './constants/tab-pane-elements.js'
import * as TPA from './constants/tab-pane-anchors.js'
import * as MN from './constants/modal-names.js'
/* CLASSES */
import GroupedView from './classes/views/GroupedView.js'
import DetailsView from './classes/views/DetailsView.js'
import SellView from './classes/views/SellView.js'
import BuyView from './classes/views/BuyView.js'
import Datatable from './classes/Datatable'
import Notify from './classes/Notify.js'
import Views from './Views.js'
import Event from './Event.js'
import BuyModal from './modals/BuyModal.js'
import SellModal from './modals/SellModal.js'
import DetailsModal from './modals/DetailsModal.js'
import DeleteModal from './modals/DeleteModal.js'


export default class App {
	constructor (){
		this.notify = new Notify(this);
		
		this.event = new Event(this);
		
		this.datatables = {
			[DTN.GROUPED]: new Datatable(this, DTE.GROUPED, DTS.GROUPED),
			[DTN.BUY]: new Datatable(this, DTE.BUY, DTS.BUY),
			[DTN.SELL]: new Datatable(this, DTE.SELL, DTS.SELL),
			[DTN.DETAILS]: new Datatable(this, DTE.DETAILS, DTS.DETAILS),
		};

		this.views = new Views(this, {
			[TPN.GROUPED]: new GroupedView(this, TPE.GROUPED, TPA.GROUPED, TPN.GROUPED),
			[TPN.DETAILS]: new DetailsView(this, TPE.DETAILS, TPA.DETAILS, TPN.DETAILS),
			[TPN.BUY]: new BuyView(this, TPE.BUY, TPA.BUY, TPN.BUY),
			[TPN.SELL]: new SellView(this, TPE.SELL, TPA.SELL, TPN.SELL),
		});

		this.modals = {
			[MN.BUY] : new BuyModal(this, this.datatables[DTN.BUY]),
			[MN.SELL] : new SellModal(this, this.datatables[DTN.SELL]),
      [MN.DETAILS] : new DetailsModal(this, this.datatables[DTN.DETAILS]),
			[MN.DELETE] : new DeleteModal(this, null),
		}


		window.app = this;
	}
}