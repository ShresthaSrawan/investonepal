$(document).ready(function(){	
	if(basePriceTable === undefined)
		{
			basePriceTable = $('#datatable').DataTable({
				processing: true,
				serverSide: false,
				fixedHeader: true,
				responsive:false,
				paging: true,
				info: true,
				filter:true,
				order:[[0,'asc']],
				language: {
                    processing: SPINNER
                },
                dom:'<"row"<"#yearWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ip>',
				ajax: {
					url: basePriceURL,
					type: 'POST',
					data: {
						fiscal_year_id: function(){return $('.fiscalYear').val()}
					}
				},
				columns: [
					{data: 'quote',name:'company.quote',class:'hidden-xs hidden-sm'},
					{data:'quote',name:'company.quote',class:'hidden-md hidden-lg'},
					{data: 'name',name:'company.name',class:'hidden-xs hidden-sm',render:function(name,type,row,meta){
						return '<a href="/quote/'+row.quote+'" target="_blank">'+name+'</a>';
					}},
					{data: 'label',name:'sector.label'},
					{data: 'price'},
					{data: 'date',render:function(data){
						return data;
					}}
				]
			});
		} else {
			basePriceTable.ajax.reload();
		}
		basePriceTable.on( 'order.dt search.dt draw.dt', function () {
			basePriceTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			});
		}).draw();
	$('#fiscal-year').appendTo('#yearWrap');

	$('.fiscalYear').change(function(){
		basePriceTable.ajax.reload();
	});
});