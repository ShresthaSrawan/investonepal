var floorsheetResponse;
var lastPriceDate;
$(document).ready(function () {
	getDetails();
	getOHLCChart();
    getBonusDividend();
    refreshReview();
    $('#quote-tabs').tabdrop({text: 'More'});
    $('#floorsheet-chart').click(function(){
        if(floorsheetResponse===undefined && !(lastPriceDate===undefined))
        getFloorsheetChart();
    });
	
	//Date Setter for floorsheet and closeprice
	$(".fromdatepicker").data("DateTimePicker").date(fromDate);
	$(".todatepicker").data("DateTimePicker").date(lastDate);
	$(".closefromdatepicker").data("DateTimePicker").date(fromDate);
	$(".closetodatepicker").data("DateTimePicker").date(lastDate);
	
    $('#floorsheet-tab').click(function(){
        getFloorsheet();
    });

    $('#closeprice-tab').click(function(){
        getClosePrice();
    });

    $('#published-report-tab').click(function(){
        getPublishedReport();
    });

    $('.review-container').slimScroll({height: '445px'});

    $(document).on('click','.vote',function(e){
        e.preventDefault;
        var vote_id=$(this).data('review');
        thumb=$(this).data('thumb');
        submitVote(vote_id,thumb);
    });
    $('#company-tran').css('width',$('#company-ohlcv').css('width'));
    $('.show-details').click(function(){
        $('#memberHead').html($(this).data('cat'));
        var content = "\
        <div class='row'>\
            <div class='col-sm-4'>\
                <img src='"+$(this).data('photo')+"' class='img-responsive' >\
            </div>\
            <div class='col-sm-8'>\
                <div class='row'>\
                    <div class='col-sm-12'><strong>Fiscal Year :</strong></div>\
                    <div class='col-sm-12'>"+$(this).data('fiscal-year')+"</div>\
                </div>\
                <div class='row'>\
                    <div class='col-sm-12'><strong>Name :</strong></div>\
                    <div class='col-sm-12'>"+$(this).data('name')+"</div>\
                </div>\
                <div class='row'>\
                    <div class='col-sm-12'><strong>Profile :</strong></div>\
                    <div class='col-sm-12'>"+$(this).data('profile')+"</div>\
                </div>\
            </div>\
        </div>\
        ";
        $('#memberCont').html(content);
        $('#memberDetail').modal();
    });

    $('.review-toggle').click(function(){
        $('.review').toggle();
    })
    $('.review-close').click(function(){
        $('.review').hide();  
    })

    $('.review-submit').click(function(){
        btn = $(this);
        btn.button('loading');
        $.post(reviewURL,{company_id:company_id,review_type:$('input:radio[name="review_type"]:checked').val(),review_text:$('[name="review_text"]').val()},function(response){
            if(response==1)
            {
                btn.button('reset');
                $('.review').hide();
                $.notify({icon:'fa fa-success',title:'Success',message: 'Review submitted successfully.'},NOTIFY_CONFIG).update('type','pastel-success');
                refreshReview();
            } else {
                btn.button('reset');
                $.notify({icon:'fa fa-danger',title:'System Error',message: 'There was an error while submitting your review. Make sure you are logged in.'},NOTIFY_CONFIG).update('type','pastel-danger');
            }
        });
    });

    $('.watchlist-toggle').click(function(){
        btn = $(this);
        $.post(watchlistURL,{company_id:company_id},function(response){
            if(response!=0)
            {
                $.notify({icon:'fa fa-success',title:'Success',message: response.message},NOTIFY_CONFIG).update('type','pastel-success');
                var btnIcon;
                console.log(response.status);
                if(response.status==1){
                    btnIcon = '<i class="fa text-danger fa-heart"></i> Added to WatchList';
                }
                else{
                    btnIcon = '<i class="fa fa-heart-o"></i> Add to WatchList';
                }
                btn.html(btnIcon);
            } else {
                $.notify({icon:'fa fa-danger',title:'System Error',message: 'There was an error while adding the compay to the watchlist. Make sure you are logged in.'},NOTIFY_CONFIG).update('type','pastel-danger');
            }
        });
    });
});

    function submitVote (vote_id, thumb) {
        $.post(voteURL,{id:vote_id,thumb:thumb},function(response){
            if(response==1)
            refreshReview();
        });
    }

    function refreshReview()
    {
        $.post(getReviewsURL,{company_id:company_id},function(response){

            var reviews = '';
            $.each(response.topReviews, function(index, object){
                if(object.review !="" && object.review!=null){
                    var upcount = object.upvote===null || object.upvote===0 ? "" : object.upvote;
                    var upVoted = false;
                    var downVoted =false;
                    var upDisabled = '';
                    var downDisabled = '';

                    if (object.up_user_id!=null && object.up_user_id!="")
                    {
                        upDisabled = $.inArray(currentUser,object.up_user_id.split(','))!=-1?'disabled':'';
                    }
                    if (object.down_user_id!=null && object.down_user_id!="")
                    {
                        downDisabled = $.inArray(currentUser,object.down_user_id.split(','))!=-1?'disabled':'';
                    }                    

                    upIcon = upDisabled!='' ?'fa-thumbs-up':'fa-thumbs-o-up';
                    downIcon = downDisabled!=''?'fa-thumbs-down':'fa-thumbs-o-down';

                    reviews += '<div class="col-md-2"><div class="thumbnail"><img class="img-responsive user-photo" src="'+object.user.thumbnail+'"></div></div>\
                    <div class="col-md-10">\
                        <div class="panel panel-default">\
                            <div class="panel-heading">\
                                <strong>'+object.user.username+'</strong> <span class="text-muted">'+moment(object.created_at).fromNow()+'</span>\
                                <span class="pull-right">\
                                    <span class="up-count">'+upcount+'</span>\
                                        <button type="button" class="up-vote vote" data-thumb="1" data-review="'+object.id+'" '+upDisabled+'>\
                                            <i class="fa '+upIcon+'"></i>\
                                        </button>\
                                        <button type="button" class="down-vote vote" data-thumb="0" data-review="'+object.id+'" '+downDisabled+'>\
                                            <i class="fa '+downIcon+'"></i>\
                                        </button>\
                                    </span>\
                                </span>\
                            </div>\
                            <div class="panel-body">'+object.review+'</div>\
                        </div>\
                    </div>';
                }
            });
            $('.review-container').html('');
            if(reviews==''){
                reviews = '<div class="panel panel-default no-margin no-border"><div class="panel-body"><div class="well well-sm no-margin">\
                                <center>No reviews available.</center></div></div></div>';
                $('.review-container').html(reviews);
            }
            else{
                $('.review-container').html(reviews);
            }

            nofb = eval(response.ratings.b === undefined ? 0 : response.ratings.b);
            nofs = eval(response.ratings.s === undefined ? 0 : response.ratings.s);
            nofh = eval(response.ratings.h === undefined ? 0 : response.ratings.h);
            total = eval(nofb+nofs+nofh);
            $('.ratings .buy').css('width',eval(nofb/total*100)+'%');
            $('.ratings .sell').css('width',eval(nofs/total*100)+'%')

            updateRatingHistory();
        });
    }

    function getDetails () {
        $.post(getTodaysPriceDayURL,{id:company_id,date:lastDate,skip_time_range_constraint:1},function(response){
            lastPriceDate = response.date;
            loadMktCap(response.close);
          $('[data-value="last-date"]').html(moment(response.date,'YYYY-MM-DD').format('MMM D'));
          $('[data-value="change-amt"]').html(addCommas(response.difference));
          $('[data-value="change-per"]').html(response.percentage+'%');
          $('[data-value="previous"]').html(addCommas(response.previous));
          $('[data-value="open"]').html(addCommas(response.open));
          $('[data-value="high"]').html(addCommas(response.high));
          $('[data-value="low"]').html(addCommas(response.low));
          $('[data-value="close-price"]').html(addCommas(response.close));
          $('[data-value="totaltran"]').html(addCommas(response.tran_count));
          $('[data-value="totalamt"]').html(addCommas(response.amount));
          $('[data-value="totalshare"]').html(addCommas(response.volume));
          $('[data-value="52max"]').html(addCommas(response.max52));
          $('[data-value="52min"]').html(addCommas(response.min52));

          $('[data-value="date-range"]').html(moment(response.date,'YYYY-MM-DD').subtract(1,'year').format('YYYY/MM/DD')+" - "+moment(response.date,'YYYY-MM-DD').format('YYYY/MM/DD'));

          var sign="";
          if(response.difference>0)
          {
              $('.delta-bar').addClass('gain');
              sign="up"; 
          } else if(response.difference<0) {
              $('.delta-bar').addClass('loss');
              sign="down"; 
          } 
          $('[data-value="change-amt"]').attr('data-change',sign);
          $('[data-value="change-per"]').attr('data-change',sign);
      });
    }
    //chart
    function getOHLCChart()
    {
      $.post(getTodaysPriceOHLCURL,{id:company_id,date:lastDate} ,function (data) {

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
                
                exporting: {
                    buttons: {
                        customButton: {
                            x: -62,
                            onclick: function () {
                                window.location = fullOHLCURL;
                            },
                            text: "View Large"
                        }
                    }
                },

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
    function getFloorsheetChart() {
        $.post(getCompanyTransURL,{id:company_id,lastDate:lastPriceDate} ,function (floorsheet) {

            // create the chart
            floorsheetResponse = floorsheet;
            var chart1 = new Highcharts.Chart(Highcharts.merge({
                    chart: {
                    renderTo: 'company-tran',
                    zoomType: 'x'
                },
                credits: {
                      enabled: false
                },
                title:{
                    text: quote+' Transaction History'
                },
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
                    selected: 0
                },
                navigator : {
                    enabled : false
                },
                series: [{
                    type: 'area',
                    name: 'Close',
                    data: floorsheet,
                    tooltip: {
                        valueDecimal:2
                    },
                    threshold: null
                }],
                yAxis: {
                    min: 0,
                    title: {
                        text: 'No.'
                    }
                },
                xAxis:{
                        title: {
                            text: null
                        },
                        labels: {
                         enabled:false,//default is true
                         y : 20, rotation: -45, align: 'right' }
                },
                tooltip: {
                    followPointer:false,
                    shared: true,
                    formatter: function () {
                        var s = '<b>' + Highcharts.dateFormat('%b %e, %Y', (this.x+'000').split('.')[1]) + '</b><br />';

                        $.each(this.points, function () {
                            s += '<div style="color:'+this.series.color+'">'+this.series.name+':</div>'+this.y.toFixed(2)+'<br />';
                        });
                        return s;
                    }
                }
            },darkunica),function (chart) { // on complete
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

    function updateRatingHistory(){
        $.post(getReviewsChartURL,{company_id:company_id},function(response){
            $('#reviewChart').highcharts({
                credits: {
                      enabled: false
                },
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Ratings History'
                },
                colors: ['#18bc9c', '#e74c3c', '#ecf0f1'],
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Ratings'
                    }
                },
                xAxis: {
                    categories: ['3 Month', '2 Month', '1 Month']
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'percent'
                    }
                },
                series: [{
                    name: 'Buy',
                    data: [
                        response[0].b===undefined?0:response[0].b,
                        response[1].b===undefined?0:response[1].b,
                        response[2].b===undefined?0:response[2].b,
                    ]
                }, {
                    name: 'Sell',
                    data: [
                        response[0].s===undefined?0:response[0].s,
                        response[1].s===undefined?0:response[1].s,
                        response[2].s===undefined?0:response[2].s,
                    ]
                }, {
                    name: 'Hold',
                    data: [
                        response[0].h===undefined?0:response[0].h,
                        response[1].h===undefined?0:response[1].h,
                        response[2].h===undefined?0:response[2].h,
                    ]
                }]
            });
        });
    }
    function getFloorsheet () {
        if(floorsheetDatatable === undefined){
            floorsheetDatatable = $('#floorsheetDatatable').DataTable({
                processing: true,
                serverSide: false,
                language: {
                    processing: SPINNER
                },
                "lengthMenu": [[50,100, 300, 600], [50,100, 300, 600]],
                dom:'<"row"<"#floorsheetDateWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ip>',
                ajax: {
                    url:floorsheetURL,
                    type: 'POST',
                    data: {
                        fromdate: function(){return $('#fromdate').val()},
                        todate: function(){return $('#todate').val()},
                        company_id: function(){return company_id}
                    }
                },
                columns: [
                {data: 'd', name: 'date'},
                {data: 'b', name: 'buyer_broker',class:'hidden-xs hidden-sm'},
                {data: 's', name: 'seller_broker',class:'hidden-xs hidden-sm'},
                {data: 'qt', name: 'quantity',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
                {data: 'r', name: 'rate',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
                {data: 'a', name: 'amount',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }}
                ]
            });
			$('#floorsheet-range').appendTo('#floorsheetDateWrap');
			$('.searchdate_floor').on('dp.change',function(){
				floorsheetDatatable.ajax.reload();
			});
			$('.dataTables_filter').hide();
        }
    }
    function getPublishedReport () {
        if(publishedDatatable === undefined){
            publishedDatatable = $('#publishedDatatable').DataTable({
                processing: true,
                serverSide: false,
                language: {
                    processing: SPINNER
                },
                order: [[ '0', "desc" ]],
                "lengthMenu": [[50,100, 300, 600], [50,100, 300, 600]],
                dom:'<"row"<"#dateWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ip>',
                ajax: {
                    url:publishedReportURL,
                    type: 'POST',
                    data: {
                        fiscal_year_id: function(){return $('.fy_id').val()},
                        sub_type_id: function(){return $('.subt_id').val()},
                        id: function(){return company_id}
                    }
                },
                columns: [
                {data: 'pub_date'},
                {data: 'financial_highlight.fiscal_year.label'},
                {data: 'sub_type.label'},
                {data: 'link', render:function(data,row,meta){
                    return "<a href='"+data+"'>"+meta.title+"</a>";
                }},
                ]
            });
            // $('#published-filter').appendTo('#dateWrap');
            $('.search_pub').on('change',function(){
                publishedDatatable.ajax.reload();
            });
        }
    }
    function getClosePrice () {
        if(closepriceDatatable === undefined){
            closepriceDatatable = $('#closepriceDatatable').DataTable({
                processing: true,
                serverSide: false,
                language: {
                    processing: SPINNER
                },
                order:[['0','desc']],
                "lengthMenu": [[10,25, 50], [10,25, 50]],
                dom:'<"row"<"#rangeWrap.pull-left"><"#lengthWrap.pull-right"l>><"row"tr><"row"ip>',
                ajax: {
                    url:closepriceURL,
                    type: 'POST',
                    data: {
                        fromdate: function(){return $('#fromdate_close').val()},
                        todate: function(){return $('#todate_close').val()},
                        id: function(){return company_id},
                        datatable: 1
                    }
                },
                columns: [
                {data: 'date', name: 'date'},
                {data: 'tran_count', name: 'tran_count',class:'hidden-xs hidden-sm'},
                {data: 'open', name: 'open',searchable:false,class:'text-right hidden-xs hidden-sm',render:function(data){
                    return addCommas(data);
                }},
                {data: 'high', name: 'high',searchable:false,class:'text-right hidden-xs hidden-sm',render:function(data){
                    return addCommas(data);
                }},
                {data: 'low', name: 'low',searchable:false,class:'text-right hidden-xs hidden-sm',render:function(data){
                    return addCommas(data);
                }},
                {data: 'close', name: 'close',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
                {data: 'volume', name: 'volume',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }},
                {data: 'amount', name: 'amount',searchable:false,class:'text-right',render:function(data){
                    return addCommas(data);
                }}
                ]
            });
			$('#closeprice-range').appendTo('#rangeWrap');
			$('.searchdate_close').on('dp.change',function(){
				closepriceDatatable.ajax.reload();
			});
			$('.dataTables_filter').hide();
        }
    }
    function getBonusDividend () {
        if(bonusDividendDatatable === undefined){
            bonusDividendDatatable = $('#bonusDividendDatatable').DataTable({
                processing: false,
                serverSide: false,
                info: false,
                language: {
                    processing: SPINNER
                },
                order:[['0','desc']],
                "bFilter" : false,               
                "bLengthChange": false,
                "paging": false,
                ajax: {
                    url:bonusDividendURL,
                    type: 'POST',
                    data: {
                        company_id: function(){return company_id}
                    }
                },
                columns: [
                    {data: 'fiscal_year.label', name: 'fiscal_year.label'},
                    {data: 'principal_indicators',render:function(data){
                        var output = 'NA';
                        $.each(data,function(k,v){
                            if((v['report_label']['label']).toLowerCase() == "cash dividend"){
                                output = v['value'];
                            }
                        });
                        return output;
                    }},
                    {data: 'principal_indicators',render:function(data){
                        var output = 'NA';
                        $.each(data,function(k,v){
                            if((v['report_label']['label']).toLowerCase() == "dividend on share capital"){
                                output = v['value'];
                            }
                        });
                        return output;
                    }}
                ]
            });
        } else {
            bonusDividendDatatable.ajax.reload();
        }
        $('.dataTables_filter').hide();
    }