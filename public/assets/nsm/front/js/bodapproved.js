$(document).ready(function(){	
	if(bodApprovedTable === undefined)
		{
			bodApprovedTable = $('#datatable').DataTable({
				processing: true,
				serverSide: false,
				fixedHeader: true,
				responsive:false,
				paging: true,
				info: true,
				order:[[0,'asc']],
				lengthMenu: [[50,100,150,200],[50,100,150,200]],
				language: {
                    processing: SPINNER
                },
                dom:'<"row"<"#yearWrap.pull-left"><"#sectorWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ifp>',
				ajax: {
					url: bodApprovedURL,
					type: 'POST',
					data: function (d) {
                        d.fiscal_year_id = $('.fiscalYear').val();
                        d.sector_id = $('.sectorList').val();
                    }
				},
				columns: [
					{data:'bonus_share',name:'bonus_share',class:'hidden-sm hidden-xs'},
					{data: 'company.name',name:'company.name',class:'hidden-sm hidden-xs',render:function(name,type,row,meta){
						return '<a href="/announcements/approved-by-bod/'+row.announcement.slug+'" target="_blank">'+name+'</a>';
					}},
					{data: 'company.quote',name:'company.quote',class:'hidden-lg',render:function(name,type,row,meta){
						return '<a href="/announcements/bod-approved/'+row.announcement.slug+'" target="_blank">'+name+'</a>';
					}},
					{data: 'bonus_share',name:'bonus_share',class:'text-right',render:function(data){
						return addCommas(data);
					}},
					{data: 'cash_dividend',name:'cash_dividend',class:'text-right',render:function(data){
						return addCommas(data);
					}},
					{data: 'distribution_date',name:'distribution_date',render:function(data){
						return data;
					}},
				]
			});
		} else {
			bodApprovedTable.ajax.reload();
		}
		bodApprovedTable.on( 'order.dt search.dt', function () {
			bodApprovedTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			});
		}).draw();

	$('#fiscal-year').appendTo('#yearWrap');

	$('#sector-list').appendTo('#sectorWrap');

	$('.fiscalYear').change(function(){
		bodApprovedTable.ajax.reload();
	});

	$('.sectorList').change(function(){
		bodApprovedTable.ajax.reload();
	});
});