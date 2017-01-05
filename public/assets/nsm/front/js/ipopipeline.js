$(document).ready(function(){	
	if(pipelineTable === undefined)
		{
			pipelineTable = $('#datatable').DataTable({
				order:[[6,'desc']],
				processing: true,
				serverSide: false,
				fixedHeader: true,
				responsive:true,
				paging: true,
				info: true,
				bSort : true,
				autoWidth: false,
				language: {
                    processing: SPINNER
                },
                dom:'<"row"<"#yearWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ifp>',
				ajax: {
					url: ipoPipelineURL,
					type: 'POST',
					data: {
						fiscal_year_id: function(){return $('.fiscalYear').val()}
					}
				},
				columns: [
					{data: 'id',className:'desktop'},
					{data: 'company.name',name:'company.name',className:'desktop',render:function(data,type,row,meta){
						return '<a href="/quote/'+row.company.quote+'" target="_blank">'+data+'</a>';
					}},
					{data:'company.quote',name:'company.quote',class:'text-upper',className:'mobile'},
					{data: 'company.sector.label',className:'desktop'},
					{data: 'announcement_subtype.label',class:'text-upper',className:'desktop'},
					{data: 'amount_of_public_issue',className:'desktop',render:function(data){
						return addCommas(data);
					}},
					{data: 'application_date',className:'desktop',render:function(data){
						if(data=='0000-00-00' || data=="" || data==null){
							return '-';
						}
						else{
							return data;
						}
					}},
					{data: 'approval_date',className:'desktop',render:function(data){
						if(data=='0000-00-00' || data=="" || data==null){
							return '-';
						}
						else{
							return data;
						}
					}},
					{data: 'ipo_issue_manager',className:'none',render:function(data){
						issuemanager = '';
						$.each(data,function(k,issue){
							issuemanager += issue.issue_manager.company+', ';
						});
						return issuemanager;
					}},
					{data: 'remarks',className:'none'}
				],
			});
		} else {
			pipelineTable.ajax.reload();
		}
		pipelineTable.on( 'order.dt search.dt', function () {
			pipelineTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			});
		}).draw();

	$('#fiscal-year').appendTo('#yearWrap');

	$('.fiscalYear').change(function(){
		pipelineTable.ajax.reload();
	});
});