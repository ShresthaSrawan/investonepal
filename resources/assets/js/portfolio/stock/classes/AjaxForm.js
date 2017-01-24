import ValidationError from './ValidationError.js';

export default class AjaxForm {
    constructor (app, form, id = null) {
        this.id = id;
        this.app = app;
        this.form = form;
        this.successCallback = null;
        this.failCallback = null;
        this.validationError = new ValidationError('flipInX', 'flipOutX');

        this.listenEvents();
    }

    notify () {
        return this.app.notify;
    }

    onSuccess (successCallback) {
        this.successCallback = successCallback;

        return this;
    }

    onFail (failCallback) {
        this.failCallback = failCallback;

        return this;
    }

    showValidationErrors (errors) {
        this.validationError.show(
            this.form.find('.form-errors'), 
            errors
        );
    }

    listenEvents () {
        this.form.on('submit', (e) => {
            e.preventDefault();
            this.submit();
        })
    }

    submit () {
        this.toggleButton();

        let data = this.form.serialize();
        let url = this.form.attr('action');
        let method = this.form.find('input[name="_method"]').val();

        console.log(url);

        if(this.id) url += '/' + this.id;
        if(!method) method = this.form.attr('method');

        $.ajax({method,url,data})
        .done((response) => {
            if(response.error) {
                if(response.message) this.notify().warning(response.message);
                if(this.failCallback) this.failCallback(response);
            }else {
                if(response.message) this.notify().success(response.message);
                if(this.successCallback) this.successCallback(response);
            }
        })
        .fail((response) => {
            if(response.status === 422){
                this.showValidationErrors(response.responseJSON);
            }else {
                this.notify().danger(response.statusText);
            }

            if(this.failCallback) this.failCallback(response);
        })
        .always((response) => {
            this.toggleButton()
        });
    }

    toggleButton () {
        let btn = this.form.find('button[type=submit]');
        let icon = btn.find('i');

        btn.prop('disabled', !btn.prop('disabled'));

        if(!icon.length) return this;

        if(icon.data('icon')) {
            icon.removeClass('fa fa-spinner fa-pulse')
                .addClass(icon.data('icon'))
                .removeData('icon');
        }else {
            let icon_class = icon.attr('class');

            icon.data('icon', icon_class)
                .removeClass(icon_class)
                .addClass('fa fa-spinner fa-pulse');
        }

        return this;
    }
}