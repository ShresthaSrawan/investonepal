//For Datatable sort and paginations
$(document).ready(function() {
    $('.datatable').dataTable({
        paging: true
    });
} );

//For checkbox function
$(document).on('click','.selectAll',function () {
  checked = this.checked;
  $(this).closest('table').find('.selectedId').each(function(){
    $(this).prop('checked', checked);
  });
});

$(document).on('click','.datatable tr',function(){
  checkbox = $(this).find('input.selectedId');
  var check = checkbox.prop("checked");
  checkbox.prop('checked',!check);
})

$('.selectedId').change(function () {
    var check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
    $(this).closest('.selectAll').prop("checked", check);
});
$('.selectedId,.selectAll').click(function(){
    var flag=0;
    $('.selectedId').closest('table').find('.selectedId').each(function(){
        if($(this).prop('checked')) flag=1;
    });
    if(flag==0){
        $('#view').addClass('disabled');
    }else{
        $('#view').removeClass('disabled');
    };
});
$('#dept_id').change(function(){
    if ($(this).val() == 0) {
        $('#view').addClass('disabled');
    } else {
        $('#view').removeClass('disabled');
    }
});

//check for null checkboxes for delete
$('.deletebtn').on('click',function(){
    var flag=0;
    $( ":checkbox" ).each(function(){
        if($(this).is(':checked'))
            flag=1;
    })
    if(flag==0){
        $('.notselected').fadeIn('fast').delay(3000).fadeOut('fast');
        return false;
    }
    else
    {
        $('.notselected').hide();
    }

});
