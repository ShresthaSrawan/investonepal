$(document).ready(function(){	
	if(treasuryBillTable === undefined)
		{
			treasuryBillTable = $('#datatable').DataTable({
				processing: true,
				serverSide: true,
				fixedHeader: true,
				responsive:true,
				paging: true,
				info: true,
				order:[[0,'asc']],
				lengthMenu: [[50,100,150,200],[50,100,150,200]],
				language: {
                    processing: SPINNER
                },
                dom:'<"row"<"#yearWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ifp>',
				ajax: {
					url: treasuryBillURL,
					type: 'POST',
					data: {
						fiscal_year_id: function(){return $('.fiscalYear').val()}
					}
				},
				columns: [
					{data:'announcement.title',name:'announcement.title',className:'desktop',render:function(name,type,row,meta){
						return '<a href="/announcements/issue-open/'+row.announcement.slug+'" target="_blank">'+name+'</a>';
					}},
					{data: 'highest_discount_rate',name:'highest_discount_rate',className:'desktop',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'lowest_discount_rate',name:'lowest_discount_rate',className:'desktop',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'bill_days',name:'bill_days',className:'desktop',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'issue_open_date',name:'issue_open_date',className:'desktop',render:function(data){
						return data=='0000-00-00'?'NA':data;
					}},
					{data: 'issue_close_date',name:'issue_close_date',className:'desktop',render:function(data){
						return data=='0000-00-00'?'NA':data;
					}},
			        {data: 'company.name',name:'company.name',className:'none',render:function(name,type,row,meta){
			            return "<a href='/quote/"+row.company.quote+"' target='_blank'>"+name+"</a>";
			        }},
			        {data: 'company.quote',name:'company.quote',className:'mobile-p',render:function(name,type,row,meta){
			            return "<a href='/quote/"+row.company.quote+"' target='_blank'>"+name+"</a>";
			        }},
					{data:'announcement.details',name:'announcement.details',className:'none',render:function(name,type,row,meta){
						return '<a href="/announcements/issue-open/'+row.announcement.slug+'" target="_blank">'+name+'</a>';
					}},
					{data: 'weighted_average_rate',name:'weighted_average_rate',className:'none',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'slr_rate',name:'slr_rate',className:'none',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'issue_amount',name:'issue_amount',className:'none',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
				]
			});
		} else {
			treasuryBillTable.ajax.reload();
		}

	$('#fiscal-year').appendTo('#yearWrap');

	$('.fiscalYear').change(function(){
		treasuryBillTable.ajax.reload();
	});
});