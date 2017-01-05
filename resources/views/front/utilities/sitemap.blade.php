@extends('front.main')

@section('title')
Sitemap
@endsection

@section('specificheader')
@endsection

@section('content')
	<section class="col-md-9 col-xs-12 main-content">
		<h3 class="category-heading">Site Map</h3>
		<p>If you're having trouble navigating your way around the site, here is list of links inorder to help you out.</p>
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<h4 class="category-heading" class="list-group-item">Stock</h4>
				<div class="list-group">
                    <a href="{{route('stock','advancedecline')}}" target="_blank" class="list-group-item">Advance/Decline</a>
                    <a href="{{route('front.agm')}}" target="_blank" class="list-group-item">Annual General Meeting (AGM)</a>
                    <a href="{{route('stock','averageprice')}}" target="_blank" class="list-group-item">Average Price</a>
                    <a href="{{route('front.basePrice')}}" target="_blank" class="list-group-item">Base Price</a>
                    <a href="{{route('front.bodApproved')}}" target="_blank" class="list-group-item">Benifits BOD Approved</a>
                    <a href="{{route('front.brokerageFirm')}}" target="_blank" class="list-group-item">Brokerage Firm</a>
                    <a href="{{route('front.issue')}}" target="_blank" class="list-group-item">Current+Upcoming</a>
                    <a href="{{route('front.certificate')}}" target="_blank" class="list-group-item">Certificates and Benifits Distribution</a>
					<a href="{{route('stock','index')}}" target="_blank" class="list-group-item">Index</a>
					<a href="{{route('stock','floorsheet')}}" target="_blank" class="list-group-item">Floorsheet</a>
                    <a href="{{route('stock','topperformers')}}" target="_blank" class="list-group-item">Gainer+Loser+Active</a>
                    <a href="{{route('front.ipoResult')}}" target="_blank" class="list-group-item">IPO Allotment</a>
                    <a href="{{route('front.ipoPipeline')}}" target="_blank" class="list-group-item">IPO Pipeline</a>
                    <a href="{{route('front.issueManager')}}" target="_blank" class="list-group-item">Issue Manager</a>
                    <a href="{{route('stock','lastprice')}}" target="_blank" class="list-group-item">Last Traded Price</a>
					<a href="{{route('stock','marketreport')}}" target="_blank" class="list-group-item">Market Report</a>
                    <a href="{{route('stock','newhighlow')}}" target="_blank" class="list-group-item">New High/Low</a>
					<a href="{{route('stock','today')}}" target="_blank" class="list-group-item">Today's Price</a>
					<a href="#" data-target="#technical-analysis" class="list-group-item" data-toggle="modal">Analysis</a>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<h4 class="category-heading" class="list-group-item"><a href="{{route('front.news.index')}}" target="_blank">News</a></h4>
				<div class="list-group">
					<a href="{{route('front.interviewArticle.index','article')}}" target="_blank" class="list-group-item">Article</a>
					<a href="{{route('front.news.category','bullion')}}" target="_blank" class="list-group-item">Bullion</a>
					<a href="{{route('front.news.category','currency')}}" target="_blank" class="list-group-item">Currency</a>
					<a href="{{route('front.news.category','employment')}}" target="_blank" class="list-group-item">Employment</a>
					<a href="{{route('front.news.category','energy')}}" target="_blank" class="list-group-item">Energy</a>
					<a href="{{route('front.news.category','hydropower')}}" target="_blank" class="list-group-item">Hydropower</a>
					<a href="{{route('front.news.category','insurance')}}" target="_blank" class="list-group-item">Insurance</a>
					<a href="{{route('front.interviewArticle.index','interview')}}" target="_blank" class="list-group-item">Interview</a>
					<a href="{{route('front.news.category','merger')}}" target="_blank" class="list-group-item">Merger</a>
					<a href="{{route('front.news.category','real-estate')}}" target="_blank" class="list-group-item">Real Estate</a>
					<a href="{{route('front.news.category','stock')}}" target="_blank" class="list-group-item">Sharebazar</a>
					<a href="{{route('front.news.category','tourism')}}" target="_blank" class="list-group-item">Tourism</a>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<h4 class="category-heading" class="list-group-item">Market</h4>
				<div class="list-group">
	                <a href="{{route('front.bondAndDebenture')}}" target="_blank" class="list-group-item">Bond and Debenture</a>
	                <a href="{{route('front.currency')}}" target="_blank" class="list-group-item">Currency</a>
	                <a href="{{route('front.energy')}}" target="_blank" class="list-group-item">Energy</a>
	                <a href="{{route('front.bullion','hallmark')}}" target="_blank" class="list-group-item">Gold</a>
	                <a href="{{route('front.bullion','silver')}}" target="_blank" class="list-group-item">Silver</a>
	                <a href="{{route('front.treasury')}}" target="_blank" class="list-group-item">Treasury Bill</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<h4 class="category-heading" class="list-group-item"><a href="{{route('front.announcement.index')}}" target="_blank">Announcement</a></h4>
				<div class="list-group">
	                <a href="{{route('front.announcement.category','issue-auction')}}" target="_blank" class="list-group-item">Auction</a>
	                <a href="{{route('front.announcement.category','bond-debenture')}}" target="_blank" class="list-group-item">Bond and Debenture</a>
	                <a href="{{route('front.announcement.category','financial-report')}}" target="_blank" class="list-group-item">Financial Report</a>
	                <a href="{{route('front.announcement.category','annual-general-meeting')}}" target="_blank" class="list-group-item">AGM &amp; Special GM</a>
	                <a href="{{route('front.announcement.category','share-allotment')}}" target="_blank" class="list-group-item">Share Allot &amp; Refund</a>
	                <a href="{{route('front.announcement.category','certificate-and-dividend')}}" target="_blank" class="list-group-item">Certificate &amp; Dividend</a>
	                <a href="{{route('front.announcement.category','issue-open')}}" target="_blank" class="list-group-item">Issue Open</a>
	                <a href="{{route('front.announcement.category','issue-close')}}" target="_blank" class="list-group-item">Issue Close</a>
	                <a href="{{route('front.announcement.category','book-closure')}}" target="_blank" class="list-group-item">Book Closure</a>
	                <a href="{{route('front.announcement.category','press-release')}}" target="_blank" class="list-group-item">Press Release/Notice</a>
	                <a href="{{route('front.announcement.category','treasury-bill')}}" target="_blank" class="list-group-item">Treasury Bill</a>
	                <a href="{{route('event')}}" target="_blank" class="list-group-item">Event Calender</a>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<h4 class="category-heading" class="list-group-item">Economy</h4>
				<div class="list-group">
					<a href="{{route('front.budget')}}" target="_blank" class="list-group-item">Budget</a>
					<a href="{{route('front.economy')}}" target="_blank" class="list-group-item">Economic Statistics</a>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('endscript')
@endsection