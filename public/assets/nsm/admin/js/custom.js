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
            "lineheight fullscreen advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools"
        ],
        menubar: false,
        toolbar1: "styleselect | alignleft aligncenter alignright alignjustify | forecolor backcolor  bullist numlist outdent indent",
        toolbar2: "bold italic underline | table anchor pagebreak insertdatetime charmap | fontselect |  fontsizeselect",
        toolbar3: "link image preview fullscreen showblocks lineheightselect",
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
        fontsize_formats: "8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt",
        lineheight_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt"
    }
};