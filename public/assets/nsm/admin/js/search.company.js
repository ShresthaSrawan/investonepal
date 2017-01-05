//search company
$('#company').selectize({
    valueField: 'id',
    labelField: 'name',
    searchField: 'name',
    create: false,
    render: {
        option: function(item, escape) {
            return ''+
            '<div>' +
            '<span class="title">' +
            '<span class="name">' + escape(item.name) + '</span>'+
            '</div>';
        }
    },
    load: function(query, callback) {
        if (!query.length) return callback();
        $.ajax({
            url: companySearchUrl,
            data: {company:query},
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