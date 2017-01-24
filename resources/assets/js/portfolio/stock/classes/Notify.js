const DEFAULT_NOTIFY_OPTIONS = {
	allow_dismiss: true,
	newest_on_top: true,
	placement: {
		from: "bottom",
		align: "right"
	},
    offset: 20,
    spacing: 10,
    z_index: 9999,
    delay: 5000,
    timer: 1000,
    type: 'info',
    mouse_over: 'pause'
};

export default class Notify {
	constructor (app, options = {}) {
		this.app = app;
		this.notifications = {};
		this.options = $.extend({},DEFAULT_NOTIFY_OPTIONS, options)
	}

	info (message, title = 'Info') {
		this.show({icon: 'fa fa-info', title: title, message: message}, 'info')
		return this;
	}
	success (message, title = 'Success') {
		this.show({icon: 'fa fa-bell', title: title, message: message}, 'success')
		return this;
	}
	warning (message, title = 'Warning') {
		this.show({icon: 'fa fa-warning', title: title, message: message}, 'warning')
		return this;
	}
	danger (message, title = 'Danger') {
		this.show({icon: 'fa fa-warning', title: title, message: message}, 'danger')
		return this;
	}
	show (data, type) {
		this.push(type, data);
		$.notify(data, this.options).update('type','pastel-' + type);
	}
	push (type, {message}) {
		this.notifications[type] = this.notifications[type] || [];
		this.notifications[type].push({
			time: moment().format('h:m A'),
			message: message
		});
	}
	list() {
		return this.notifications
	}
}

