@extends('front.main')

@section('title')
	Market
@endsection

@section('specificheader')
<style type="text/css">
    .marketdata:not(:last-child){
        border-bottom: 1px #f1f1f1 solid; 
    }
    .market-data-type{
        text-transform: capitalize;
    }
</style>
@endsection

@section('content')
<section class="main-content col-md-9">
    <?php $market = ['stock','bullion','currency','energy'];?>
    @foreach($market as $m)
    	<div class="row" style="padding-top:10px;">
            <div class="col-sm-8">
                <h3 class="category-heading" style="margin-top:15px;">
					@if($m=='stock')
						<a href="{{route('stock','index')}}" class="link">
					@elseif($m=='bullion')
						<a href="{{route('front.bullion')}}" class="link">
					@elseif($m=='currency')
						<a href="{{route('front.currency')}}" class="link">
					@elseif($m=='energy')
						<a href="{{route('front.energy')}}" class="link">
					@endif
						{{ucwords($m)}}
						</a>
				</h3>
            </div>
            <div class="col-sm-4" style="text-align:right;">
                <div class="form-group no-margin">
                    <div class='input-group market-date datepicker' id="{{$m}}datepicker">
                        <input type='text' class="form-control" value="" id="{{$m}}marketdate" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    	<div class="row marketdata no-margin">
            <div class="col-sm-12 no-padding">
                <table class="table datatable responsive table-striped table-condensed table-hover with-border" width="100%" id="{{$m}}datatable">
                    <thead>
                        @if($m!='currency')
                            <tr>
                                <th class="market-data-type">Type</th>
                                <th>Close Price</th>
                                <th class="hidden-sm hidden-xs">Previous Close</th>
                                <th>Change</th>
                                <th class="hidden-sm hidden-xs">% Change</th>
                            </tr>
                        @else
                            <tr>
                                <th>Type</th>
                                <th>Buy</th>
                                <th class="hidden-sm hidden-xs" title="Previous Buy">Pre.Buy</th>
                                <th title="Change (Buy)">C.Buy</th>
                                <th>Sell</th>
                                <th class="hidden-sm hidden-xs" title="Percent Sell">Pre.Sell</th>
                                <th title="Change (Sell)">C.Sell</th>
                            </tr>
                        @endif
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</section>
@endsection

@section('endscript')
<script type="text/javascript">
	var marketDataByDateURL = "{{route('front.market')}}";
    var latestDate = {!!json_encode($latestDate)!!};
</script>
	{!! HTML::script('vendors/date/date.js') !!}
    {!! HTML::script('assets/nsm/front/js/market.js') !!}
@endsection