var marketCapData = [];
var sharesData = [];
var amountData = [];
var categoriesData = [];
$(document).ready(function () {
	//setting fromdate and todate
	$("#fromdatepicker").data("DateTimePicker").date(fromDate);
	$("#todatepicker").data("DateTimePicker").date(toDate);
	
    //for linked date picker
    $('#fromdatepicker').datetimepicker({
        format: "YYYY-MM-DD",
        maxDate:maxdate
    });
    $('#todatepicker').datetimepicker({
        format: "YYYY-MM-DD",
        useCurrent: false, //Important! See issue #1075
        minDate:mindate
    });
    //end of datepicker linking

    $('#sector').prop('disabled', true).parent().hide();
    loadMarketSummary();

    $(document).on('click', 'a[href="#summary"][aria-expanded!="true"]', function () {
        $('#sector').prop('disabled', false).parent().hide();
        loadMarketSummary();
    });
    $(document).on('click', 'a[href="#report"][aria-expanded!="true"]', function () {
        $('#sector').prop('disabled', false).parent().show();
        loadReport();
        resizeWindow();
    });
    $(document).on('click', 'a[href="#gainer"][aria-expanded!="true"]', function () {
        $('#sector').prop('disabled', false).parent().show();
        loadGainer();
        resizeWindow();
    });
    $(document).on('click', 'a[href="#loser"][aria-expanded!="true"]', function () {
        $('#sector').prop('disabled', false).parent().show();
        loadLoser();
        resizeWindow();
    });
    $(document).on('click', 'a[href="#active"][aria-expanded!="true"]', function () {
        $('#sector').prop('disabled', false).parent().show();
        loadActive();
        resizeWindow();
    });
    $(document).on('click', 'a[href="#turnover"][aria-expanded!="true"]', function () {
        $('#sector').prop('disabled', false).parent().show();
        loadTurnover();
        resizeWindow();
    });
    $(document).on('click', 'a[href="#sectorwise"][aria-expanded!="true"]', function () {
        $('#sector').prop('disabled', true).parent().hide();
        loadSectorwise();
        resizeWindow();
    });
    $(document).on('click', 'a[href="#index"][aria-expanded!="true"]', function () {
        $('#sector').prop('disabled', true).parent().hide();
        loadIndex();
        loadIndexSummary();
    });
    $('#sector').change(function () {
        refreshData();
    });
    $("#fromdatepicker").on("dp.change", function (e) {
        $('#todatepicker').data("DateTimePicker").minDate(e.date);
        refreshData();
    });
    $("#todatepicker").on("dp.change", function (e) {
        $('#fromdatepicker').data("DateTimePicker").maxDate(e.date);
        refreshData();
    });
    $(window).bind("resize load", function(){
        resizeWindow();
    });
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } );
});
function loadReport() {
    count = 0;
    if (table['report'] === undefined) {
        table['report'] = $('#reportDatatable').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
			responsive:false,
			autoWidth: false,
            language: {
                processing: SPINNER
            },
            info: false,
            "lengthMenu": [[100, 300, 600], [100, 300, 600]],
            scrollX:true,
            ajax: {
                url: todaysPriceURL,
                type: 'POST',
                data: {
                    fromdate: function () {
                        return $('#fromdate').val()
                    },
                    todate: function () {
                        return $('#todate').val()
                    },
                    sector: function () {
                        return $('#sector').val()
                    },
                }
            },
            columns: [
                {data: 'quote',render:function(data,type,row,meta){
                    return '<a href="/quote/'+data+'" target="_blank" title="'+row.name+'">'+data+'</a>';
                }},
                {data: 'tran_c', searchable: false,class:'text-right', render: function (data) {
                        return addCommas(data);
                }},
                {data: 'open_c', searchable: false,class:'hidden-xs hidden-sm text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'high_c', searchable: false,class:'hidden-xs hidden-sm text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'low_c', searchable: false,class:'hidden-xs hidden-sm text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'close_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'volume_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'amount_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'cap_c', searchable: false,class:'hidden-xs hidden-sm text-right', render: function (data) {
                    return addCommas((parseFloat(data)/1000000).toFixed(2))
                }},
                {data: 'diff_c', searchable: false,class:'text-right', render: function (data) {
                    var chg = data;
                    var sign='';
                    if(chg>0) sign = 'up';
                    else if(chg<0) sign = 'down';
                    return "<span data-change='"+sign+"'>"+chg+"</span>";
                }},
                {data: 'per_c', searchable: false,class:'hidden-xs hidden-sm text-right', render: function (data) {
                    var chg = data;
                    var sign='';
                    if(chg>0) sign = 'up';
                    else if(chg<0) sign = 'down';
                    return "<span data-change='"+sign+"'>"+chg+"</span>";
                }},
                {data: 'avg_c', searchable: false,class:'hidden-xs hidden-sm text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'max', name: 'max', searchable: false,class:'hidden-xs hidden-sm text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'min', name: 'min', searchable: false,class:'hidden-xs hidden-sm text-right', render: function (data) {
                    return addCommas(data);
                }}
            ]
        });		
    }
    return true;
}

