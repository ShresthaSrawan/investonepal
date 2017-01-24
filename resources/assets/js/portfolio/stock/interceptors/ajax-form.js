export default class AjaxForm {
    constructor (form) {
        this.form = form;
        this.successCallback = null;
        this.failCallback = null;
    }

    onSucess (successCallback) {
        this.successCallback = successCallback;
    }

    onFail () {
        this.failCallback = failCallback;
    }

    toggleButton () {
        let btn = this.form.find(['button[type=submit]']);
        let icon = btn.find('i');

        btn.prop('disabled', !btn.prop('disabled'));

        if(!icon) return this;  

        if(icon.data('icon')) {            
            icon.removeClass('fa fa-spinner fa-pulse')
                .addClass(icon.data('icon'))
                .removeAttr('data-icon');

        }else {
            let icon_class = icon.attr('class');

            icon.data('icon', icon_class)
                .removeClass(icon_class)
                .addClass('fa fa-spinner fa-pulse');
        }

        return this;
    }

    submit (id) {
        this.toggleButton();

        let data = form.serialize();
        let url = form.attr('action');
        let method = form.find('input[name="_method"]').val();

        if(id) url += '/' + id;
        if(!method) method = form.attr('method');

        $.ajax({method,url,data})
        .done((response, a, b, c) => {
            console.log(response, a, b, c);
            if(this.successCallback) this.successCallback(response);
        })
        .fail((response, a, b, c) => {
            console.log(response, a, b, c);
            if(this.failCallback) this.failCallback(response);
        })
        .always((response) => {
            this.toggleButton()
        });
    }
}