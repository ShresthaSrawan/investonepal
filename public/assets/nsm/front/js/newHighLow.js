var table1,table2;
$(document).ready(function(){
	$(".datepicker").data("DateTimePicker").date(lastDate);
	
    loadNewHigh();

    $('#newlo').click(function(){
        loadNewLow();
    });
});

function loadNewHigh() {
    if(table1===undefined){
    table1 = $('.datatable.newhigh').DataTable({
            processing: true,
            paging: false,
            bFilter: false,
            info: false,
            language: {
                        processing: SPINNER
                    },
            serverSide: false,
            ajax: {
                url:newHighURL,
                type: 'POST',
                data: {date: function(){return $('.searchdate').val()}}
            },
            columns: [
                {data: 'name'},
                {data: 'name', name: 'name',render:function(name,type,row,meta) {
                    return "<a href=/quote/"+row.quote+" target='_blank'>"+name+"</a>";
                }},
                {data: 'high', name: 'high',class:'text-right',render:function(data){
                    return addCommas(data);
                }}
            ]
        });
    table1.on( 'order.dt search.dt', function () {
            table1.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
}
}
function loadNewLow() {
    if(table2===undefined){
    table2=$('.datatable.newlow').DataTable({
            processing: true,
            paging: false,
            bFilter: false,
            info: false,
            language: {
                        processing: SPINNER
                    },
            serverSide: false,
            ajax: {
                url:newLowURL,
                type: 'POST',
                data: {date: function(){return $('.searchdate').val()}}
            },
            columns: [
                {data: 'name'},
                {data: 'name', name: 'name',render:function(name,type,row,meta) {
                    return "<a href=/quote/"+row.quote+" target='_blank'>"+name+"</a>";
                }},
                {data: 'low', name: 'low',class:'text-right',render:function(data){
                    return addCommas(data);
                }}
            ]
        });
    table2.on( 'order.dt search.dt', function () {
            table2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
}
}
        $('.datepicker').on("dp.change",function(){
            if(!(table1===undefined))table1.ajax.reload();
            if(!(table2===undefined))table2.ajax.reload();
        });