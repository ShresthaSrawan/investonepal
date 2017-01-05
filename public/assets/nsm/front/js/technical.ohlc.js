var myChart,response;
$(document).ready(function(){
    updateChart();
    $(document).on('click', '.yamm .dropdown-menu', function(e) {
      e.stopPropagation()
    });
    $('.thickness, #annotations').on('change',function(){
        updateChart();
    });
	//search companry
	$(".search-company-selector-nav").select2({
		placeholder: 'Company/Quote',
		allowClear: true,
		ajax: {
			quietMillis: 10,
			delay: 250,
			cache: false,
			type: 'POST',
			url: searchCompanyUrl,
			data: function (params) {
				return {
					company: params.term
				};
			},
			processResults: function (data) {
			  // parse the results into the format expected by Select2.
			  // since we are using custom formatting functions we do not need to
			  // alter the remote JSON data
			  return {
				results: data
			  };
			},
		},
		minimumInputLength: 2,
		escapeMarkup: function (m) { return m; },
		templateResult: formatItem, // omitted for brevity, see the source of this page
		templateSelection: formatItemSelection // omitted for brevity, see the source of this page
	});
	setTimeout(function(){
		$('.select2-selection__placeholder').html('Select Company/Quote');
	},5000);
	$('.search-select').on('change',function(){
        if($(this).find('option:selected').val()!='')
		    $(this).closest('form').submit();
	})
});
$(window).resize(function(){
    updateChart();
});
$('#clean-all').on('click',function(){
    location.reload();
});
function updateChart(){
    $.post(getTodaysPriceOHLCURL,{id:id,date:lastDate} ,function (data) {

        // split the data set into ohlc and volume
        var groupingUnits = [[
                'week',                         // unit name
                [1]                             // allowed multiples
            ], [
                'month',
                [1, 2, 3, 4, 6]
            ]];


        // create the chart
        $('#company-ohlcv').highcharts('StockChart',Highcharts.merge({

            rangeSelector: {
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
                        type: 'all',
                        text: '1y'
                    }
                ],
                selected: 2
            },

            plotOptions: {
                candlestick: {
                    color: 'red',
                    upColor: 'green'
                },
                column: {
                    color: 'white'
                }
            },

            credits: {
                  enabled: false
            },

            title: {
                text: quote+' Historical'
            },

            yAxis: [
                {
                    labels: {
                        align: 'right',
                        x: -3
                    },
                    title: {
                        text: 'OHLC'
                    },
                    height: '60%',
                    lineWidth: 2
                }, {
                    labels: {
                        align: 'right',
                        x: -3
                    },
                    title: {
                        text: 'Volume'
                    },
                    top: '65%',
                    height: '35%',
                    offset: 0,
                    lineWidth: 2
                }
            ],

            series: [
                {
                    type: 'candlestick',
                    name: quote,
                    data: data['ohlc'],
                    dataGrouping: {
                        units: groupingUnits
                    },
                    id: 'ohlc'
                }, {
                    type: 'column',
                    name: 'Volume',
                    data: data['volume'],
                    yAxis: 1,
                    dataGrouping: {
                        units: groupingUnits
                    },
                    id: 'volume'
                }, {
                    type: 'flags',
                    name: 'Events',
                    data: data['events'],
                    shape: 'flag',
                    y: -50,
                    stackDistance: 20,
                    useHTML: true
                }
            ]
            },darkunica), function (chart) { // on complete
            var textX = eval(chart.plotLeft + chart.plotSizeX/2-90);
            var textY = eval(chart.plotTop + chart.plotSizeY/2);

            chart.renderer.text('InvestoNepal',textX,textY)
                .css({
                    color: '#555',
                    fontSize: '35px'
                })
            .add();
        });
    });
}

//Technical Analysis Search
var config = {
    allow_single_deselect:true,
    enable_split_word_search:true,
    search_contains:true,
    disable_search_threshold:5,
    no_results_text:'No company found with name.',
    width:'80%'
};
function formatItem (item) {
	if (item.loading) return item.text;

	var markup = '<div class="clearfix">' +
		'<div class="col-sm-9 no-padding">' + item.name + '</div>' +
		'<div class="col-sm-3 no-padding">' + item.quote + '</div>' +
		'</div>';

	/*if (repo.description) {
		markup += '<div>' + repo.description + '</div>';
	}*/

	return markup;
}

function formatItemSelection (item) {
	return item.quote || item.name;
}