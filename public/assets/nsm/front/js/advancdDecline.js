var chart;
var options;
var seriesdata=[];
var seriesdata2=[];
$(document).ready(function(){
    $.post(advanceDeclineUrl, function (data) {
        // Create the chart
        seriesdata = [
            {
                type: 'line',
                name: 'Advance',
                data: data.advance,
                tooltip: {
                    valueDecimals: 2
                },
                threshold: null
            },
            {
                type: 'line',
                name: 'Decline',
                data: data.decline,
                tooltip: {
                    valueDecimals: 2
                },
                threshold: null
            }
        ];
        seriesdata2 = [
            {
                type: 'line',
                name: 'A/D Ratio',
                data: data.ratio,
                tooltip: {
                    valueDecimals: 2
                },
                threshold: null
            }
        ];
        chart = new Highcharts.StockChart({
            chart: {
                renderTo: 'chart-container',
                zoomType: 'x'
            },
            credits: {
                enabled: false
            },
            colors: ['#00ff00', '#ff0000'],
            title: {
                text:'Advance/Decline Count'
            },
            rangeSelector: {
                inputEnabled: $('#chart-container').width()>480,
                buttons: [
                    {
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
                        type: 'year',
                        count: 1,
                        text: '1y'
                    }
                ],
                selected: 0
            },
            series: seriesdata,
            yAxis: {
                min: 0,
                title: {
                    text: 'Number'
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
        chart2 = new Highcharts.StockChart({
            chart: {
                renderTo: 'ratio-chart-container',
                zoomType: 'x'
            },
            credits: {
                enabled: false
            },
            title:{
                text:'Advance/Decline Ratio'
            },
            rangeSelector: {
                inputEnabled: $('#chart-container').width()>480,
                buttons: [
                    {
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
                        type: 'year',
                        count: 1,
                        text: '1y'
                    }
                ],
                selected: 0
            },
            series: seriesdata2,
            yAxis: {
                min: 0,
                title: {
                    text: 'Ratio'
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

        //display the table below
        var table = $('.advancedecline').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
            info: false,
            bFilter: false,
            order:[[1,'desc']],
            language: {
                processing: SPINNER
            },
            ajax: {
                url:advanceDeclineUrl,
                type: 'POST',
                data: {datatable:1,lastmonth:1}
            },
            columns: [
                {data: 'date',searchable:false,class:'hidden-sm hidden-xs'},
                {data: 'date',searchable:false},
                {data: 'advance',searchable:false},
                {data: 'decline',searchable:false},
                {data: 'date',searchable:false,render:function(data,type,row,meta){
                    return (row.advance/row.decline).toFixed(2);
                }}
            ]
        });
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
    });

});