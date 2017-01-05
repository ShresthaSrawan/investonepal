$(document).ready(function () {
	//setting fromdate and todate
	$("#fromdatepicker").data("DateTimePicker").date(mindate);
	$("#todatepicker").data("DateTimePicker").date(maxdate);
    refreshNews();
	
    //for linked date picker
    $('#fromdatepicker').datetimepicker({
        format: "YYYY-MM-DD",
        maxDate:maxdate
    });
    $('#todatepicker').datetimepicker({
        format: "YYYY-MM-DD",
        useCurrent: false, //Important! See issue #1075
        minDate:mindate
    });
    //end of datepicker linking

    $("#fromdatepicker").on("dp.change", function (e) {
        $('#todatepicker').data("DateTimePicker").minDate(e.date);
        refreshNews();
    });

    $("#todatepicker").on("dp.change", function (e) {
        $('#fromdatepicker').data("DateTimePicker").maxDate(e.date);
        refreshNews();
    });
});

function refreshNews(){
    var newsHTML = '';
    $('.news-container').html('');
    $.post(newsByDate,{fromdate:$('#fromdate').val(),todate: $('#todate').val()},function(response){
        if(response !="" && response!=null){
            $.each(response, function(date, records){
            newsHTML += '<div class="panel panel-primary">\
                                <div class="panel-body">\
                                    <div class="row">\
                                        <div class="col-md-3 col-xs-12"><h3 class="news-date">'+moment(date,"YYYY-MM-DD").format("MMM Do, YYYY")+'</h3></div>\
                                            <div class="col-md-9 col-xs-12 news-list">';
                                $.each(records,function(key,news){
                                newsHTML += '<div class="row news-data">\
                                                    <a href="/news/'+news.category.label+'/'+news.slug+'" target="_blank" class="link news-link">\
                                                        <div class="col-md-12">\
                                                            <h4 class="news-title">'+news.title+'</h4>\
                                                        </div>\
                                                        <div class="col-md-12 news-detail">'+news.details.substring(0, 147)+' Read More</div>\
                                                    </a>\
                                                </div>';
                                });

                            newsHTML += '</div>\
                                    </div>\
                                </div>\
                            </div>';
            });
            $('.news-container').html(newsHTML);
        }else{
            newsHTML = '<div class="panel panel-default no-margin no-border"><div class="panel-body"><div class="well well-sm no-margin">\
                                <center>No news available.</center></div></div></div>';
            $('.news-container').html(newsHTML);
        }
    });
}