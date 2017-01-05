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
    if(response===undefined){
        $.post(ohlcURL,{id:id,extended_timeline:1}, function(data) {
            response=data;
            drawChart(response);
        });
    } else {
        drawChart(response);
    }
}
function drawChart(data) {
    $('#backdrop').show();
    // 0=date,1=close,2=open,3=high,4=low
    var seriesData = [];

    var period_sma = $('#period_sma').val();
    //var for simple mean average
    var sma = [];
    for(i=(period_sma-1);i<data.length;i++)
    {
        sma.push([
            data[i][0],
            getAvg(data.slice(i-(period_sma-1),i+1))
        ]);
    }

    if($('#bollinger').is(":checked"))
    {
        /*
            * Middle Band = 20-day simple moving average (SMA)
            * Upper Band = 20-day SMA + (20-day standard deviation of price x 2) 
            * Lower Band = 20-day SMA - (20-day standard deviation of price x 2)
        */
        var period_bol = $('#period_bol').val();
        var std_devs_bol = $('#std_devs_bol').val();
        // for upper bollinger value
        var bb_upper = [];
        for(i=0;i<sma.length;i++)
        {
            bb_upper.push([
                sma[i][0],
                eval((sma[i][1]+std_devs_bol*(standardDeviation(data.slice(i,i+(period_bol-1))))))
            ]);
        }        

        // for lower bollinger value
        var bb_lower = [];
        for(i=0;i<sma.length;i++)
        {
            bb_lower.push(
                [sma[i][0],
                eval((sma[i][1]-std_devs_bol*(standardDeviation(data.slice(i,i+(period_bol-1))))))
            ]);
        }        
    }

    //for ema
    if($('#ema').is(":checked"))
    {
        /*

        SMA: 10 period sum / 10 

        Multiplier: (2 / (Time periods + 1) ) = (2 / (10 + 1) ) = 0.1818 (18.18%)

        EMA: {Close - EMA(previous day)} x multiplier + EMA(previous day). 

        */
        var period_ema = $('#period_ema').val();
        var ema = [];
        for(i=0;i<data.length;i++)
        {
            if(i==0){
                ema.push([data[i][0],data[i][1]]);
            } else {
                ema.push([
                    data[i][0],
                    eval((data[i][1]*2/(1+period_ema)+ema[i-1][1]*(1-2/(1+period_ema))))
                ]);
            }
        }
    }

    //for rsi
    /*

                  100
    RSI = 100 - --------
                 1 + RS

    RS = Average Gain / Average Loss

    */
    if($('#rsi').is(":checked"))
    {
        var period_rsi = $('#period_rsi').val();
        var rsi=[];
        var upward_movement = [];
        var downward_movement = [];
        var average_upward_movement = [];
        var average_downward_movement = [];
        for(i=1;i<data.length;i++)
        {
            var up = 0;
            var down = 0;
            if(data[i][1]>data[i-1][1])
                up = data[i][1] - data[i-1][1];
            
            upward_movement.push([
                data[i][0],
                up
            ]);

            if(data[i][1]<data[i-1][1])
                down = data[i-1][1] - data[i][1];
            
            downward_movement.push([
                data[i][0],
                down
            ]);
        }
        for(i=(period_rsi-1);i<downward_movement.length;i++)
        {
            if(i==(period_rsi-1))
            {
                average_downward_movement.push([
                    downward_movement[i][0],
                    getAvg(downward_movement.slice(0,period_rsi-1))
                ]);
                average_upward_movement.push([
                    upward_movement[i][0],
                    getAvg(upward_movement.slice(0,period_rsi-1))
                ]);
            } else {
                average_downward_movement.push([
                    downward_movement[i][0],
                    (average_downward_movement[i-period_rsi][1]*(period_rsi-1)+downward_movement[i][1])/period_rsi
                ]);
                average_upward_movement.push([
                    upward_movement[i][0],
                    (average_upward_movement[i-period_rsi][1]*(period_rsi-1)+upward_movement[i][1])/period_rsi
                ]);
            }
        }
        var relative_strength = [];
        for(i=0;i<average_upward_movement.length;i++){
            relative_strength.push([
                average_upward_movement[i][0],
                average_upward_movement[i][1]/average_downward_movement[i][1]
            ]);
        }
        for(i=0;i<relative_strength.length;i++){
            rsi.push([
                relative_strength[i][0],
                eval((100-(100/(relative_strength[i][1]+1))))
            ]);
        }
    }

    /*

    for stochastic osc

    %K = (Current Close - Lowest Low)/(Highest High - Lowest Low) * 100
    %D = 3-day SMA of %K

    Lowest Low = lowest low for the look-back period
    Highest High = highest high for the look-back period
    %K is multiplied by 100 to move the decimal point two places

    */
    if($('#stoch').is(":checked"))
    {
        var period_k_stoch = $('#period_k_stoch').val();
        var period_d_stoch = $('#period_d_stoch').val();
        var stoch_k = [];
        var stoch_d = [];
        count = 0;
        for(i=(period_k_stoch-1);i<data.length;i++)
        {
            list_of_highs_in_period = [];
            list_of_lows_in_period = [];

            for(j=i-(period_k_stoch-1);j<=i;j++)
            {
                list_of_highs_in_period.push(data[j][3]);
                list_of_lows_in_period.push(data[j][4]);
            }

            highest_high =Math.max.apply(Math, list_of_highs_in_period);

            lowest_low = Math.min.apply(Math, list_of_lows_in_period);

            stoch_k[count]= [
                data[i][0],// the date
                ((data[i][4]-lowest_low)/(highest_high-lowest_low))*100
            ];
            count++;
        }

        for(i=(period_d_stoch-1);i<stoch_k.length;i++)
        {
            stoch_d.push([
                stoch_k[i][0],
                getAvg(stoch_k.slice(i-(period_d_stoch-1),i+1))
            ]);
        }
    }

    var count  = 0;

    seriesData[count] = {
        name: is_index?i_name:'line',
        type : 'area',
        data : data,
        showInLegend: true,
        color: '#1999F9',
        yAxis: 0,
        id: 'primary',
        fillColor : {
            linearGradient : [0, 1000, 0, 0],
            stops : [
                [0, Highcharts.getOptions().colors[0]],
                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
            ]
        },
        tooltip: {
            valueDecimals: 2
        },
        threshold: null
    };

    if($('[name=candlestick]').is(':checked'))
    {
        count ++;
        // split the data set into ohlc and volume
        var groupingUnits = [
            [
                'week',                         // unit name
                [1]                             // allowed multiples
            ],[
                'month',
                [1, 2, 3, 4, 6]
            ]
        ];

        let cohl = data;
        let ohlc = [];
        for(i in cohl)
        {
            ohlc.push([
                cohl[i][0],
                cohl[i][2],
                cohl[i][3],
                cohl[i][4],
                cohl[i][1],
            ]);
        }

        seriesData[count] = {
            name: is_index?i_name:'ohlc',
            type : 'candlestick',
            data : ohlc,
            dataGrouping: {
                units: groupingUnits
            },
            id: 'ohlc',
            tooltip: {
                valueDecimals: 2
            }
        };
    }
    if($('#sma').is(":checked"))
    {
        count++;
        seriesData[count] = {
            name: 'SMA ('+period_sma+')',
            type: 'line',
            showInLegend: true,
            yAxis: 0,
            data : sma,
            tooltip: {
                valueDecimals: 2
            },
            color:'#000000',
            shadow: true,
            lineWidth: eval($("input:radio[name ='thickness_sma']:checked").val())+2
        };
    }
    if($('#bollinger').is(":checked"))
    {
        count++;
        seriesData[count] = {
            name: 'Upper Bollinger ('+period_bol+','+std_devs_bol+')',
            type: 'line',
            yAxis: 0,
            showInLegend: true,
            data : bb_upper,
            tooltip: {
                valueDecimals: 2
            },
            shadow: true,
            color: '#A3A3A3',
            lineWidth: eval($("input:radio[name ='thickness_bol']:checked").val())+2
        };
        count++;
        seriesData[count] = {
            name: 'Lower Bollinger ('+period_bol+','+std_devs_bol+')',
            type: 'line',
            yAxis: 0,
            showInLegend: true,
            data : bb_lower,
            tooltip: {
                valueDecimals: 2
            },
            color:'#999999',
            shadow: true,
            lineWidth: eval($("input:radio[name ='thickness_bol']:checked").val())+2
        }
    }
    if($('#ema').is(":checked"))
    {
        count++;
        seriesData[count] = {
            name: 'EMA ('+period_ema+')',
            type: 'line',
            yAxis: 0,
            showInLegend: true,
            data : ema,
            tooltip: {
                valueDecimals: 2
            },
            shadow: true,
            color: '#C00',
            lineWidth: eval($("input:radio[name ='thickness_ema']:checked").val())+2
        };
    }
    if($('#macd').is(":checked"))
    {
        count++;
        seriesData[count] = {
            name : 'MACD (26,12,9)',
            yAxis: 1,
            showInLegend: true,
            linkedTo: 'primary',
            type: 'trendline',
            algorithm: 'MACD',
            color:'#9FC5E8',
            tooltip: {
                valueDecimals: 2
            },
            lineWidth: eval($("input:radio[name ='thickness_macd']:checked").val())+2
        };
    } 
    if($('#signal').is(":checked") && $('#macd').is(":checked"))
    {
        count++;
        seriesData[count] = {
            name : 'Signal line',
            yAxis: 1,
            color:'#F1C232',
            showInLegend: true,
            type: 'trendline',
            linkedTo: 'primary',
            algorithm: 'signalLine',
            tooltip: {
                valueDecimals: 2
            },
            lineWidth: eval($("input:radio[name ='thickness_macd']:checked").val())+2
        };
    } 
    if($('#histogram').is(":checked") && $('#macd').is(":checked"))
    {
        count++;
        seriesData[count] = {
            name: 'Divergence',
            yAxis: 1,
            linkedTo: 'primary',
            showInLegend: true,
            color:'#f00',
            type: 'histogram',
            tooltip: {
                valueDecimals: 2
            }
        };
    }
    if($('#rsi').is(":checked"))
    {
        count++;
        seriesData[count] = {
            name: 'RSI ('+period_rsi+')',
            yAxis: 2,
            showInLegend: true,
            type: 'line',
            tooltip: {
                valueDecimals: 2
            },
            color:'#CC4125',
            data:rsi,
            lineWidth: eval($("input:radio[name ='thickness_rsi']:checked").val())+2
        };
    }
    if($('#stoch').is(":checked"))
    {
        count++;
        seriesData[count] = {
            name: 'Stochastic %K ('+period_k_stoch+')',
            yAxis: 2,
            showInLegend: true,
            type: 'line',
            tooltip: {
                valueDecimals: 2
            },
            color:'#EBA963',
            data: stoch_k,
            lineWidth: eval($("input:radio[name ='thickness_stoch']:checked").val())+2
        };
        count++;
        seriesData[count] = {
            type: 'line',
            name: 'Stochastic %D ('+period_d_stoch+')',
            yAxis: 2,
            showInLegend: true,
            tooltip: {
                valueDecimals: 2
            },
            color:'#02FE00',
            data:stoch_d,
            lineWidth: eval($("input:radio[name ='thickness_stoch']:checked").val())+2
        };
    }

    var y_axix_1 = false;
    var y_axix_2 = false;
    var yAxisData;
    var lastClose = 525;

    if($('#rsi').is(":checked") || $('#stoch').is(":checked")) y_axix_2 = true;
    if($('#macd').is(":checked")) y_axix_1=true;

    if(y_axix_1 && y_axix_2){
        yAxisData = [{
            title: {
                text: 'Price'
            },
            height: '45%',
            lineWidth: 2
        }, {
            title: {
                text: 'MACD'
            },
            height: '20%',
            top: '50%',
            offset: 0,
            lineWidth: 2
        }, {
            title: {
                text: 'Value'
            },
            height: '20%',
            top: '75%',
            offset: 0,
            lineWidth: 2
        }]
    }
    if(y_axix_1 && !y_axix_2){
        yAxisData = [{
            title: {
                text: 'Price'
            },
            height: '75%',
            lineWidth: 2
        }, {
            title: {
                text: 'MACD'
            },
            height: '20%',
            top: '80%',
            offset: 0,
            lineWidth: 2
        }, {
            title: {
                text: ''
            },
            height: '0%',
            top: '0%',
            offset: 0,
            lineWidth: 0
        }]
    }
    if(!y_axix_1 && y_axix_2){
        yAxisData = [{
            title: {
                text: 'Price'
            },
            height: '75%',
            lineWidth: 2
        }, {
            title: {
                text: ''
            },
            height: '0%',
            top: '0%',
            offset: 0,
            lineWidth: 1
        }, {
            title: {
                text: 'Value'
            },
            height: '20%',
            top: '80%',
            offset: 0,
            lineWidth: 2
        }]
    }

    //enable disable annotataions
    if($('#annotations').is(':checked'))
    {
        annotationState = true;
    } else {
        annotationState = false;
    }

    //fixed or sticky tooltip
    var mytooltip = {
        crosshairs: $('#crosshair').is(':checked'),
        followPointer:false,
        shared: true,
        formatter: function () {
            var s = '<b>' + Highcharts.dateFormat('%b %e, %Y', this.x) + '</b><br />';

            $.each(this.points, function (i, series) {
                if(series.series.name == "ohlc") {
                    s += '<div>Open:</div>'+series.point.open+'<br />';
                    s += '<div>Close:</div>'+series.point.close+'<br />';
                    s += '<div>High:</div>'+series.point.high+'<br />';
                    s += '<div>Low:</div>'+series.point.low+'<br />';
                } else  {
                    if(series.series.name != "line")
                        s += '<div style="color:'+this.series.color+'">'+this.series.name+':</div>'+this.y.toFixed(2)+'<br />';
                }
            });

            return s;
        }
    }
    if($('#fixed_tooltip').is(':checked')) mytooltip.positioner = function () {
                return { x: 0, y: 85 };
            };

    myChart = new Highcharts.StockChart({
        chart: {
            backgroundColor: 'rgba(0,0,0,0)',
            renderTo:'analysis'
        },
        title : {
            text : is_index ? i_name.toUpperCase(): c_name+' ('+quote.toUpperCase()+')',
        },

        subtitle: {
            text: ''
        },

        xAxis: {
            type: 'datetime'
        },

        yAxis: yAxisData,

        tooltip: mytooltip,
        
        rangeSelector : {
            inputEnabled: $('.container').width() > 480,
			buttons: [
						{
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
						}, {
							type: 'year',
							count: 3,
							text: '3y'
						}, {
							type: 'all',
							text: '5y'
						}
					],
				selected: 3
        },

        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },

        plotOptions: {
            series: {
                marker: {
                    enabled: false,
                }
            },
            candlestick: {
                color: 'red',
                upColor: 'green'
            },
            column: {
                color: 'white'
            }
        },
        credits: {
            enabled : false
        },

        series : seriesData,
        annotationsOptions: {
            enabledButtons: annotationState   
        }
    }, function (chart) { // on complete
			var textX = eval(chart.plotLeft + chart.plotSizeX/2-90);
			var textY = eval(chart.plotTop + chart.plotSizeY/2);

			chart.renderer.text('InvestoNepal',textX,textY)
				.css({
					color: '#f1f1f1',
					fontSize: '60px'
				})
				.add();
		});
    // console.log(myChart.annotations.allItems);
    $('#backdrop').hide();
    return;
}
function standardDeviation(values){
  var avg = getAvg(values);
  
  var squareDiffs = values.map(function(value){
    var diff = value[1] - avg;
    var sqrDiff = eval(parseFloat(diff * diff));
    return sqrDiff;
  });

  var avgSquareDiff = getRegularAvg(squareDiffs);

  var stdDev = Math.sqrt(avgSquareDiff);
  return stdDev;
}
function getAvg(data){
  var sum = data.reduce(function(sum, value){
    return sum + value[1];
  }, 0);

  var avg = sum / data.length;
  return eval(parseFloat(avg));
}
function getRegularAvg(data){
  var sum = data.reduce(function(sum, value){
    return sum + value;
  }, 0);

  var avg = sum / data.length;
  return eval(parseFloat(avg));
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