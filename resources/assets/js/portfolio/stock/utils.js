import AjaxForm from './classes/AjaxForm.js';

export function ajaxForm(app, form, id) {
	return new AjaxForm(app, form, id);
}