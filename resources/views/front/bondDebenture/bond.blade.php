@extends('front.main')

@section('title')
Bond &amp; Debenture
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
							<th>Face Value</th>
							<th>Kitta</th>
							<th>Maturity Period</th>
							<th>Issue Open Date</th>
							<th>Issue Close Date</th>
							<th>Company</th>
							<th>Quote</th>
							<th>Details</th>
							<th>Coupon Interest Rate</th>
							<th>Interest Payment Method</th>
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
	var bondURL = "{{route('front.bondAndDebenture')}}";
	var bondTable;
</script>
{!! HTML::script('vendors/dataTables/Responsive-1.0.7/js/dataTables.responsive.min.js') !!}
<script href="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js" type="text/javascript"></script>
{!! HTML::script('assets/nsm/front/js/bond.js') !!}
@endsection