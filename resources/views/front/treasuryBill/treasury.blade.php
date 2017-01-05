@extends('front.main')

@section('title')
Treasury Bill
@endsection

@section('specificheader')
{!! HTML::style('vendors/dataTables/Responsive-1.0.7/css/responsive.bootstrap.css') !!}
@endsection

@section('content')
	<section class="col-md-9 col-xs-12 main-content">
		<div class="row" style="padding-top:10px;">
			<div class="col-sm-12">
	            <div class="form-group">
	                <div class='input-group' id="fiscal-year">
	                	<span class="input-group-addon">Fiscal Year</span>
	                    {!! Form::select('fiscal_year_id',$fiscalYear,old('fiscal_year_id'),['class'=>'form-control fiscalYear']) !!}
	                </div>
	            </div>
	        </div>
		</div>
		<div class="row no-margin">
			<div class="col-md-12">
				<table id="datatable" class="table datatable table-condensed table-striped display responsive no-wrap with-border" width="100%">
					<thead>
						<tr>
							<th>Title</th>
							<th>Highest Discount Rate</th>
							<th>Lowest Discount Rate</th>
							<th>Bill Days</th>
							<th>Issue Open Date</th>
							<th>Issue Close Date</th>
							<th>Company</th>
							<th>Quote</th>
							<th>Detail</th>
							<th>Weighted Average Rate</th>
							<th>SLR Rate</th>
							<th>Issue Amount</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</section>
@endsection

@section('endscript')
<script>
	var treasuryBillURL = "{{route('front.treasury')}}";
	var treasuryBillTable;
</script>
{!! HTML::script('vendors/dataTables/Responsive-1.0.7/js/dataTables.responsive.min.js') !!}
{!! HTML::script('assets/nsm/front/js/treasury.js') !!}
@endsection