$(document).ready(function(){
	$(".datepicker").data("DateTimePicker").date(lastDate);
	
	indexDataTable();
	refreshSummary();
	$('#index-toggle').on('click',function(){
		var isExpanded = $(this).attr('aria-expanded')=='true';
		if(!isExpanded){
			indexDataTable();
			refreshSummary();
		}
	});
		table = $('#datatable').DataTable({
			processing: true,
			serverSide: false,
			responsive:false,
			language: {
                        processing: SPINNER
                    },
			paging: false,
			info: false,
			fixedHeader:true,
			"lengthMenu": [[100, 300, 600], [100, 300, 600]],
			ajax: {
				url: todaysPriceURL,
				type: 'POST',
				data: {
					date: function(){return $('.searchdate').val()},
					sector: function(){return $('.sector').val()},
					datatable: 1
				}
			},
			columns: [
				{data: 'name',class:'hidden-xs hidden-sm'},
				{data: 'name',class:'hidden-xs hidden-sm',render:function(data,type,row,meta){
					return '<a href="/quote/'+row.quote+'" target="_blank">'+data+'</a>';
				}},
				{data: 'quote',class:'hidden-lg',render:function(data){
					return '<a href="/quote/'+data+'" target="_blank">'+data+'</a>';
				}},
				{data: 'tran_count',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
				{data: 'open',class:'hidden-xs hidden-sm',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
				{data: 'high',class:'hidden-xs hidden-sm',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
				{data: 'low',class:'hidden-xs hidden-sm',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
				{data: 'close',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
				{data: 'volume',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
				{data: 'amount',searchable:false,class:"text-right",render:function(data){
					return addCommas(data);
				}},
				{data: 'previous',class:'hidden-xs hidden-sm',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
				{data: 'difference',class:'text-right',searchable:false,render:function(data){
					change = "neutral";
					if(eval(data)>0)
						change = "up";
					else if(eval(data)<0)
						change = "down";
					return "<span data-change="+change+">"+data+"</span>";
				}},
				{data: 'percentage',class:'hidden-xs hidden-sm',searchable:false,class:'text-right',render:function(data){
					change = "neutral";
					if(eval(data)>0)
						change = "up";
					else if(eval(data)<0)
						change = "down";
					return "<span data-change="+change+">"+data+"</span>";
				}},
				{data: 'max52',searchable:false},
				{data: 'min52',searchable:false}
			],
			"footerCallback": function ( row, data, start, end, display ) {
	            var api = this.api(), data;
	 
	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            if (api.column(3).data().length){
		            totalTran = api
		                .column( 3 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                } );
		        }else{ totalTran = 0};

		        // Total over all pages
	            if (api.column(3).data().length){
		            totalTran = api
		                .column( 3 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                } );
		        }else{ totalTran = 0};

		        // Total over all pages
	            if (api.column(8).data().length){
		            totalVol = api
		                .column( 8 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                } );
		        }else{ totalVol = 0};

		        // Total over all pages
	            if (api.column(9).data().length){
		            totalAmt = api
		                .column( 9 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                } );
		        }else{ totalAmt = 0};
	 
	            // Update footer
	            $("#totalTran").html(addCommas(parseFloat(totalTran).toFixed(2)));
	            $("#totalVol").html(addCommas(parseFloat(totalVol).toFixed(2)));
	            $("#totalAmt").html(addCommas(parseFloat(totalAmt).toFixed(2)));
	        }	            
		});
		
		//Serial Number Gen
		table.on( 'order.dt search.dt', function () {
			table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			});
		}).draw();
		
		$('.datepicker').on("dp.change",function(){
			table.ajax.reload();
			if(!(indexTable===undefined) && $('#index-toggle').attr('aria-expanded')=='true')
			{
				refreshSummary();
				indexDataTable();
			}
		});
		$('.sector').on('change',function(){
			table.ajax.reload();
		});
		$("#searchbox").on("keyup search input paste cut", function() {
		   table.search(this.value).draw();
		}); 
});

	function indexDataTable(){
		if(indexTable === undefined)
		{
			indexTable = $('#indexDatatable').DataTable({
				processing: true,
				serverSide: false,
				fixedHeader: false,
				responsive:false,
				paging: false,
				info:false,
				language: {
                    processing: SPINNER
                },
				order:[[0,'asc']],
				ajax: {
					url: indexSummaryDatatableURL,
					type: 'POST',
					data: {
						date: function(){return $('.searchdate').val()}
					}
				},
				columns: [
					{data: 'id','visible':false},
					{data: 'name',render:function(data){
						return data.toUpperCase();
					}},
					{data: 'value',class:'text-right',render:function(data){
	                    return addCommas(data);
	                }},
					{data: 'change',class:'text-right',render:function(data){
						change = "neutral";
						if(eval(data)>0)
							change = "up";
						else if(eval(data)<0)
							change = "down";
						return "<span data-change="+change+">"+data+"</span>";
					}},
					{data: 'percent',class:'text-right',render:function(data){
						change = "neutral";
						if(eval(data)>0)
							change = "up";
						else if(eval(data)<0)
							change = "down";
						return "<span data-change="+change+">"+data+"</span>";
					}}
				]
			});
			indexTable.on( 'order.dt search.dt', function () {
				indexTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
					cell.innerHTML = i+1;
				});
			}).draw();
		} else {
			indexTable.ajax.reload();
		}
	}

	function refreshSummary () {
		$.post(todaysSummaryURL,{date:$('.searchdate').val()},function(response){
			$.each(response,function(k,v){
				$('[data-value="'+k+'"]').html(v);
			});
		});
	}
