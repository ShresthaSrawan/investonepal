var budgetType = 0;
var subLabelPlaceHolder = $('.subLabelPlaceHolder');
var budgetLabelPlaceHolder = $('.budgetLabelPlaceHolder');
var budgetSubmitPlaceHolder = $('#budgetSubmitPlaceHolder');
var postIDCache = (typeof(budgetID) !== 'undefined') ? budgetID : [];

$(document).ready(function(){
    var $showSubLabel = $('#showSubLabel');
    var $selectBudgetLabel = $('select[name=budgetLabel]');

    $showSubLabel.click(function(){
        loadBudgetSubLabel($selectBudgetLabel);
    });

    $(document).on('click','.remove-panel',function(){
        var $panel = $(this).parents('.budget-panel');
        var id = $panel.data('id');
        var index = $.inArray(id,postIDCache);

        //remove from id cache
        postIDCache.splice(index, 1);
        $panel.remove();
    });

    $(document).on('click','.removeSubLabel',function(){
        var $prevInput = $(this).parent().prev();
        if($prevInput.prop('disabled') == true){
            $prevInput.prop('disabled',false);
            $(this).children('i').removeClass('fa-plus');
            $(this).children('i').addClass('fa-remove');

            //$inputNode = $(this).parent().children('input[type=number]'); TODO

        }else{
            $prevInput.prop('disabled',true);
            $(this).children('i').removeClass('fa-remove');
            $(this).children('i').addClass('fa-plus');
        }

        calculateTotal($(this).parent().prev());
    });

    $(document).on('click','#updateBudget',function(e){
        e.preventDefault();
        $('.validationError').remove();
        $.each($('form .form-control'), function(index,input){
            if(!$(input).prop('disabled')){
                validateInput($(input));
            }
        });

        var isFormReady = function(){
            return $('.validationError').length == 0;
        };

        isFormReady() ? $(this).parents('form').submit() : '' ;


    });

    $(document).on('keyup','input[type=number]',function(){
        if($.isNumeric($(this).val())){
            calculateTotal($(this));
        }
    });
});

var validateInput = function(element){
    $helpText = $('<div class="text-danger col-lg-7 col-lg-offset-4 validationError"><i class="fa fa-close"></i> This field is required and should be valid number.</div>');
    if(!$.isNumeric(element.val())){
        element.parent().after($helpText);
    }
};

var calculateTotal = function(self){
    var totalBudget = 0;
    var id = self.data('id');

    $.each($('input[data-id='+id+']'),function(index,node){
        value = $(node).prop('disabled') ? 0 : parseFloat($(node).val());
        if(!isNaN(value)){
            totalBudget += value;
            $('button[data-class=budget'+id+']').children('code').text(totalBudget)
        }
    });
};

var loadBudgetSubLabel = function(budgetLabel){
    console.log(postIDCache);
    if(in_array(budgetLabel.val(),postIDCache) == true){
        return;
    }else{
        var index = postIDCache.length;
        postIDCache[index] = budgetLabel.val();
        index++;
    }

    $.post(budgetLabelSearchUrl,{id:budgetLabel.val()},function(data){
        var html = '<div class="panel panel-default budget-panel" data-id="'+budgetLabel.val()+'"><div class="panel-heading">'+budgetLabel.children('option:selected').text()+'<button class="btn btn-xs btn-danger pull-right remove-panel" type="button"><i class="fa fa-remove"></i></button><button class="btn btn-xs pull-right total-budget" type="button" data-class="budget'+budgetLabel.val()+'">Total: NRS.<code>0</code></button></div><div class="panel-body">';
        if(data.error == false){
            $.each(data.message, function(index,value){
                html += '<div class="form-group">'+
                    '<label class="control-label col-lg-4" for="subLabel['+index+']">'+value+'</label>'+
                    '<div class="input-group col-lg-7">'+
                    '<input type="number" class="form-control budget'+budgetLabel.val()+'" name="value['+budgetLabel.val()+']['+index+']" step="any" data-id="'+budgetLabel.val()+'">'+
                    '<span class="input-group-btn">'+
                    '<button class="btn btn-default removeSubLabel" type="button" id="showSubLabel"><i class="fa fa-remove"></i></button>'+
                    '</span>'+
                    '</div>'+
                    '</div>';
            });

            html += '</div></div>';

            subLabelPlaceHolder.append(html);
        }else{
            if($('#budgetLabelPanel').length == 0){
                budgetLabelPlaceHolder.append('<div class="panel panel-default"><div class="panel-heading">Budget Label without Sub Labels</div><div class="panel-body" id="budgetLabelPanel"></div></div>');
            }

            var $budgetTotal = $('<div class="form-group" id="budget'+budgetLabel.val()+'">'+
                '<label class="control-label col-lg-3">'+budgetLabel.children('option:selected').text()+'</label>'+
                '<div class="input-group col-lg-8">'+
                '<input type="number" class="form-control" name="budgetTotal['+budgetLabel.val()+']" step="any">'+
                '<span class="input-group-btn">'+
                '<button class="btn btn-default removeSubLabel" type="button" id="showSubLabel"><i class="fa fa-remove"></i></button>'+
                '</span>'+
                '</div></div>');

            $('#budgetLabelPanel').append($budgetTotal);
        }
    });
};