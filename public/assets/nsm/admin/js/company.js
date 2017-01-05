$(document).ready(function(){
    tinymce.init(getTinyMceSettings('.editor'));


    if(!$('#listed').is(':checked')){
        $('.shares, .facevalue').prop('disabled', true);
    }
    $('.shares, .facevalue').on('blur',function() {
        calculateTotalPaidUpValue();
    })
    calculateTotalPaidUpValue();
});
$('#listed').on('click',function(){
    if(!$(this).is(':checked'))
    {
        $('#listed_shares, #face_value').prop('disabled', true);
    }
    else
    {
        $('#listed_shares, #face_value').prop('disabled', false);
    }
});

$(document).ready(function(){
    $('input').iCheck({
       checkboxClass: 'icheckbox_square-green',
    });    
});

$(document).on('ifChecked','input#listed',function(){
    $('#listed_shares, #face_value').removeProp('disabled');
});

$(document).on('ifUnchecked','input#listed',function(){
    $('#listed_shares, #face_value').prop('disabled',true);
});

function calculateTotalPaidUpValue () {
    shares =  parseFloat($('.shares').val());
    facevalue = parseFloat($('.facevalue').val());
    $('#total_paid_up_value').prop('value',shares*facevalue);
}