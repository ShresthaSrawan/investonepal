@extends('front.main')

@section('title')
    Profile: Watchlist
@endsection

@section('specificheader')
{!! HTML::style('assets/nsm/front/css/quote.css') !!}

<style type="text/css">
	.dismiss{
		position: absolute;
	    top: -10px;
	    right: -15px;
	    color: #ddd;
	    border: 0;
	    background: transparent;
	}
	.dismiss:hover{
		color: #aaa;
	}
	.card .panel-heading{
		background: #fff;
		color:#000;
		border: none;
	}
	.card .panel-body{
		border: none;
	}
	.panel-body>div{
		padding: 0;
	}
	.card .panel{
		border: 1px solid rgba(204, 204, 204, 0.5);
		box-shadow: 1px 1px 5px 1px rgba(200,200,200,0.3);
	}
	.card .panel:hover{
		box-shadow: 2px 2px 5px 1px rgba(200,200,200,0.5);
	}
	.watchlist-quote{
		font-size: 1.3em;
		font-weight: bold;
	}
	.watchlist-name{
		font-size: 0.9em;
		text-align: right;
		text-overflow: ellipsis;
	}
	.watchlist-close{
		font-size: 2.5em;
		font-weight: 100;
		color: #ccc;
	}
	.watchlist-date{
		font-size: 0.8em
	}
	.watchlist-difference{
		padding-top: 20px;
		text-align: right;
	}
	.watchlist-percent{
		text-align: right;
	}
	.fa-caret-down{
		color: #f00;
	}
	.fa-caret-up{
		color: #188811;
	}
</style>
@endsection

@section('content')
<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">My Watchlist</h3>
		  </div>
		  <div class="panel-body">
		  	<div class="row card">
			@foreach($watchlists as $watchlist)
				<?php 
					$diff = $latestTradedPrice[$watchlist->company_id]->difference;
					$sign = 'neutral';
					if($diff>0):
						$sign = 'up';
					elseif($diff<0):
						$sign = 'down';
					endif;
			?>
			<div class="col-sm-6">
				<a href="{{route('quote',$watchlist->company->quote)}}" class="link" target="_blank">
					<div class="panel panel-default">
						<div class="panel-heading">
						    <span class="col-xs-4 pull-left watchlist-quote">{{$watchlist->company->quote}}</span>
						    <span class="col-xs-8 pull-right watchlist-name" style="position:relative">
						    	{{$watchlist->company->name}}
								{!! Form::open(['route'=>'watchlist']) !!}
								<button type="submit" class="dismiss"><i class="fa fa-times"></i></button>
								<input type="hidden" value="{{$watchlist->company_id}}" name="company_id" />
								<input type="hidden" value="1" name="redirect" />
								{!! Form::close() !!}
						    </span>
					  	</div>
			  			<div class="panel-body">
				  			<div class="col-xs-6 pull-left">
				  				<div class="watchlist-close col-xs-12">
				  					<i class="fa fa-caret-{{$sign}}"></i> {{$latestTradedPrice[$watchlist->company_id]->close}}
				  				</div>
								<div class="watchlist-date col-xs-12">{{$latestTradedPrice[$watchlist->company_id]->date}}
								</div>
				  			</div>
				  			<div class="col-xs-6">
				  				<div class="watchlist-difference col-xs-12">
				  					<span data-change="{{$sign}}">{{$latestTradedPrice[$watchlist->company_id]->difference}}</span>
			  					</div>
								<div class="watchlist-percent col-xs-12">
									<span data-change="{{$sign}}">{{$latestTradedPrice[$watchlist->company_id]->percentage}} %</span>
								</div>
				  			</div>
			  			</div>
		  			</div>
	  			</a>
  			</div>
			@endforeach
		  	</div>
		  </div>
		</div>
	</div>
	<div class="col-md-3"></div>
</div>
@endsection