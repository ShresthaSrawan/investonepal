@extends('front.main')

@section('specificheader')
    {!! HTML::style('vendors/fullcalendar/fullcalendar.css') !!}
    {!! HTML::style('vendors/animate/animate.css') !!}
@endsection

@section('title')
    Event Calendar
@endsection

@section('content')
    <div class="row">
        <section class="event-details col-xs-12 hide">
            <button class="btn btn-xs btn-danger btn-tool pull-right" id="close-event-details"><i class="fa fa-remove"></i> Close</button>
            <span class="clearfix"></span>
            <div class="thumbnail">
                <img src="#" alt="#" class="img-responsive hide">
                <div class="caption">
                    <h4></h4>
                    <div class="event-desc"></div>
                    <p><i class="fa fa-external-link-square"></i> <a href="#" class="link" role="button" target="_blank">read more...</a></p>
                </div>
            </div>
        </section>
        <section class="event-calendar col-xs-12 pull-right">
            <div class="panel panel-default no-border">
                <div class="panel-body no-padding no-margin no-border">
                    <div id="nsm-calendar">

                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-xs-12" style="text-align: right">News <i class="fa fa-stop" style="color:#F3FA8E"></i></div>
                        <div class="col-xs-12" style="text-align: right">Announcement <i class="fa fa-stop" style="color:#8EFAA5"></i></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('endscript')
    {!! HTML::script('vendors/moment/moment.min.js') !!}
    {!! HTML::script('vendors/fullcalendar/fullcalendar.min.js') !!}
    {!! HTML::script('vendors/notify/notify.min.js') !!}
    <script>
        var news = {};
        var announcement = {};
        var clickCounter = 0;
        var showDate = new moment().format('YYYY-MM-D');
        var isSpinnerLoaded = false;


        $(document).ready(
                function(){
                    $calendar = $('#nsm-calendar');
                    initializeCalendar($calendar);

                    $(document).on('click','#close-event-details',
                            function(){
                                $calendarPannel = $('.event-calendar');
                                $details = $('.event-details');

                                $details.addClass('hide');
                                $calendarPannel.removeClass('col-md-8');
                                $details.removeClass('col-md-4');
                                clickCounter = 0;

                                setTimeout(function(){
                                    initializeCalendar($calendar,true)
                                },300);

                            }
                    );
                }
        );

        function initializeCalendar($calendar,goTo)
        {
            var url = $(location).attr("href");
            $calendar.fullCalendar( 'destroy' );

            $calendar.fullCalendar({
                'default': true,
                cache: true,
                header: {
                    left: 'title',
                    center: 'prev,today,next',
                    right: 'month,basicWeek'
                },
                buttonText: {
                    prev: '<i class="fa fa-angle-left"></i> Previous',
                    next: 'Next <i class="fa fa-angle-right"></i>'
                },
                eventSources: [
                    {
                        cache: true,
                        url: url,
                        type: 'POST',
                        data: { news: true },
                        error: function() {
                            $.notify({icon:'fa fa-warning',title:'System Error',message: 'There was an error while fetching news events!'},NOTIFY_CONFIG).update('type','pastel-danger');
                        },
                        color: '#F3FA8E',
                        textColor: '#2C3E50'
                    },
                    {
                        cache: true,
                        url: url,
                        type: 'POST',
                        data: { announcement: true },
                        error: function() {
                            $.notify({icon:'fa fa-warning',title:'System Error',message: 'There was an error while fetching announcement events.'},NOTIFY_CONFIG).update('type','pastel-danger');
                        },
                        color: '#8EFAA5',
                        textColor: '#2C3E50'
                    }

                ],
                eventRender: function(event, element) {
                    var title = element.find('.fc-event-title').text();
                    element.find('.fc-event-title').html(title);
                },
                eventClick: function(calEvent, jsEvent, view) {
                    showDate = calEvent.start;
                    $calendarPannel = $('.event-calendar');
                    $details = $('.event-details');
                    if(clickCounter == 0){
                        $calendarPannel.addClass('col-md-8');
                        clickCounter++;
                        setTimeout(function(){
                            $details.removeClass('hide');
                            $details.addClass('col-md-4 fade in');
                            initializeCalendar($calendarPannel.find('#nsm-calendar'),true)
                        },300);
                    }
                    $details.find('h4').text(calEvent.title);
                    $details.find('.event-desc').html(calEvent.details);
                    var $img = $details.find('img')
                            .addClass('hide')
                            .attr('src',calEvent.image)
                            .attr('alt',calEvent.title);

                    $details.find('.spinner').remove();
                    $details.find('.thumbnail').prepend(SPINNER);
                    $spinner = $details.find('.spinner');
                    $img.load(function(){
                        $spinner.remove();
                        $img.removeClass('hide');
                    });



                    $details.find('a.link').attr('href',calEvent.link);

                    // change the border color just for fun
                    $(this).css('border-color', 'red');

                }
            });

            if(goTo !== undefined){
                $calendar.fullCalendar('gotoDate',showDate);
            }
        }
    </script>
@endsection