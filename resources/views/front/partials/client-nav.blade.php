<li class="dropdown">
    <a href="#" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        {{Auth::user()->username}}
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li><a href="{{route('user.profile')}}">Profile</a></li>
        @if(Auth::check() && !(Auth::user()->isAdmin()))
            <li><a href="#">Assets Mgmt</a></li>
        @elseif(Auth::check() && Auth::user()->isAdmin())
            <li><a href="{{route('admin.dashboard')}}">My Dashboard</a></li>
        @endif
        <li><a href="{{route('watchlist')}}">My Watchlist</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="/logout">Logout</a></li>
    </ul>
</li>