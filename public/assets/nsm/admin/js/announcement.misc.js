var cache = [];
var $subtype = $('#subtype_id');
var $type = $('#type_id');
$(document).ready(function(){
    loadSubtype(getTypeVal());
    $type.chosen();
    $subtype.chosen();
});

$type.change(function(){
    loadSubtype(getTypeVal());
});

var loadSubtype = function(id,reload){
    if(!in_array(id,cache) || reload == true){
        $.post(URL,{id:id}, function(data){
            cache[id] = data;
            showSubType(cache[id]);
        }).done(function(data){
            selectOption();
        })
    }else{
        showSubType(cache[id]);
    }
};
var selectOption = function(){
    var $subtype = $('#subtype_id');
    var old = $subtype.data('old');
    if(old !== undefined && old != ''){
        $subtype.val(old);
        $subtype.trigger("chosen:updated");
    }
};
var getTypeVal = function(){
    return $('#type_id').val();
};

var showSubType = function(data){
    html = '';
    $.each(data,function(index,type){
        html += '<option value="'+type.id+'">'+type.label+'</option>';
    });

    if(html == ''){
        $subtype.prop('disabled',true);
        $subtype.html(html);
    }else{
        $subtype.prop('disabled',false);
        $subtype.html(html);
    }
    $subtype.trigger("chosen:updated");
};