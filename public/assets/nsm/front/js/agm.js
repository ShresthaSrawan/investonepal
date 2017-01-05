$(document).ready(function(){	
	if(agmTable === undefined)
		{
			agmTable = $('#datatable').DataTable({
				processing: true,
				serverSide: true,
				fixedHeader: true,
				responsive:true,
				paging: true,
				info: true,
				filter:true,
				autoWidth:false,
				order:[[0,'asc']],
				lengthMenu: [[50,100,150,200],[50,100,150,200]],
				language: {
                    processing: SPINNER
                },
                dom:'<"row"<"#yearWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ifp>',
				ajax: {
					url: agmURL,
					type: 'POST',
					data: {
						fiscal_year_id: function(){return $('.fiscalYear').val()},
						sector_id: function(){return $('.sector').val()}
					}
				},
				columns: [
					{data:'agm.company.name',name:'agm.company.name',className:'desktop',render:function(name,type,row,meta){
						return '<a href="/announcements/annual-general-meeting/'+row.agm.announcement.slug+'" target="_blank">'+name+'</a>';
					}},
					{data:'agm.company.quote',name:'agm.company.quote',className:'mobile-p',render:function(data,type,row,meta){
						return '<a href="/announcements/annual-general-meeting/'+row.agm.announcement.slug+'" target="_blank">'+data+'</a>';
					}},
					{data:'agm.count',name:'agm.count',className:'none',render:function(data){
						return parseInt(data) == 0 ? 'Special GM' : data;
					}},
					{data:'agm.venue',name:'agm.venue',className:'desktop'},
					{data:'agm.agm_date',name:'agm.agm_date',className:'desktop',render:function(data){
						return moment(data,"YYYY-MM-DD HH:mm:ss").format("DD MMM, YYYY");
					}},
					{data:'agm.time',name:'agm.time',className:'desktop',render:function(data){
						return moment(data,"HH:mm:ss").format("hh:mm A");
					}},
					{data: 'agm.bonus',name:'agm.bonus',className:'desktop',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'agm.dividend',name:'agm.dividend',className:'desktop',render:function(data){
						return data==0?'NA':addCommas(data);
					}},
					{data: 'agm.book_closer_from',name:'agm.book_closer_from',className:'none',render:function(data){
						return data=='0000-00-00'?'NA':data;
					}},
					{data: 'agm.book_closer_to',name:'agm.book_closer_to',className:'none',render:function(data){
						return data=='0000-00-00'?'NA':data;
					}},
					{data:'agm.agenda',name:'agm.agenda',className:'none',render:function(data){
						return data==""?'NA':data;
					}},
				]
			});
		} else {
			agmTable.ajax.reload();
		}

	$('#fiscal-year').appendTo('#yearWrap');

	$('.fiscalYear, .sector').change(function(){
		agmTable.ajax.reload();
	});
});