function loadGainer() {
    count = 0;
    if (table['gainer'] === undefined) {
        table['gainer'] = $('#gainerDatatable').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
			autoWidth: true,
            language: {
                processing: SPINNER
            },
            info: false,
            order:[[12,'desc']],
            "lengthMenu": [[100, 300, 600], [100, 300, 600]],
            ajax: {
                url: todaysPriceURL,
                type: 'POST',
                data: {
                    fromdate: function () {
                        return $('#fromdate').val()
                    },
                    todate: function () {
                        return $('#todate').val()
                    },
                    sector: function () {
                        return $('#sector').val()
                    },
                    gainer: '1'
                }
            },
            columns: [
                {data: 'name'},
                {data: 'quote','visible':false,render:function(data){
                    return '<a href="/quote/'+data+'" target="_blank">'+data+'</a>';
                }},
                {data: 'name','visible':true,render:function(data,type,row,meta){
                    return '<a href="/quote/'+row.quote+'" target="_blank">'+data+'</a>';
                }},
                {data: 'tran_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'open_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'high_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'low_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'close_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'volume_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'amount_c',class:'text-right' , searchable: false, render: function (data) {
                    return addCommas(addCommas((parseFloat(data)/1000000).toFixed(2)))
                }},
                {data: 'cap_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas((parseFloat(data)/1000000).toFixed(2))
                }},
                {data: 'diff_c', searchable: false,class:'text-right', render: function (data) {
                    var chg = data;
                    var sign='';
                    if(chg>0) sign = 'up';
                    else if(chg<0) sign = 'down';
                    return "<span data-change='"+sign+"'>"+chg+"</span>";
                }},
                {data: 'per_c', searchable: false,class:'text-right', render: function (data) {
                    var chg = data;
                    var sign='';
                    if(chg>0) sign = 'up';
                    else if(chg<0) sign = 'down';
                    return "<span data-change='"+sign+"'>"+chg+"</span>";
                }},
                {data: 'avg_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'max', name: 'max', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'min', name: 'min', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }}
            ]
        });
        table['gainer'].on( 'order.dt search.dt', function () {
            table['gainer'].column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
    }
    return true;
}
function loadLoser() {
    count = 0;
    if (table['loser'] === undefined) {
        table['loser'] = $('#loserDatatable').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
			autoWidth: true,
            language: {
                processing: SPINNER
            },
            order:[[12,'asc']],
            "lengthMenu": [[100, 300, 600], [100, 300, 600]],
            ajax: {
                url: todaysPriceDurationURL,
                type: 'POST',
                data: {
                    fromdate: function () {
                        return $('#fromdate').val()
                    },
                    todate: function () {
                        return $('#todate').val()
                    },
                    sector: function () {
                        return $('#sector').val()
                    },
                    loser: '1'
                }
            },
            columns: [
                {data: 'name'},
                {data: 'quote','visible':false,render:function(data){
                    return '<a href="/quote/'+data+'" target="_blank">'+data+'</a>';
                }},
                {data: 'name','visible':true,render:function(data,type,row,meta){
                        return '<a href="/quote/'+row.quote+'" target="_blank">'+data+'</a>';
                    }},
                {data: 'tran_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'open_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'high_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'low_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'close_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'volume_c',searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'amount_c',class:'text-right', searchable: false, render: function (data) {
                    return addCommas(addCommas((parseFloat(data)/1000000).toFixed(2)))
                }},
                {data: 'cap_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas((parseFloat(data)/1000000).toFixed(2))
                }},
                {data: 'diff_c', searchable: false,class:'text-right', render: function (data) {
                    var chg = data;
                    var sign='';
                    if(chg>0) sign = 'up';
                    else if(chg<0) sign = 'down';
                    return "<span data-change='"+sign+"'>"+chg+"</span>";
                }},
                {data: 'per_c', searchable: false,class:'text-right', render: function (data) {
                    var chg = data;
                    var sign='';
                    if(chg>0) sign = 'up';
                    else if(chg<0) sign = 'down';
                    return "<span data-change='"+sign+"'>"+chg+"</span>";
                }},
                {data: 'avg_c', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'max', name: 'max', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'min', name: 'min', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }}
            ]
        });
        table['loser'].on( 'order.dt search.dt', function () {
            table['loser'].column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }
    return true;
}
function loadActive() {
    count = 0;
    if (table['active'] === undefined) {
        table['active'] = $('#activeDatatable').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
            info: false,
            language: {
                processing: SPINNER
            },
            order:[[3,'desc']],
            "lengthMenu": [[100, 300, 600], [100, 300, 600]],
            ajax: {
                url: todaysPriceURL,
                type: 'POST',
                data: {
                    fromdate: function () {
                        return $('#fromdate').val()
                    },
                    todate: function () {
                        return $('#todate').val()
                    },
                    sector: function () {
                        return $('#sector').val()
                    },
                    active: '1'
                }
            },
            columns: [
            {data: 'name'},
            {data: 'quote','visible':false,render:function(data){
                return '<a href="/quote/'+data+'" target="_blank">'+data+'</a>';
            }},
            {data: 'name','visible':true,render:function(data,type,row,meta){
                return '<a href="/quote/'+row.quote+'" target="_blank">'+data+'</a>';
            }},
            {data: 'tran_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'open_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'high_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'low_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'close_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'volume_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'amount_c' ,searchable: false,class:'text-right', render: function (data) {
                return addCommas(addCommas((parseFloat(data)/1000000).toFixed(2)))
            }},
            {data: 'cap_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas((parseFloat(data)/1000000).toFixed(2))
            }},
            {data: 'diff_c', searchable: false,class:'text-right', render: function (data) {
                var chg = data;
                var sign='';
                if(chg>0) sign = 'up';
                else if(chg<0) sign = 'down';
                return "<span data-change='"+sign+"'>"+chg+"</span>";
            }},
            {data: 'per_c', searchable: false,class:'text-right', render: function (data) {
               var chg = data;
                var sign='';
                if(chg>0) sign = 'up';
                else if(chg<0) sign = 'down';
                return "<span data-change='"+sign+"'>"+chg+"</span>";
            }},
            {data: 'avg_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'max', name: 'max', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'min', name: 'min', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }}
            ]
        });
        table['active'].on( 'order.dt search.dt', function () {
            table['active'].column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }
    return true;
}
function loadTurnover() {
    count = 0;
    if (table['turnover'] === undefined) {
        table['turnover'] = $('#turnoverDatatable').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
            info: false,
            language: {
                processing: SPINNER
            },
            order:[[9,'desc']],
            "lengthMenu": [[100, 300, 600], [100, 300, 600]],
            ajax: {
                url: todaysPriceURL,
                type: 'POST',
                data: {
                    fromdate: function () {
                        return $('#fromdate').val()
                    },
                    todate: function () {
                        return $('#todate').val()
                    },
                    sector: function () {
                        return $('#sector').val()
                    },
                    turnover: '1'
                }
            },
            columns: [
            {data: 'name'},
            {data: 'quote','visible':false,render:function(data){
                return '<a href="/quote/'+data+'" target="_blank">'+data+'</a>';
            }},
            {data: 'name','visible':true,render:function(data,type,row,meta){
                return '<a href="/quote/'+row.quote+'" target="_blank">'+data+'</a>';
            }},
            {data: 'tran_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'open_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'high_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'low_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'close_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'volume_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'amount_c' ,searchable: false,class:'text-right', render: function (data) {
                return addCommas(addCommas((parseFloat(data)/1000000).toFixed(2)))
            }},
            {data: 'cap_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas((parseFloat(data)/1000000).toFixed(2))
            }},
            {data: 'diff_c', searchable: false,class:'text-right', render: function (data) {
                var chg = data;
                var sign='';
                if(chg>0) sign = 'up';
                else if(chg<0) sign = 'down';
                return "<span data-change='"+sign+"'>"+chg+"</span>";
            }},
            {data: 'per_c', searchable: false,class:'text-right', render: function (data) {
                var chg = data;
                var sign='';
                if(chg>0) sign = 'up';
                else if(chg<0) sign = 'down';
                return "<span data-change='"+sign+"'>"+chg+"</span>";
            }},
            {data: 'avg_c', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'max', name: 'max', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }},
            {data: 'min', name: 'min', searchable: false,class:'text-right', render: function (data) {
                return addCommas(data);
            }}
            ]
        });
        table['turnover'].on( 'order.dt search.dt', function () {
            table['turnover'].column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }
    return true;
}
function loadSectorwise() {
    count = 0;
    if (table['sectorwise'] === undefined) {
        table['sectorwise'] = $('#sectorwiseDatatable').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
            info: false,
            language: {
                processing: SPINNER
            },
            scrollX:true,
            "lengthMenu": [[100, 300, 600], [100, 300, 600]],
            ajax: {
                url: todaysPriceDurationBySectorURL,
                type: 'POST',
                data: {
                    fromdate: function () {
                        return $('#fromdate').val()
                    },
                    todate: function () {
                        return $('#todate').val()
                    }
                }
            },
            columns: [
                {data: 'label', searchable: false, render: function (data) {
                    return ++count;
                }},
                {data: 'label', name: 'label'},
                {data: 'market_cap', searchable: false,class:'text-right', render: function (data) {
                    return addCommas((parseFloat(data)/1000000).toFixed(2))
                }},
                {data: 'tot_share', name:'tot_share', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'share_per', name:'share_per', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'tot_amount', name:'tot_amount', searchable: false,class:'text-right', render: function (data) {
                    return addCommas((parseFloat(data)/1000000).toFixed(2))
                }},
                {data: 'share_amt', name:'share_amt', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'nofcompany', name:'nofcompany', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }}
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                if(data.length){
                    $.each(data,function(k,record) {
                        marketCapData.push(parseFloat(parseFloat(record.market_cap/1000000).toFixed(2)));
                        amountData.push(parseFloat(parseFloat(record.tot_amount/1000000).toFixed(2)));
                        sharesData.push(parseFloat(parseFloat(record.tot_share/1000).toFixed(2)));
                        categoriesData.push(record.label);
                    });
                    sectorChart(categoriesData,marketCapData,sharesData,amountData);
                    marketCapData = [];
                    sharesData = [];
                    amountData = [];
                    categoriesData = [];
                }
            }               
        });
        table['sectorwise'].on( 'order.dt search.dt', function () {
            table['sectorwise'].column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }
    return true;
}
function loadIndex() {
    count = 0;
    if (table['indexOHLC'] === undefined) {
        table['indexOHLC'] = $('#indexOHLCDatatable').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
            info: false,
            language: {
                processing: SPINNER
            },
            order:[[0,'asc']],
            ajax: {
                url: indexOHLCURL,
                type: 'POST',
                data: {
                    fromdate: function () {
                        return $('#fromdate').val()
                    },
                    todate: function () {
                        return $('#todate').val()
                    }
                }
            },
            columns: [
                {data: 'id', searchable: false, class:'hidden-xs hidden-sm'},
                {data: 'type', name: 'type_label',class:'index-type-label',render:function(data) {
                    if(data.toLowerCase()=='market capitalization'|| data.toLowerCase()=='float mkt capitalization')
                        return data + ' (Mil)';
                    return data;
                }},
                {data: 'open', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'high', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'low', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'close', searchable: false,class:'text-right', render: function (data) {
                    return addCommas(data);
                }},
                {data: 'close', searchable: false,class:'text-right hidden-xs hidden-sm', render: function (data,type,row,meta) {
                    var change = parseFloat(eval(row.close)-eval(row.open)).toFixed(2);
                    var sign;
                    if(change>0){
                        sign='up';
                    }
                    else if(change<0){
                        sign = 'down';
                    }
                    else if(change==0){
                        sign = '';
                    }
                    return '<span data-change="'+sign+'">'+addCommas(change)+'</span>';
                }}
            ]
        });        
    }
    return true;
}
function loadIndexSummary() {
    count = 0;
    if (table['indexSummary'] === undefined) {
        table['indexSummary'] = $('#indexSummaryDatatable').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
            info: false,
            language: {
                processing: SPINNER
            },
            scrollX: true,
            ajax: {
                url: indexSummaryURL,
                type: 'POST',
                data: {
                    fromdate: function () {
                        return $('#fromdate').val()
                    },
                    todate: function () {
                        return $('#todate').val()
                    }
                }
            },
            columns: indexSummaryCols
        });
        table['indexSummary'].on( 'order.dt search.dt', function () {
            table['indexSummary'].column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }
    return true;
}
function loadMarketSummary()
{
    $.post(marketSummaryURL,{fromdate:$('#fromdate').val(),todate:$('#todate').val()},function(data){
        $.each(data,function(k,v){
         $('[data-val='+k+']').text(addCommas(v));
     });
    });
    if (table['indexDetailedSummary'] === undefined) {
        table['indexDetailedSummary'] = $('#detailed-summary').DataTable({
            processing: false,
            serverSide: false,
            paging: false,
            info: false,
            scrollX:true,
            language: {
                processing: SPINNER
            },
            order:[[1,'desc']],
            ajax: {
                url: indexDetailedSummaryURL,
                type: 'POST',
                data: {
                    fromdate: function () {
                        return $('#fromdate').val()
                    },
                    todate: function () {
                        return $('#todate').val()
                    }
                }
            },
            columns: [
                    {data: 'date'},
                    {data: 'date'},
                    {data: 'nofcompany', searchable: false,class:'text-right', render: function (data) {
                        return addCommas(data);
                    }},
                    {data: 'totaltran', searchable: false,class:'text-right', render: function (data) {
                        return addCommas(data);
                    }},
                    {
                    data: 'totalvol', searchable: false,class:'text-right', render: function (data) {
                        return addCommas(data);
                    }
                    },
                    {data: 'totalamt', searchable: false,class:'text-right', render: function (data) {
                        return addCommas(data);
                    }},
                    {data: 'market_value', searchable: false,class:'text-right', render: function (data) {
                        return addCommas(data);
                    }},
                    {data: 'float_value', searchable: false,class:'text-right', render: function (data) {
                        return addCommas(data);
                    }}]
        });
    } else {
        table['indexDetailedSummary'].ajax.reload();
    }
    table['indexDetailedSummary'].on( 'order.dt search.dt', function () {
            table['indexDetailedSummary'].column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
}
function refreshData(){
    count = 0;
    active = $("ul#mytabs li.active>a").prop('href').split('#')[1];
    if (active == 'index') {
        table['indexOHLC'].ajax.reload();
        table['indexSummary'].ajax.reload();
    } else if(active=='summary') {
        loadMarketSummary();
    } else {
        table[active].ajax.reload();
    }
}
function resizeWindow( e )
{
    var newWindowWidth = $(window).width();
    
    var tablesList = {
		//mobile,desktop columns
        sectorwise:{mobile:[1,2,3,4,5,6,7],desktop:[0,1,2,3,4,5,6,7]},
        gainer:{mobile:[1,3,7,8,9,11],desktop:[0,2,3,4,5,6,7,8,9,10,11,12,13,14,15]},
        loser:{mobile:[1,3,7,8,9,11],desktop:[0,2,3,4,5,6,7,8,9,10,11,12,13,14,15]},
        active:{mobile:[1,3,7,8,9,11],desktop:[0,2,3,4,5,6,7,8,9,10,11,12,13,14,15]},
        turnover:{mobile:[1,3,7,8,9,11],desktop:[0,2,3,4,5,6,7,8,9,10,11,12,13,14,15]}
    };

    if(newWindowWidth > 992) currentView = 'desktop'; else currentView = 'mobile'; //0 for mobile 1 fo desktop

    $.each(tablesList,function(i,v){
        var t = table[''+i];
        if(!(t===undefined))
        {
            t.columns().eq(0).each(function(index){
                var isVisible = !($.inArray(index,v[currentView])==-1);
                t.column(index).visible(isVisible);
            });
        }
    });
}
function sectorChart(category, marketdata, shares, amount ) {
    
    $('#sector-chart-container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Sectorwise Report'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: category,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Amount (Rs)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            formatter: function() {
                    return ''+
                        this.series.name +': '+ this.y +
                        (this.series.name == 'Market Capitalization'||this.series.name =='Amount' ? ' M' : ' K');
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [/*{
            name: 'Market Capitalization',
            data: marketdata
        }, */{
            name: 'Shares',
            data: shares
        }, {
            name: 'Amount',
            data: amount
        }]
    });
}