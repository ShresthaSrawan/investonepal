$(document).ready(function(){	
	if(brokerageFirmTable === undefined)
		{
			brokerageFirmTable = $('#datatable').DataTable({
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
				ajax: {
					url: brokerageFirmURL,
					type: 'POST'
				},
				dom:'<"row"<"#search.pull-left"f><"#lengthWrap.pull-right"l>><"row"tr><"row"ip>',
				columns: [
					{data: 'code',name:'code',class:'hidden-sm hidden-xs'},
					{data: 'firm_name',name:'firm_name'},
					{data: 'code',name:'code'},
					{data: 'director_name',name:'director_name',class:'hidden-sm hidden-xs',render:function(data){
                        if(data===null) return 'N/A';
                        return data;
                    }},
                    {data: 'address',name:'address',render:function(data){
                        if(data===null) return 'N/A';
                        return data;
                    }},
                    {data: 'mobile',name:'mobile',class:'hidden-sm hidden-xs',render:function(data){
                        if(data===null) return 'N/A';
                        return data;
                    }},
					{data: 'phone',name:'phone',render:function(data){
                        if(data===null) return 'N/A';
                        return data;
                    }},
				]
			});
		} else {
			brokerageFirmTable.ajax.reload();
		}
		brokerageFirmTable.on( 'order.dt search.dt page.dt draw.dt', function () {
            brokerageFirmTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
});