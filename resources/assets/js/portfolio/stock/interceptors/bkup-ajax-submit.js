function submitForm($form,$btn,success,fail){
    var data = $form.serialize();
    var url = $form.attr('action');
    var method = ($form.find('_method').length == 1 ) ? $form.find('_method').val() : $form.attr('method');
    $.ajax({
        method: method,
        url: url,
        data: data
    }).done(function(response) {
        if(response.error == false){
            $.notify({icon:'fa fa-bell',title: 'Success',message: response.message},NOTIFY_CONFIG).update('type','pastel-success');
            if(success !== undefined)  success(response);
        }else{
            $.notify({icon:'fa fa-warning',title: 'Warning', message: response.message},NOTIFY_CONFIG).update('type','pastel-warning');
            if(fail !== undefined)  fail(response);
        }
        toggleAjaxSubmitButtonIcon($btn,'i','ion-ios-plus-outline')
    }).fail(function(response) {
        if(response.status != 422){
            $.notify({icon:'fa fa-warning',title: 'Error: '+response.status, message: response.statusText},NOTIFY_CONFIG).update('type','pastel-danger');
        }
        toggleAjaxSubmitButtonIcon($btn,'i','ion-ios-plus-outline');

        if(fail !== undefined)  fail(response);
    });
}