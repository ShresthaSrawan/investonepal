@extends('front.main')

@section('title')
Base Price
@endsection

@section('specificheader')
<style type="text/css">
	.dataTables_filter {
	    display: block;
	}
</style>
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
			<table id="datatable" class="table datatable table-condensed table-striped table-responsive with-border" width="100%">
				<thead>
					<tr>
						<th class="hidden-xs hidden-sm">SN</th>
						<th>Quote</th>
						<th>Company</th>
						<th>Sector</th>
						<th>Price</th>
						<th>Date</th>
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
	var basePriceURL = "{{route('api-get-base-price')}}";
	var basePriceTable;
</script>
<script href="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js" type="text/javascript"></script>
{!! HTML::script('assets/nsm/front/js/baseprice.js') !!}
@endsection