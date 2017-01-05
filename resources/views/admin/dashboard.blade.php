@extends('admin.master')

@section('title')
Dashboard
@endsection

@section('specificheader')
<style type="text/css">
.tasks ul{
	list-style: none;
	padding: 0;
}
.tasks ul li a{
	display: block;
}
</style>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Dashboard</h3>
	</div>
	<div class="box-body row">
		<div class="col-md-10">
			<h2>Welcome, {{Auth::user()->username}}</h2>
		</div>
		<div class="col-md-2 tasks">
			<div class="panel panel-default">
				<div class="panel-heading">Tasks</div>
				<div class="panel-body">
					<ul>
						@if(Auth::user()->hasRightsTo('create','news') || Auth::user()->hasRightsTo('create','data') || Auth::user()->hasRightsTo('create','crawl'))
							<li><a class="btn btn-default" href="{{route('admin.command','cache:clear')}}">Clear Cache</a></li>
							<li><a class="btn btn-default" href="{{route('admin.newsletter.preview')}}">Send Newsletter</a></li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('endscript')
<script type="text/javascript">
/*
	var floorsheetTable;
	var crawledPage;
	var request;
	function liveCrawl(minutes)
	{
		var interval = minutes;
		
		this.start = function(){
			console.log('live crawl started');
			
			request = setInterval( function(){
				$.ajax({
					url: 'http://nepalstock.com.np/floorsheet',
					type: 'POST',
					contentType: 'application/json',
					processData: false,
					data:{_limit:10000},
					dataType: 'jsonp',
					success: function(data){
						//crawledPage = data;
						console.log(data);
					},
					error: function() { console.log('Failed!'); }
				});
			},4000);
			
		}
		
		this.stop = function(){
			clearInterval(request);
			console.log('live crawl stopped');
		}
	}
	$(document).ready(function(){
		var live = new liveCrawl(1);
		live.start();
	});
	*/
</script>
@endsection