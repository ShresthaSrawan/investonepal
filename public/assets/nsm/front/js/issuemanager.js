var issueManagerInfo;
$(document).ready(function(){	
	if(issueManagerTable === undefined)
		{
			issueManagerTable = $('#datatable').DataTable({
				processing: true,
				serverSide: true,
				fixedHeader: true,
				responsive:true,
				paging: true,
				info: true,
				filter:true,
				order:[[0,'asc']],
				language: {
                    processing: SPINNER
                },
                dom:'<"row"<"#issueWrap.pull-left"><"#lengthWrap.pull-right"l>><"row manager-info"><"row"tr><"row"ifp>',
				ajax: {
					url: issueManagerURL,
					type: 'POST',
					data: {
						issue_manager_id: function(){return $('.issueManager').val()}
					}
				},
				columns: [
					{data: 'name',name:'name',className:'desktop',render:function(name,type,row,meta){
						if(row != null) displayInfo(row.details.issue_manager);
			            return "<a href='/quote/"+row.quote+"' target='_blank'>"+name+"</a>";
			        }},
			        {data: 'quote',name:'quote',className:'mobile-p',render:function(name,type,row,meta){
			            return "<a href='/quote/"+row.quote+"' target='_blank'>"+name+"</a>";
			        }},
					{data: 'details.address',name:'details.address',className:'desktop',render:function(data){
                        if(data===null || data=="") return 'N/A';
                        return data;
                    }},
                    {data: 'details.phone',name:'details.phone',className:'desktop',render:function(data){
                        if(data===null || data=="") return 'N/A';
                        return data;
                    }},
					{data: 'details.email',name:'details.email',className:'none',render:function(data){
                        if(data===null || data=="") return 'N/A';
                        return data;
                    }},
                    {data: 'details.web',name:'details.web',className:'none',render:function(data){
                        if(data===null || data=="") return 'N/A';
                        return data;
                    }}
				]
			});

		} 
		else {
			issueManagerTable.ajax.reload();
		}

	$('#issue-manager').appendTo('#issueWrap');

	$('.issueManager').change(function(){
		issueManagerTable.ajax.reload();
	});

	function displayInfo (data) {
		issueManagerInfo = '<div class="col-md-12">\
								<table class="table table-responsive table-condensed with-border" width="100%">\
									<tbody>\
										<tr><th>Issue Manager:</th><td>'+data.company+'</td></tr>\
										<tr><th>Address:</th><td>'+data.address+'</td></tr>\
										<tr><th>Phone:</th><td>'+data.phone+'</td></tr>\
										<tr><th>Web:</th><td>'+data.web+'</td></tr>\
										<tr><th>Email:</th><td>'+data.email+'</td></tr>\
									</tbody>\
								</table>\
							</div>';

		$('.manager-info').html(issueManagerInfo);
	}
});