@extends('front.main')

@section('title')
Announcement
@endsection

@section('specificheader')
<style type="text/css">
	.panel-primary{
		border: none;
		box-shadow: none;
	}
	a.announcement-link{
		color: #222222;
	}
	a.announcement-link:hover{
		color: #18bc9c;
	}
	h3.ann-date{
		color: #777777;
	}
	.announcement-list{
		border-left: 1px solid #777777;
	}
	.announcement-data{
		border-bottom: 1px dotted #777777;
	}
	.announcement-data:last-child{
		border-bottom: none;
	}
	.announcement-title{
		font-weight:600;
	}
	.announcement-detail{
		color: #777777;
	}
	@media screen and (max-width: 991px) {
	    .announcement-list{
			border-left: none;
		}
	}
</style>
@endsection

@section('content')
	<section class="main-content col-md-9">
	    <div class="row" style="padding-top:10px;">
	        <div class="col-sm-6">
	            <label for="fromdate">From Date:</label>
	            <div class="form-group">
	                <div class='input-group date' id="fromdatepicker">
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
	                <div class='input-group date' id="todatepicker">
	                    <input type='text' class="form-control searchdate" value="{{$today}}" id="todate" />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="row">
	    	<div class="col-md-12 announcement-container">
	    	</div>
	    </div>
	</section>
@endsection

@section('endscript')
<script type="text/javascript">
	var announcementByDate = "{{route('get-announcement-by-date')}}";
	var mindate = moment('{{$lastWeek}}');
    var maxdate = moment('{{$today}}');
</script>
	<script href="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js" type="text/javascript"></script>
    {!! HTML::script('assets/nsm/front/js/announcementindex.js') !!}
@endsection