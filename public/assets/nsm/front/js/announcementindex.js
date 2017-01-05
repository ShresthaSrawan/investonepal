$(document).ready(function () {
    refreshAnnouncement();

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
        refreshAnnouncement();
    });

    $("#todatepicker").on("dp.change", function (e) {
        $('#fromdatepicker').data("DateTimePicker").maxDate(e.date);
        refreshAnnouncement();
    });
});

function refreshAnnouncement(){
    var fromdate = $('#fromdate').val();
    var todate = $('#todate').val();
    var announcement = '';
    $('.announcement-container').html('');
    $.post(announcementByDate,{fromdate:fromdate,todate:todate},function(response){
        if(response !="" && response!=null){
            $.each(response, function(date, records){
            announcement += '<div class="panel panel-primary">\
                                <div class="panel-body">\
                                    <div class="row">\
                                        <div class="col-md-3 col-xs-12"><h3 class="ann-date">'+moment(date,"YYYY-MM-DD").format("MMM Do, YYYY")+'</h3></div>\
                                            <div class="col-md-9 col-xs-12 announcement-list">';
                                $.each(records,function(key,ann){
                                announcement += '<div class="row announcement-data">\
                                                    <a href="/announcements/'+ann.type.label+'/'+ann.slug+'" target="_blank" class="link announcement-link">\
                                                        <div class="col-md-12">\
                                                            <h4 class="announcement-title">'+ann.title+'</h4>\
                                                        </div>\
                                                        <div class="col-md-12 announcement-detail">'+ann.details+'</div>\
                                                    </a>\
                                                </div>';
                                });

                            announcement += '</div>\
                                    </div>\
                                </div>\
                            </div>';
            });
            $('.announcement-container').html(announcement);
        }else{
            announcement = '<div class="panel panel-default no-margin no-border"><div class="panel-body"><div class="well well-sm no-margin">\
                                <center>No announcements available.</center></div></div></div>';
            $('.announcement-container').html(announcement);
        }
    });
}