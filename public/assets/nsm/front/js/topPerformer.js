$(document).ready(function () {
	$(".datepicker").data("DateTimePicker").date(lastDate);
    //display the table below

    $('#perform').click(function(){
        loadPerformer();
    });
    $('#loss').click(function(){
        loadLoser();
    });
    loadGainer();
    
    $('.datepicker').on("dp.change", function (e) {
        if(!(table1===undefined)) table1.ajax.reload();
        if(!(table2===undefined)) table2.ajax.reload();
        if(!(table3===undefined)) table3.ajax.reload();
    });

    $(window).bind("resize load", function(){
        resizeWindow();
    });

    //functions
    function loadPerformer() {
        if(table3===undefined){
            table3 = $('.mostactive').DataTable({
                processing: true,
                serverSide: false,
                paging: false,
                info: false,
                language: {
                            processing: SPINNER
                        },
                bFilter: false,
                order:[[3,'desc']],
                ajax: {
                    url: activeURL,
                    type: 'POST',
                    data: {
                        date: function () {
                            return $('.searchdate').val()
                        }
                    }
                },
                columns: [
                    {data: 'name'},
                    {data: 'quote',visible:false},
                    {data: 'name',render:function(data,type,row,meta){
                        return '<a href="/quote/'+row.quote+'" target="_blank">'+data+'</a>';
                    }},
                    {data: 'tran_count',render:function(data){
                        return addCommas(data);
                    }},
                    {data: 'close',render:function(data){
                        return addCommas(data);
                    }},
                    {data: 'volume',render:function(data){
                        return addCommas(data);
                    }},
                    {data: 'amount',render:function(data){
                        return addCommas(data);
                    }},
                    {data: 'previous',render:function(data){
                        return addCommas(data);
                    }},
                    {data: 'difference',render:function(data){
                        if(data===null) return 'N/A';
                        
                        change = "neutral";
                        if(eval(data)>0)
                            change = "up";
                        else if(eval(data)<0)
                            change = "down";
                        return "<span data-change="+change+">"+addCommas(data)+"</span>";
                    }},
                    {data: 'percentage',render:function(data){
                        if(data===null) return 'N/A';
                        
                        change = "neutral";
                        if(eval(data)>0)
                            change = "up";
                        else if(eval(data)<0)
                            change = "down";
                        return "<span data-change="+change+">"+data+"</span>";
                    }},
                ]
            });
            table3.on( 'order.dt search.dt', function () {
                table3.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                })
            });
            resizeWindow();
        } 
    }
    function loadLoser() {
        if(table2===undefined){
            table2 = $('.loser').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
            language: {
                            processing: SPINNER
                        },
            info: false,
            bFilter: false,
            order:[[9,'asc']],
            ajax: {
                url: loserURL,
                type: 'POST',
                data: {
                    date: function () {
                        return $('.searchdate').val()
                    }
                }
            },
            columns: [
            {data: 'name'},
            {data: 'quote',visible:false},
            {data: 'name',render:function(data,type,row,meta){
                return '<a href="/quote/'+row.quote+'" target="_blank">'+data+'</a>';
            }},
            {data: 'tran_count',render:function(data){
                        return addCommas(data);
                    }},
            {data: 'close',render:function(data){
                        return addCommas(data);
                    }},
            {data: 'volume',render:function(data){
                        return addCommas(data);
                    }},
            {data: 'amount',render:function(data){
                return addCommas(data);
            }},
            {data: 'previous',render:function(data){
                        return addCommas(data);
                    }},
            {data: 'difference',render:function(data){
                return "<span data-change='down'>"+addCommas(data)+"</span>";
            }},
            {data: 'percentage',render:function(data){
                return "<span data-change='down'>"+data+"</span>";
            }}
            ]
            });
            table2.on( 'order.dt search.dt', function () {
                table2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                })
            });
            resizeWindow();
        }
    }
    function loadGainer() {
        if(table1===undefined){
            table1 = $('.gainer').DataTable({
                processing: true,
                serverSide: false,
                paging: false,
                info: false,
                language: {
                            processing: SPINNER
                        },
                bFilter: false,
                order:[[9,'desc']],
                ajax: {
                    url: gainerURL,
                    type: 'POST',
                    data: {
                        date: function () {
                            return $('.searchdate').val()
                        }
                    }
                },
                columns: [
                {data: 'name'},
                {data: 'quote',visible:false},
                {data: 'name',render:function(data,type,row,meta){
                    return '<a href="/quote/'+row.quote+'" target="_blank">'+data+'</a>';
                }},
                {data: 'tran_count',render:function(data){
                        return addCommas(data);
                    }},
                {data: 'close',render:function(data){
                        return addCommas(data);
                    }},
                {data: 'volume',render:function(data){
                        return addCommas(data);
                    }},
                {data: 'amount',render:function(data){
                    return addCommas(data);
                }},
                {data: 'previous',render:function(data){
                        return addCommas(data);
                    }},
                {data: 'difference',render:function(data){
                    return "<span data-change='up'>"+addCommas(data)+"</span>";
                }},
                {data: 'percentage',render:function(data){
                    return "<span data-change='up'>"+data+"</span>";
                }}
                ]
            });
            table1.on( 'order.dt search.dt', function () {
                table1.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                })
            });
            resizeWindow();
        }
    }
    function resizeWindow( e )
    {
        var newWindowWidth = $(window).width();
        var mobileVisibleIndex = [1,3,4,5,6,9];
        var desktopVisibleINdex = [0,2,3,4,5,6,7,8,9];

        if(newWindowWidth > 992) currentView = desktopVisibleINdex; else currentView = mobileVisibleIndex;

        var activeTables = [table1,table2,table3];
        $.each(activeTables,function(k,t){
            if(!(t===undefined))
            {
                t.columns().eq(0).each(function(index){
                    var isVisible = !($.inArray(index,currentView)==-1);
                    t.column(index).visible(isVisible);
                });
            }
        });
    }
});