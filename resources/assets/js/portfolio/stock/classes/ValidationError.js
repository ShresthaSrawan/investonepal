import * as TEMPLATE from '../constants/template-html.js';

export default class ValidationError {
	constructor (animateIn, animateOut) {
		this.animateIn = animateIn;
		this.animateOut = animateOut;
		this.$el = null;
	}

	show (target, errors) {
		let description = this.getErrorList(errors);

        let html = Mustache.to_html(TEMPLATE.CALLOUT, {
            type: 'danger',
            description: description
        });

        this.$el = $(html);

        console.log(target, this.$el);

        this.$el.addClass(this.animateIn);

        let modalDiaglog = target.closest('.modal-dialog');

        /*if(modalDiaglog) {
        	modalDiaglog.removeClass('shake');

        	setTimeout(() => {
		        modalDiaglog.addClass('animated shake')
		        .css({animationDuration: '400ms'});

		        target.empty().append(this.$el);
        	}, 100);
        }else{
		    target.empty().append(this.$el);
        }*/
        
	    target.empty().append(this.$el);

        this.listenEvents(this.$el);
        this.autoClose(this.$el);
	}

	getErrorList (errors) {
		let keys = Object.keys(errors);
        let description = '<ul>';

        for (var i = keys.length - 1; i >= 0; i--) {
            description += '<li>' + errors[keys[i]] + '</li>';
        }

        description += '</ul>';

        return description;
	}

	autoClose ($el) {
		setTimeout(() => {
        	($el).alert('close');
        }, 10000);
	}

	listenEvents ($el) {
		let _this = this;

		$el.on('close.bs.alert', function (e) {
			e.preventDefault();
			$(this).removeClass(_this.animateIn).addClass(_this.animateOut);

			setTimeout(() => {
				$(this).remove();
			}, 300);
		})
	}
}