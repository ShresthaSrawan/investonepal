var activeTab;
$(document).ready(function () {
	//setting fromdate and todate
	$("#fromdatepicker").data("DateTimePicker").date(mindate).maxDate(maxdate);
	$("#todatepicker").data("DateTimePicker").date(maxdate).minDate(mindate);
	
	activeTab = $('a[data-toggle="tab"]').first();
	refreshData();
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  activeTab = e.target, // newly activated tab
	  refreshData();
	});


    $('#company').chosen(config);
    //display the table below
    
    $('#company').change(function(){
        refreshData();
    });
    $("#fromdatepicker").on("dp.change", function (e) {
        $('#todatepicker').data("DateTimePicker").minDate(e.date);
        refreshData();
    });

    $("#todatepicker").on("dp.change", function (e) {
        $('#fromdatepicker').data("DateTimePicker").maxDate(e.date);
        refreshData();
    });

    $('#tranbtn').on('click',function(){
    	transactionAverage();
    });
    $("#todatepicker2").on("dp.change", function (e) {
    	transactionAverage();
    });
    $('#tranlimit').change(function(){
    	transactionAverage();
    });
});

function refreshData()
{
    $.post(tradedDaysURL,{fromdate:$('#fromdate').val(),todate:$('#todate').val()},function(days){
        $('.traded_dur').html(addCommas(days));
    });
	
	companyAverage();
	allAverage();
	
    fdate = moment($('#fromdate').val());
    tdate = moment($('#todate').val());
    $('#fdate').html(fdate.format('MMM Do, YYYY'));
    $('#tdate').html(tdate.format('MMM Do, YYYY'));
    $('#dur').html(tdate.diff(fdate,'days')+1);
}
function companyAverage(){
	if($(activeTab).attr('aria-controls')=='company' && $('#company').val()!=''){
		$.post(companyAverageTodaysPriceByDuration,{fromdate:$('#fromdate').val(),todate:$('#todate').val(),id:$('#company').val()},function(avg){
			$('.avgprice').html(addCommas(avg));
		});
		if(typeof table === 'undefined'){
			table = $('#companyaverage').DataTable({
				processing: true,
				serverSide: false,
				paging: false,
				dom:'<"row"<"#lengthWrap.pull-right"l>><"row"tr><"row"ifp>',
				language: {
						processing: SPINNER
					},
				info: true,
				ajax: {
					url:averageTodayPriceListByCompany,
					type: 'POST',
					data: {
						id: function(){return $('#company').val()},
						fromdate: function(){return $('#fromdate').val()},
						todate: function(){return $('#todate').val()}
					}
				},
				columns: [
					{data: 'date',name:'date'},
					{data: 'close',name:'close',searchable:false,render:function(data){
						return addCommas(data);
					}},
					{data: 'previous',searchable:false,render:function(data){
						return addCommas(data);
					}},
					{data: 'difference',searchable:false,render:function(data){
						var chg = parseFloat(data).toFixed(2);
						var sign='';
						if(chg>0) sign = 'up';
						else if(chg<0) sign = 'down';
						return "<span data-change='"+sign+"'>"+addCommas(chg)+"</span>";
					}},
					{data: 'percentage',searchable:false,render:function(data){
						var chg = parseFloat(data).toFixed(2);
						var sign='';
						if(chg>0) sign = 'up';
						else if(chg<0) sign = 'down';
						return "<span data-change='"+sign+"'>"+addCommas(chg)+"</span>";
					}}
				]
			});
		}else {
			table.ajax.reload();
		}
	}
}
function allAverage(){
	//all company average
	if($(activeTab).attr('aria-controls')=='all'){
		if(typeof table2 === 'undefined'){
			table2 = $('#allaverage').DataTable({
				processing: true,
				serverSide: true,
				paging: true,
				lengthMenu:[[100,150,200],[100,150,200]],
				dom:'<"row"<"#lengthWrap.pull-right"l>><"row"tr><"row"ifp>',
				language: {
						processing: SPINNER
					},
				info: true,
				ajax: {
					url:averageTodaysPrice,
					type: 'POST',
					data: {
						fromdate: function(){return $('#fromdate').val()},
						todate: function(){return $('#todate').val()}
					}
				},
				columns: [
					{data: 'quote',name:'quote',class:'hidden-lg',render:function(data){
					return '<a href="/quote/'+data+'" target="_blank">'+data+'</a>';
					}},
					{data: 'name',name:'name',class:'hidden-xs hidden-sm',render:function(data,type,row,meta){
					return '<a href="/quote/'+row.quote+'" target="_blank">'+data+'</a>';
					}},
					{data: 'average',class:'text-right',searchable:false,render:function(data){
						return addCommas(data);
					}},
					{data: 'close',class:'text-right',name:'close',searchable:false,render:function(data){
						return addCommas(data);
					}},
					{data: 'date',name:'date'}
				]
			});
		} else {
			table2.ajax.reload();
		}
	}
}

function transactionAverage()
{
	if(typeof table3 === 'undefined'){
		table3 = $('#transactionaverage').DataTable({
			processing: true,
			serverSide: true,
			paging: true,
			lengthMenu:[[100,150,200],[100,150,200]],
			dom:'<"row"<"#lengthWrap.pull-right"l>><"row"tr><"row"ifp>',
			language: {
					processing: SPINNER
				},
			info: true,
			ajax: {
				url:averageTodayPriceByTransaction,
				type: 'POST',
				data: {
					limit: function(){return $('#tranlimit').val()},
					todate: function(){return $('#todate2').val()}
				}
			},
			columns: [
				{data: 'quote',name:'quote',class:'hidden-lg',render:function(data){
				return '<a href="/quote/'+data+'" target="_blank">'+data+'</a>';
				}},
				{data: 'name',name:'name',class:'hidden-xs hidden-sm',render:function(data,type,row,meta){
				return '<a href="/quote/'+row.quote+'" target="_blank">'+data+'</a>';
				}}
				,
				{data: 'average',name:'average'},
				{data: 'count',name:'count'}
			]
		});
	} else {
		table3.ajax.reload();
	}
}