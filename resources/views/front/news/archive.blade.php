@extends('front.main')

@section('title')
News
@endsection

@section('specificheader')
{!! HTML::style('assets/nsm/front/css/archive.css') !!}
@endsection

@section('content')
	<section class="main-content col-md-9">
	    <div class="row" style="padding-top:10px;">
	        <div class="col-sm-6">
	            <label for="fromdate">From Date:</label>
	            <div class="form-group">
	                <div class='input-group date datepicker' id="fromdatepicker">
	                    <input type='text' class="form-control searchdate" value="{{$lastWeek}}" id="fromdate" />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6">
	            <label for="todate">To Date:</label>
	            <div class="form-group">
	                <div class='input-group date datepicker' id="todatepicker">
	                    <input type='text' class="form-control searchdate" value="{{$today}}" id="todate" />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="row">
	    	<div class="col-md-12 news-container">
	    	</div>
	    </div>
	</section>
@endsection

@section('endscript')
<script type="text/javascript">
	var newsByDate = "{{route('get-news-by-date')}}";
	var mindate = moment('{{$lastWeek}}');
    var maxdate = moment('{{$today}}');
</script>
	<script href="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js" type="text/javascript"></script>
    {!! HTML::script('assets/nsm/front/js/newsarchive.js') !!}
@endsection