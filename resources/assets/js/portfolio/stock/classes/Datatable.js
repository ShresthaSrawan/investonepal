const SETTINGS = {
    processing: true,
    paging: true,
    serverSide: true,
    aLengthMenu: [[50, 100, 150, 200], [50, 100, 150, 200]],
    iDisplayLength: 50,
    drawCallback () {
        $(window).trigger('resize');
    }
};

export default class Datatable {
	/**
	 * constructor() Datatable class contructor
	 * @param {App} app
	 * @param {DOMElement} element, table element to initialize DataTable on
	 * @param {Object} settings, DataTable settings
	 */
	constructor (app, element, settings = {}) {
		this.app = app;
		this.$el = $(element);
		this.settings = settings;
		this.datatable = null;
		this.initialized = false;
	}

	/**
	 * getSettings() extends DEFAULT_SETTINGS 
	 * param {Object} settings to overwrite or extend
	 * @return {Object} DataTable settings
	 */
	getSettings (settings) {
		return $.extend({}, SETTINGS, settings);
	}

	/**
	 * run() initialize DataTable
	 * @return {Datatable}
	 */
	run () {
		if(this.datatable) {
			this.reload();
		}else {
			this.datatable = this.$el.DataTable(
				this.getSettings(this.settings)
			);

			this.initialized = true;
		}
		
		return this;
	}

	/**
	 * reload() refetch and redraw DataTable
	 * @return {Datatable}
	 */
	reload () {
		if(this.datatable) {
			this.datatable.ajax.reload()
		}

		return this;
	}

	isInitialized () {
		return this.initialized;
	}

	json () {
		return this.datatable ? this.datatable.ajax.json() : null
	}

	find (key, value, strict = false) {
		let json = this.json();

		if(!json || !json.recordsFiltered) return null;

		for (var i = json.data.length - 1; i >= 0; i--) {
			if(strict && json.data[i][key] === value) {
				return json.data[i];
			}else if (!strict && json.data[i][key] == value){
				return json.data[i];
			}
		}

		return null;
	}
} 