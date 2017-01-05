$(document).ready(function(){
	$('.reportLabel').each(function(){
		$(this).chosen();
	});
	$(document).on('change','.reportLabel', function() {
		updateOptions()			
	});
	updateOptions();
});

$(document).on('click','.removeLabel',function(){
		$(this).parent().parent().slideUp(function() {
			$(this).remove();
		});
	});

$('.addReportLabel').on('click',function() {
	addLabel();

});

function addLabel()
{

	label = '<div class="form-group">';
	label += '<div class="col-md-4 col-md-offset-2 col-xs-10">';
	label += '\
			<select class="form-control reportLabel" name="reportLabel['+i+']" data-placeholder="Select a label.">\
				<option value=""></option>';
				$.each(options,function(k,v){
					label += '<option value="'+k+'">'+v+'</option>';
				});
			
	label += '</select></div>';
	label += '<div class="col-md-3 col-xs-10">';
	label += '<input type="number" name="value['+i+']" class="form-control" />';
	label += '</div>';
	label += '<div class="col-xs-1">';
	label += '<i class="fa fa-times fa-2x removeLabel"></i>';
	label += '</div>';
	label += '</div>';
	i++;
	$('.labels').append(label);
	$('.reportLabel:last').chosen();
	updateOptions();
}

function updateOptions () {
	var selects = $('.reportLabel');

    var selected = [];

    // add all selected options to the array in the first loop
    selects.find("option").each(function() {
        if (this.selected) {
            selected[this.value] = this;
        }
    })

    // then either disabled or enable them in the second loop:
    .each(function() {

        // if the current option is already selected in another select disable it.
        // otherwise, enable it.
        this.disabled = selected[this.value] && selected[this.value] !== this;
    });

    // trigger the change in the "chosen" selects
    selects.trigger("chosen:updated");
}