@extends('front.main')

@section('specificheader')
<style type="text/css">
	#index-toggle{
		margin-top: 25px;
	}
	#index-col{
		margin-top: 20px;
	}
	#indexDatatable{
		margin: 0 !important;
	}
</style>
{!! HTML::style('vendors/dataTables/FixedHeader-3.0.0/css/fixedHeader.bootstrap.min.css') !!}
@endsection

@section('title')
	Stock : Today's Price
@endsection

@section('content')
	<section class="main-content row">
		<div class="col-md-12">
			<div class="row" style="padding-top:10px;">
				<div class="col-md-1 visible-md-block visible-lg-block">
					<a class="btn btn-primary" role="button" data-toggle="collapse" id="index-toggle" href="#collapseIndex" aria-expanded="true" aria-controls="collapseIndex"><i class="fa fa-bars"></i></a>
				</div>
				<div class="col-md-4">
					<label for="date" class="control-label">Todays Price as of:</label>
					<div class="form-group">
		                <div class='input-group date datepicker'>
		                    <input type='text' class="form-control searchdate" value="" id="date" />
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>
				</div>
				<div class="col-md-3">
					<label for="sector">Sector:</label>
					{!! Form::select('sector',['0'=>'All']+$sectorList,0,['class'=>'sector form-control','id'=>'sector']) !!}
				</div>
				<div class="col-md-4">
					<label for="searchbox">Search:</label>
					<input type="text" id="searchbox" class="form-control">
				</div>
			</div>
			<div class="row no-margin">
				<div class="col-sm-12" id="index-col">					
					<div class="collapse row well in" id="collapseIndex">
					  <div class="col-md-6">
					    <table id="summaryDatatable" class="table datatable table-condensed table-striped responsive with-border display no-wrap" width="100%">
							<thead>
								<th>As of <strong><span data-value="date"></span></strong></th>
								<th></th>
							</thead>
							<tbody>
								<tr>
									<td>Scripts</td>
									<td data-value="total_company"></td>
								</tr>
								<tr>
									<td>Advance</td>
									<td data-value="advance"></td>
								</tr>
								<tr>
									<td>Decline</td>
									<td data-value="decline"></td>
								</tr>
								<tr>
									<td>Unchanged</td>
									<td data-value="neutral"></td>
								</tr>
								<tr>
									<td>Transactions</td>
									<td data-value="total_tran"></td>
								</tr>
								<tr>
									<td>Volume</td>
									<td data-value="total_vol"></td>
								</tr>
								<tr>
									<td>Amount</td>
									<td data-value="total_amt" class="nrs commas"></td>
								</tr>
								<tr>
									<td>Market Capitalization (Mil.)</td>
									<td data-value="market_cap" class="nrs commas"></td>
								</tr>
								<tr>
									<td>Float Market Capitalization  (Mil.)</td>
									<td data-value="float_cap" class="nrs commas"></td>
								</tr>
							</tbody>
						</table>
					  </div>
					  <div class="col-md-6">
					  	<div class="index-datatable no-padding">
						    <table id="indexDatatable" class="table datatable table-condensed table-striped responsive display no-wrap" width="100%">
								<thead>
									<th>S.N.</th>
									<th>Index</th>
									<th>Value</th>
									<th>Change</th>
									<th>Percent</th>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					  </div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<table id="datatable" class="table datatable table-condensed table-striped responsive display no-wrap with-border" width="100%">
						<thead>
							<tr>
								<th>SN</th>
								<th>Name</th>
								<th>Quote</th>
								<th>Tran.</th>
								<th>Open</th>
								<th>High</th>
								<th>Low</th>
								<th>Close</th>
								<th title="Traded Shares">T.Shares</th>
								<th>Amount</th>
								<th title="Previous Close">P.Close</th>
								<th title="Change">Ch.</th>
								<th title="Percentage Change">% Ch.</th>
								<th title="52 High">52H</th>
								<th title="52 Low">52L</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
						<tfoot>
    						<tr>
    							<th></th><th>Total</th><th></th>
                				<th id="totalTran"></th>
                				<th></th><th></th><th></th><th></th>
                				<th id="totalVol"></th>
                				<th colspan="2" id="totalAmt" class="text-left nrs formatted_comma"></th>
                				<th></th><th></th><th></th><th></th>
            				</tr>
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
@section('endscript')
<script type="text/javascript">
	var todaysPriceURL = "{{route('api-get-todays-price-day')}}";
	var indexSummaryDatatableURL = "{{route('api-get-index-summary-datatable')}}";
	var todaysSummaryURL = "{{route('api-get-todays-summary-datatable')}}";
	var lastDate = "{{$lastDate}}";
	var indexTable,table;
	$('.index-datatable').slimScroll({height: '310px'});
</script>
	{!! HTML::script('vendors/dataTables/FixedHeader-3.0.0/js/dataTables.fixedHeader.min.js') !!}
	{!! HTML::script('assets/nsm/front/js/todaysPrice.js') !!}
@endsection