$(document).ready(function(){	
	if(bondTable === undefined)
		{
			bondTable = $('#datatable').DataTable({
				processing: true,
				serverSide: false,
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
					url: bondURL,
					type: 'POST',
					data: {
						fiscal_year_id: function(){return $('.fiscalYear').val()}
					}
				},
				columns: [
					{data: 'title_of_securities',name:'title_of_securities',className:'desktop',render:function(name,type,row,meta){
						return '<a href="/announcements/issue-open/'+row.announcement.slug+'" target="_blank">'+name+'</a>';
					}},
					{data: 'face_value',name:'	face_value',className:'desktop',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'kitta',name:'kitta',className:'desktop',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'maturity_period',name:'maturity_period',className:'desktop',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'issue_open_date',name:'issue_open_date',className:'desktop',render:function(data){
						return data=='0000-00-00'?'NA':data;
					}},
					{data: 'issue_close_date',name:'issue_close_date',className:'desktop',render:function(data){
						return data=='0000-00-00'?'NA':data;
					}},
					{data: 'company.name',name:'company.name',className:'none',render:function(data,type,row,meta){
			            return "<a href='/quote/"+row.company.quote+"' target='_blank'>"+data+"</a>";
			        }},
			        {data: 'company.quote',name:'company.quote',className:'mobile-p',render:function(data,type,row,meta){
			            return "<a href='/quote/"+row.company.quote+"' target='_blank'>"+data+"</a>";
			        }},
					{data:'announcement.details',name:'announcement.details',className:'none',render:function(name,type,row,meta){
						return '<a href="/announcements/issue-open/'+row.announcement.slug+'" target="_blank">'+name+'</a>';
					}},
					{data: 'coupon_interest_rate',name:'coupon_interest_rate',className:'none',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'interest_payment_method',name:'interest_payment_method',className:'none'},
				]
			});
		} else {
			bondTable.ajax.reload();
		}

	$('#fiscal-year').appendTo('#yearWrap');

	$('.fiscalYear').change(function(){
		bondTable.ajax.reload();
	});
});