//search budgetLabel
function myselectize(selector) {
    $(selector).selectize({
        valueField: 'id',
        labelField: 'label',
        searchField: 'label',
        create: false,
        render: {
            option: function(item, escape) {
                return ''+
                '<div>' +
                '<span class="title">' +
                '<span class="name">' + escape(item.label) + '</span>'+
                '</div>';
            }
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: budgetLabelSearchUrl,
                data: {budgetLabel:query,budgetType:budgetType},
                type: 'POST',
                error: function() {
                    callback();
                },
                success: function(res) {
                    callback(res);
                }
            });
        }
    });
}