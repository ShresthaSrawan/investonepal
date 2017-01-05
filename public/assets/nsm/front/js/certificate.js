$(document).ready(function(){	
	if(certificateTable === undefined)
		{
			certificateTable = $('#datatable').DataTable({
				processing: true,
				serverSide: true,
				fixedHeader: true,
				responsive:false,
				paging: true,
				info: true,
				order:[[0,'asc']],
				lengthMenu: [[50,100,150,200],[50,100,150,200]],
				language: {
                    processing: SPINNER
                },
                dom:'<"row"<"#yearWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ifp>',
				ajax: {
					url: certificateURL,
					type: 'POST',
					data: {
						fiscal_year_id: function(){return $('.fiscalYear').val()}
					}
				},
				columns: [
					{data:'company.quote',name:'company.quote',class:'hidden-xs hidden-sm'},
					{data:'company.name',name:'company.name',class:'hidden-xs hidden-sm',render:function(name,type,row,meta){
						return '<a href="/announcements/certificate-and-dividend-distribution/'+row.announcement.slug+'" target="_blank">'+name+'</a>';
					}},
					{data:'company.quote',name:'company.quote',class:'hidden-lg',render:function(data,type,row,meta){
						return '<a href="/announcements/certificate-and-dividend-distribution/'+row.announcement.slug+'" target="_blank">'+name+'</a>';
					}},
					{data:'announcement.title',name:'announcement.title',render:function(data){
						var title = data.split(":");
						return title.length>1?title[1]:data;
					}},
					{data: 'bonus_share',name:'bonus_share',class:'hidden-xs hidden-sm text-right',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'cash_dividend',name:'cash_dividend',class:'hidden-xs hidden-sm text-right',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'distribution_date',name:'distribution_date',render:function(data){
						return data=='0000-00-00'?'NA':data;
					}},
				]
			});
		} else {
			certificateTable.ajax.reload();
		}
		certificateTable.on( 'order.dt search.dt', function () {
			certificateTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			});
		}).draw();

	$('#fiscal-year').appendTo('#yearWrap');

	$('.fiscalYear').change(function(){
		certificateTable.ajax.reload();
	});
});