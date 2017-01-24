const Template = $('#stock-buy-create-update-modal').html();

export default class Modal {
	constructor (app, datatable = null) {
        this.app = app;
        this.datatable = datatable;
        this.$el = null;
        this.isOpen = false;
        this.form = null;

        this.listenEvents();
	}

    eventTriggered (eventName) {
        this.app.eventTriggered(eventName);

        return this;
    }

	open (callback) {
        if(this.isOpen || !this.$el) return;

        let _this = this;

        this.isOpen = true;

        this.$el.on('hide.bs.modal', function (e) {
            e.preventDefault();
            console.info('Closing Modal');
            $(this).toggleClass('fadeIn fadeOut');

            setTimeout(() => {
                $('body').removeClass('modal-open');
                
                _this.$el = null;
                _this.isOpen = false;
                
                $(this).remove();
            }, 300);
            
        }).modal({keyboard: true, backdrop: false});

        if(callback) callback();
	}

    close () {
        this.$el.modal('hide');
    }

    listenEvents(){}
}