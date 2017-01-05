$(document).ready(function(){
    tinymce.init(getTinyMceSettings('.editor'));
    
    if(!$('#event').is(':checked')){
        $('.eventdate').prop('disabled', true);
    }
    
    $('#event').on('click',function(){
        if(!$(this).is(':checked'))
        {
            $('.eventdate').prop('disabled', true);
        }
        else
        {
            $('.eventdate').prop('disabled', false);
        }
    });

    $('input').iCheck({
       checkboxClass: 'icheckbox_square-green',
    });
    
    changeOption();      

    //tags select
    $("#tags").chosen({
      create_option: true,
      persistent_create_option: true,
      skip_no_results: true
    });
});

$(document).on('ifChecked','input#event',function(){
    $('#event_date').removeProp('disabled');
});

$(document).on('ifUnchecked','input#event',function(){
    $('#event_date').prop('disabled',true);
});

$('#newsCategory').change(function(){
    changeOption();
});

function changeOption() {
    var companyList = $('#companyList');
    var bullionList = $('#bullionList');
    if($("#newsCategory option:selected").text().toLowerCase()=="stock")
    {
      companyList.removeClass('hide');
      companyList.children('select').prop('disabled',false);
      bullionList.addClass('hide');
      bullionList.children('select').prop('disabled',true);

    }
    else if($("#newsCategory option:selected").text().toLowerCase()=="bullion")
    {
      companyList.addClass('hide');
      companyList.children('select').prop('disabled',true);
      bullionList.removeClass('hide');
      bullionList.children('select').prop('disabled',false);
    }else
    {
      companyList.addClass('hide');
      companyList.children('select').prop('disabled',true);
      bullionList.addClass('hide');
      bullionList.children('select').prop('disabled',true);
    }
}