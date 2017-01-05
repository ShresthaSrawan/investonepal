$(document).ready(function(){
	$(".datepicker").data("DateTimePicker").date(lastDate);
	
    table = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        language: {
            processing: SPINNER
        },
        scrollX:true,
        dom:'<"row"<"#dateWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ifp>',
        "lengthMenu": [[100, 300, 600], [100, 300, 600]],
        ajax: {
            url:floorsheetURL,
            type: 'POST',
            data: {
                date: function(){return $('.searchdate').val()},
                company: function(){
                    var company = $('.company').val();
                    if(!(company===undefined))
                        return company;
                    else 
                        return "";
                },
                quote: function(){
                    var quote = $('.quote').val();
                    if(!(quote===undefined))
                        return quote;
                    else 
                        return "";
                },
                buyer_broker: function(){return $('.buyer_broker').val()},
                seller_broker: function(){return $('.seller_broker').val()}
            }
        },
        columns: [
        {data: 'n'},
        {data: 'q'},
        {data: 'n','visible':true,render:function(data,type,row,meta){
            return '<a href="/quote/'+row.q+'" target="_blank">'+data+'</a>';
        }},
        {data: 'b', name: 'b'},
        {data: 's', name: 's'},
        {data: 'qt', name: 'qt',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
        {data: 'r', name: 'r',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
        {data: 'a', name: 'a',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }}
        ]
    });
    // Apply the filter
    $("#filterrow input").change(function(){
        table.ajax.reload();
    });
    $('.datepicker').on('dp.change',function(){
        table.ajax.reload();
    });
    $('.dataTables_filter').hide();

    table.on( 'order.dt search.dt page.dt draw.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        });
    }).draw();
    
    $('#mydate').appendTo('#dateWrap');

    //dynamically hide columns
    $(window).bind("resize load", function(){
        resizeWindow();
    });

});
function resizeWindow( e )
{
    var newWindowWidth = $(window).width();
    var mobileVisibleIndex = [1,3,4,5,6,7];
    var desktopVisibleINdex = [0,1,2,3,4,5,6,7];

    if(newWindowWidth > 992) currentView = desktopVisibleINdex; else currentView = mobileVisibleIndex;
    table.columns().eq(0).each(function(index){
        var isVisible = !($.inArray(index,currentView)==-1);
        table.column(index).visible(isVisible);
    });
}
function stopPropagation(evt) {
    if (evt.stopPropagation !== undefined) {
        evt.stopPropagation();
    } else {
        evt.cancelBubble = true;
    }
}