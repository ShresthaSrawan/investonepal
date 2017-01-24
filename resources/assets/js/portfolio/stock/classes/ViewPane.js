export default class ViewPane {
	constructor (app, element, anchor, datatableName, modal = null) {
		this.app = app;
		this.$el = $(element);
		this.$anchor = $(anchor);
		this.datatableName = datatableName;
		this.modal = modal;

		this.listenEvents();
	}

	datatable () {
		return this.app.datatables[this.datatableName];
	}

	show () {
		if(! this.datatable().isInitialized()) {
			this.datatable().run();
		}

		this.$anchor.tab('show');
	}

	listenEvents(){
		if(this.modal) this.modal.listenEvents(this.$el);
	}
}