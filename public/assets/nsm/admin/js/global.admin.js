$(document).ready(function(){
    //For Ajax CSRF token
    function in_array(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }

    var getTinyMceSettings = function(selector){
        return {
            selector : selector,
            theme: "modern",
            plugins: [
                "fullscreen advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern imagetools"
            ],
            menubar: false,
            toolbar1: "styleselect | alignleft aligncenter alignright alignjustify | forecolor backcolor  bullist numlist outdent indent",
            toolbar2: "bold italic underline | table anchor pagebreak insertdatetime charmap | fontselect |  fontsizeselect",
            toolbar3: "  link image preview fullscreen showblocks",
            image_advtab: true,
            formats: {
                alignleft: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left'},
                aligncenter: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center'},
                alignright: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right'},
                alignfull: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full'},
                bold: {inline: 'span', 'classes': 'bold'},
                italic: {inline: 'span', 'classes': 'italic'},
                underline: {inline: 'span', 'classes': 'underline', exact: true},
                strikethrough: {inline: 'del'},
                customformat: {inline: 'span', styles: {color: '#00ff00', fontSize: '20px'}, attributes: {title: 'My custom format'}}
            },
            fontsize_formats: "8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt"
        }
    };

      $(".submenu > a").click(function(e) {
        e.preventDefault();
        var $li = $(this).parent("li");
        var $ul = $(this).next("ul");

        if($li.hasClass("open")) {
          $ul.slideUp(350);
          $li.removeClass("open");
        } else {
          $(".nav > li > ul").slideUp(350);
          $(".nav > li").removeClass("open");
          $ul.slideDown(350);
          $li.addClass("open");
        }
      });

      var defDate = moment($('.datepicker input').val(),'YYYY-MM-DD');
      var defDateTime = moment($('.datetimepicker input').val(),'YYYY-MM-DD');

      $(".datepicker").datetimepicker({
          format: 'YYYY-MM-DD',
          daysOfWeekDisabled: [5,6],
          showTodayButton: true,
          minDate: moment("2000/01/01",'YYYY/MM/DD').format('YYYY-MM-DD'),
          maxDate: moment().format('YYYY-MM-DD'),
      });
      $(".datetimepicker").datetimepicker({
          format: 'YYYY-MM-DD LT',
          sideBySide: true,
          showTodayButton: true,
      });
      $('.datepicker').each(function(){
          $(this).data("DateTimePicker").date(defDate);
      })
      $('.datetimepicker').each(function(){
          $(this).data("DateTimePicker").date(defDateTime);
      });
  
});

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