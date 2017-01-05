var count = 0;
$(document).ready(function () {
    //display the table below
    count = 0;
    table = $('#lastprice').DataTable({
        ajax: {
            url:lastpriceURL,
            type: 'POST',
            data: {
                sector: function(){return $('.sector').val()}
            }
        },
		processing: true,
        language: {
            processing: SPINNER
        },
        dom:'<"row"<"#sectorWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ifp>',
        "lengthMenu": [[100,200], [100,200]],
        columns: [
        {data: 'company.name'},
        {data: 'company.quote',name:'company.quote',render:function(name,type,row,meta){
            return "<a href='/quote/"+row.company.quote+"' target='_blank'>"+name+"</a>";
        }},
        {data: 'company.name',name:'company.name',render:function(name,type,row,meta){
            return "<a href='/quote/"+row.company.quote+"' target='_blank'>"+name+"</a>";
        }},
        {data: 'close',class:'text-right',searchable:false,render:function(data){
            return addCommas(data)
        }},
        {data: 'date',searchable:false},
        {data:'company.listed_shares',name:'listed_shares',searchable:false,render:function(data){
			if(data==0 || data==null || data=="")
				data="-"
			return addCommas(data);
		}},
        {data:'company.listed_shares',name:'listed_shares',searchable:false,render:function(data,type,row,meta){
			if(row.company.face_value*row.company.listed_shares==0)
				return "-"
            return addCommas(row.company.face_value*row.company.listed_shares);
        }},
        {data:'close',searchable:false,render:function(data,type,row,meta){
			if(row.close*row.company.listed_shares==0)
				return "-"
            return addCommas(row.close*row.company.listed_shares);
        }}
        ]
    });

    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        });
    }).draw();

    $('.sector').change(function(){
        count = 0;
        table.ajax.reload();
    });
    $(window).bind("resize load", function(){
        resizeWindow();
    });

    $('#sector-selector').appendTo('#sectorWrap');
});
function resizeWindow( e )
{
    var newWindowWidth = $(window).width();
    
    var snIndex = 0;
    var quoteIndex = 1;
    var nameIndex = 2;
    if(newWindowWidth > 992)
        var isCompanyNameVisible = true;
    else
        var isCompanyNameVisible = false;

    var isQuoteVisible = !isCompanyNameVisible;
    

    if(!(table===undefined))
    {
        table.column(nameIndex).visible(isCompanyNameVisible);
        table.column(quoteIndex).visible(isQuoteVisible);
        table.column(snIndex).visible(isCompanyNameVisible);
    }
}