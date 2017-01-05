$(document).ready(function(){
	$('.nav-drops').tabdrop({text: 'More'});
    generateChart(1,'NEPSE');
    updateIndexTable();
});

function generateChart(type, name)
{
    $.post(getIndexUrl,{type:type}, function (data) {
        // Create the chart
        seriesdata = [{
            type: 'area',
            name: name,
            data: data,
            tooltip: {
                valueDecimals: 2
            },
            fillColor : {
                linearGradient : [0, 0, 0, 210],
                stops : [
                    [0, Highcharts.getOptions().colors[0]],
                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            },
            threshold: null
        }];
        chart = new Highcharts.StockChart({
            chart: {
                renderTo: 'chart-container',
                zoomType: 'x'
            },
            credits: {
                enabled: false
            },
            rangeSelector: {
                allButtonsEnabled: true,
                buttons: [{
                    type: 'week',
                    count: 1,
                    text: '1w'
                }, {
                    type: 'day',
                    count: 15,
                    text: '15d'
                }, {
                    type: 'month',
                    count: 1,
                    text: '1m'
                }, {
                    type: 'month',
                    count: 3,
                    text: '3m'
                }, {
                    type: 'month',
                    count: 6,
                    text: '6m'
                }, {
                    type: 'all',
                    text: '1y'
                }],
                selected: 0
            },
            series: seriesdata,
            yAxis: {
                title: {
                    text: 'Value'
                }
            }
        }, function (chart) { // on complete
				var textX = eval(chart.plotLeft + chart.plotSizeX/2-90);
				var textY = eval(chart.plotTop + chart.plotSizeY/2);

				chart.renderer.text('InvestoNepal',textX,textY)
					.css({
						color: '#f1f1f1',
						fontSize: '35px'
					})
					.add();
			});
    });
}

function updateIndexTable(){
    indexTable = $('#indexDatatable').DataTable({
        processing: false,
        serverSide: false,
        info: false,
        fixedHeader: false,
        responsive:false,
        paging: false,
        bSort : false,
        bFilter:false,
        bInfo: false,
        language: {
            processing: SPINNER
        },
        dom:'<"row"<"col-xs-12"tr>>',
        order:[[0,'asc']],
        ajax: {
            url: indexSummaryDatatableURL,
            type: 'POST'
        },
        columns: [
            {data: 'name',class:'index-type-label',render:function(data){
				return data;
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
                return "<span data-change="+change+">"+addCommas(data)+"</span>";
            }},
            {data: 'percent',class:'text-right',render:function(data){
                change = "neutral";
                if(eval(data)>0)
                    change = "up";
                else if(eval(data)<0)
                    change = "down";
                return "<span data-change="+change+">"+addCommas(data)+"</span>";
            }}
        ]
    });
}