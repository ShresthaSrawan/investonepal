<!-- Navigation -->
<header class="menu-header" style="padding:0; background:#fff;">
	<div class="container container-navbar">
		<div class="brand-header">
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-md-4">
							<a href="{{url('/')}}" class="link" rel="canonical"><h2 class="website-title">Investo
									Nepal</h2>
							</a>
						</div>
						<div class="col-md-8 social text-right">
							<div class="row">
								<div class="col-md-2 col-sm-12 no-padding">
									<a href="{{config('investonepal.FACEBOOK_LINK')}}" class="link facebook"
									   target="_blank">
										<i class="fa fa-fw fa-2x fa-facebook-square" style="vertical-align:middle;"></i>
									</a>
									<a href="{{config('investonepal.TWITTER_LINK')}}" class="link twitter" target="_blank">
										<i class="fa fa-fw fa-2x fa-twitter-square" style="vertical-align:middle;"></i>
									</a>
								</div>
								<div class="col-md-5 col-sm-12 company-search">
									{!! Form::open(['route'=>'quote','id'=>'company-search-form']) !!}
									<select name="quote" id="quote"
											class="display-none search-company-selector-nav form-control search-select"
											required="required" style="visibility: hidden;"></select>
									{!! Form::close() !!}
								</div>
								<div class="col-md-5 col-sm-12 google-search">
									<script>
										(function() {
											var cx = '005878212215278482749:9hkp2lg7-de';
											var gcse = document.createElement('script');
											gcse.type = 'text/javascript';
											gcse.async = true;
											gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
													'//cse.google.com/cse.js?cx=' + cx;
											var s = document.getElementsByTagName('script')[0];
											s.parentNode.insertBefore(gcse, s);
										})();
									</script>
									<gcse:searchbox-only></gcse:searchbox-only>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="navbar yamm navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" data-toggle="collapse" data-target="#navbar-collapse" class="navbar-toggle"><span
								class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
					</button>
					<a href="{{route('index')}}" class="navbar-brand hide">Investo Nepal</a>
				</div>
				<div id="navbar-collapse" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="yamm-fw"><a href="{{route('index')}}">Home</a>
						<li class="dropdown yamm-fw"><a href="{{route('front.news.index')}}"
														class="dropdown-toggle yamm-ddt" aria-expanded="false">News<b
										class="caret"></b></a>
							<ul class="dropdown-menu nsm-dropdown">
								<li>
									<div class="yamm-content container">
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<h4>General</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.news.category','stock')}}">Sharebazar</a>
													</li>
													<li><a href="{{route('front.news.category','tourism')}}">Tourism</a>
													</li>
													<li><a href="{{route('front.news.category','insurance')}}">Insurance</a>
													</li>
													<li>
														<a href="{{route('front.news.category','employment')}}">Employment</a>
													</li>
													<li>
														<a href="{{route('front.news.category','hydropower')}}">Hydropower</a>
													</li>
													<li><a href="{{route('front.news.category','real-estate')}}">Real
															Estate</a></li>
													<li><a href="{{route('front.news.tags.show','merger')}}">Merger</a></li>
												</ul>
											</div>
											<div class="col-xs-6 col-md-3">
												<h4>Commodity</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.news.category','bullion')}}">Bullion</a>
													</li>
													<li><a href="{{route('front.news.category','energy')}}">Energy</a></li>
												</ul>
												<h4>Forex</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.news.category','currency')}}">Currency</a>
													</li>
												</ul>
											</div>
											<div class="col-xs-6 col-md-3">
												<h4>Opinion</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.interviewArticle.index','article')}}">Article</a>
													</li>
													<li><a href="{{route('front.interviewArticle.index','interview')}}">Interview</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<li class="dropdown yamm-fw"><a href="{{route('stock','today')}}" class="dropdown-toggle yamm-ddt"
														aria-expanded="false">Stock<b class="caret"></b></a>
							<ul class="dropdown-menu nsm-dropdown">
								<li>
									<div class="yamm-content container">
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<h4>General</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('stock','index')}}">Index</a></li>
													<li><a href="{{route('stock','today')}}">Today's Price</a></li>
													<li><a href="{{route('stock','floorsheet')}}">Floorsheet</a></li>
													<li><a href="{{route('stock','newhighlow')}}">New High/Low</a></li>
													<li><a href="{{route('stock','advancedecline')}}">Advance/Decline</a>
													</li>
													<li><a href="{{route('stock','topperformers')}}">Gainer+Loser+Active</a>
													</li>
												</ul>
											</div>
											<div class="col-xs-6 col-md-3">
												<h4>Insights</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('stock','marketreport')}}">Market Report</a></li>
													<li><a href="{{route('stock','averageprice')}}">Average Price</a></li>
													<li><a href="{{route('stock','lastprice')}}">Last Traded Price</a></li>
													<li><a href="{{route('front.bodApproved')}}">Benifits BOD Approved</a>
													</li>
													<li><a href="{{route('front.agm')}}">Annual General Meeting (AGM)</a>
													</li>
													<li><a href="{{route('front.certificate')}}">Certificates and Benifits
															Distribution</a></li>
												</ul>
											</div>
											<div class="col-xs-6 col-md-3">
												<h4>IPO</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.ipoPipeline')}}">IPO Pipeline</a></li>
													<li><a href="{{route('front.ipoResult')}}">IPO Allotment</a></li>
												</ul>
												<h4>Issue</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.issue')}}">Current+Upcoming</a></li>
												</ul>
											</div>
											<div class="col-xs-6 col-md-3">
												<h4>Company</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.basePrice')}}">Base Price</a></li>
													<li><a href="{{route('front.issueManager')}}">Issue Manager</a></li>
													<li><a href="{{route('front.brokerageFirm')}}">Brokerage Firm</a></li>
												</ul>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<li class="dropdown yamm-fw">
							<a href="{{route('front.market')}}" class="dropdown-toggle yamm-ddt" aria-expanded="false">Market<b
										class="caret"></b></a>
							<ul class="dropdown-menu nsm-dropdown">
								<li>
									<div class="yamm-content container">
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<h4>Commodity</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.bullion','hallmark')}}">Gold</a></li>
													<li><a href="{{route('front.bullion','silver')}}">Silver</a></li>
													<li><a href="{{route('front.energy')}}">Energy</a></li>
												</ul>
											</div>
											<div class="col-xs-6 col-md-3">
												<h4>Securities</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.treasury')}}">Treasury Bill</a></li>
													<li><a href="{{route('front.bondAndDebenture')}}">Bond &amp;
															Debenture</a></li>
												</ul>
											</div>
											<div class="col-xs-6 col-md-3">
												<h4>Forex</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.currency')}}">Currency</a></li>
												</ul>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<li class="dropdown yamm-fw">
							<a href="{{route('front.announcement.index')}}" class="dropdown-toggle yamm-ddt"
							   aria-expanded="false">Announcement<b class="caret"></b></a>
							<ul class="dropdown-menu nsm-dropdown">
								<li>
									<div class="yamm-content container">
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<h4>General</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.announcement.category','issue-auction')}}">Auction</a>
													</li>
													<li>
														<a href="{{route('front.announcement.category','financial-report')}}">Financial
															Report</a></li>
													<li>
														<a href="{{route('front.announcement.category','annual-general-meeting')}}">AGM
															&amp; Special GM</a></li>
													<li>
														<a href="{{route('front.announcement.category','share-allotment')}}">Share
															Allot &amp; Refund</a></li>
													<li>
														<a href="{{route('front.announcement.category','certificate-and-dividend')}}">Certificate
															&amp; Dividend</a></li>
												</ul>
											</div>
											<div class="col-xs-6 col-md-3">
												<h4>Issue</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.announcement.category','issue-open')}}">Issue
															Open</a></li>
													<li><a href="{{route('front.announcement.category','issue-close')}}">Issue
															Close</a></li>
													<li><a href="{{route('front.announcement.category','book-closure')}}">Book
															Closure</a></li>
													<li><a href="{{route('front.announcement.category','press-release')}}">Press
															Release/Notice</a></li>
												</ul>
											</div>
											<div class="col-xs-6 col-md-3">
												<h4>Event</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('event')}}">Event Calender</a></li>
												</ul>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<li class="dropdown yamm-fw">
							<a href="#" class="dropdown-toggle yamm-ddt" aria-expanded="false">Economy<b class="caret"></b></a>
							<ul class="dropdown-menu nsm-dropdown">
								<li>
									<div class="yamm-content container">
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<h4>Economy</h4>
												<ul class="unlist no-padding">
													<li><a href="{{route('front.budget')}}">Budget</a></li>
													<li><a href="{{route('front.economy')}}">Economic Statistics</a></li>
												</ul>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<li class="dropdown yamm-fw">
							<a href="#" data-target="#technical-analysis" data-toggle="modal">Technical Analysis</a>
						</li>
						<li class="dropdown yamm-fw">
							<a href="/forum" target="_blank">Forum</a>
						</li>
						@if(Auth::check())
							@include('front.partials.client-nav')
						@else
							<li class="dropdown yamm-fw">
								<a href="{{route('login')}}">Asset Mgmt</a>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>