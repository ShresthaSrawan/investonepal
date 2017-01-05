$('.sidebar-toggle').click(function(){
    setTimeout(function(){
        $(window).trigger('resize');
    },500);
});

function getDataChange (value) {
    this.dataChange = 'neutral';
    if(value > 0){ this.dataChange = 'up'; }
    else if(value < 0){ this.dataChange = 'down'; }

    return this.dataChange;
}
var NOTIFY_CONFIG = { allow_dismiss: true, newest_on_top: true, placement: { from: "bottom", align: "right" },
    offset: 20,spacing: 10,z_index: 9999,delay: 5000,timer: 1000,type: 'info',mouse_over: 'pause'
};

function floatParse (string,fractionDigits) {
  if(typeof fractionDigits == 'undefined'){ fractionDigits = 2}
  return parseFloat(string).toFixed(fractionDigits);
}

function percentify(change,investment){
  if(investment == 0 || investment == null){
    return '<span data-change="'+getDataChange(change)+'">'+floatParse(change)+'</span>';
  }
  this.percent = floatParse(change * 100 / investment);
  return '<span data-change="'+getDataChange(change)+'">'+floatParse(change)+'  <small>('+floatParse(this.percent)+'%)</small></span>';
}

// jQuery plugin to prevent double submission of forms
jQuery.fn.preventDoubleSubmission = function() {
  $(this).on('submit',function(e){
    var $form = $(this);

    if ($form.data('submitted') === true) {
      // Previously submitted - don't submit again
      e.preventDefault();
    } else {
      // Mark it so that the next submit can be ignored
      $form.data('submitted', true);
    }
  });

  // Keep chainability
  return this;
};

$('form').preventDoubleSubmission();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});