<footer class="footer-distributed">
	<div class="footer-left">
		<h3>Investo Nepal</h3>

		<p class="footer-links">
			<a href="{{route('index')}}">Home</a>
			·
			<a href="{{route('front.siteMap')}}">Site Map</a>
			·
			<a href="{{ route('front.about') }}">About</a>
			·
			<a href="{{route('front.contact')}}">Contact</a>
		</p>

		<p class="footer-company-name">Investo Nepal &copy; 2016</p>
	</div>

	<div class="footer-center">

		<div>
			<i class="fa fa-map-marker"></i>
			<p><span>{{config('investonepal.FOOTER_ADDRESS_LINE_1')}}</span>{{config('investonepal.FOOTER_ADDRESS_LINE_2')}}</p>
		</div>

		<div>
			<i class="fa fa-phone"></i>
			<p>{{config('investonepal.FOOTER_PHONE_NO')}}</p>
		</div>

		<div>
			<i class="fa fa-envelope"></i>
			<p><a href="mailto:{{config('investonepal.FOOTER_EMAIL')}}">{{config('investonepal.FOOTER_EMAIL')}}</a></p>
		</div>
		
		<div>
			<i class="fa fa-clock-o"></i>
			<p>{{config('investonepal.FOOTER_OFFICE_HOURS')}}</p>
		</div>
	</div>

	<div class="footer-right">

		<p class="footer-company-about">
			<span>About the website</span>
			{{config('investonepal.FOOTER_SLUG')}}
			<div>
				<p><a href="\ourteam">Our Development Team</a></p>
			</div>
		</p>

		<div class="footer-icons">

			<a href="{{config('investonepal.FACEBOOK_LINK')}}" target="_blank"><i class="fa fa-facebook"></i></a>
			<a href="{{config('investonepal.TWITTER_LINK')}}" target="_blank"><i class="fa fa-twitter"></i></a>

		</div>

	</div>

</footer>