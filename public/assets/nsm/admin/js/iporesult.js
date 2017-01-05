$(document).ready(function(){	
	if(ipoResultTable === undefined)
		{
			ipoResultTable = $('.datatable').DataTable({
				processing: true,
				serverSide: true,
				fixedHeader: true,
				responsive:false,
				paging: true,
				info: true,
				order:[[0,'asc']],
				ajax: {
					url: ipoResultURL,
					type: 'POST'
				},
				columns: [
					{data: 'numberofapplicants'},
					{data: 'numberofapplicants'},
					{data: 'name'},
					{data: 'date',render:function(data){
						return Date.parse(data).toString('MMM d');
					}},
					{data: 'numberofapplicants',render:function(date,type,row,meta){
	                    action = '\
	                    <form method="POST" action="/admin/ipo-result/' + row.company_id +'/'+row.date+ '/delete" accept-charset="UTF-8">\
	                    <input name="_method" type="hidden" value="DELETE">\
	                    <input name="_token" type="hidden" value="'+csrf+'">\
	                        <button type="button" class="btn btn-danger btn-sm delbtn"\
	                            data-toggle="modal" data-target="#deleteIpoResult">\
	                            <i class="glyphicon glyphicon-trash"></i>\
	                        </button>\
	                    </form>';
	                    return action;
	                }}
				]
			});
		} else {
			ipoResultTable.ajax.reload();
		}
		ipoResultTable.on( 'order.dt search.dt draw.dt', function () {
			ipoResultTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			});
		}).draw();
});