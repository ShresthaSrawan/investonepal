@extends('front.main')

@section('title')
IPO Pipeline
@endsection

@section('specificheader')
{!! HTML::style('vendors/dataTables/Responsive-1.0.7/css/responsive.bootstrap.css') !!}
<style>
tbody .text-upper{text-transform: uppercase;}
</style>
@endsection

@section('content')
<section class="col-md-12 col-xs-12 main-content">
	<div class="row" style="padding-top:10px;">
		<div class="col-sm-12">
            <div class="form-group">
                <div class='input-group' id="fiscal-year">
                	<span class="input-group-addon">Fiscal Year</span>
                    {!! Form::select('fiscal_year_id',[0 => 'Select any'] + $fiscalYear,old('fiscal_year_id'),['class'=>'form-control fiscalYear']) !!}
                </div>
            </div>
        </div>
	</div>
	<div class="row no-margin">
		<div class="col-md-12">
			<table id="datatable" class="table datatable table-condensed display no-wrap table-striped table-responsive with-border" width="100%">
				<thead>
					<tr>
						<th>SN</th>
						<th>Company</th>
						<th>Quote</th>
						<th>Sector</th>
						<th>Issue Type</th>
						<th class="amt">Issue Amount</th>
						<th class="appdate">Application Date</th>
						<th class="approval">Approval Date</th>
						<th>Issue Manager</th>
						<th>Remarks</th>
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
	var ipoPipelineURL = "{{route('api-get-ipo-pipeline')}}";
	var pipelineTable;

	function xycss_text_abbrev(){
		if($(window).width() <= 767) {
			$('.amt').text('AMT');
			$('.appdate').text('APP.D');
			$('.approval').text('Approval');
		} else {
			$('.amt').text('Issue Amount');
			$('.appdate').text('Application Date');
			$('.approval').text('Approval Date');
		}
	}
	$(document).ready(function(){
		xycss_text_abbrev();
	});
	$(window).resize(function() {
		xycss_text_abbrev();
	});
</script>
{!! HTML::script('vendors/dataTables/Responsive-1.0.7/js/dataTables.responsive.min.js') !!}
{!! HTML::script('assets/nsm/front/js/ipopipeline.js') !!}
@endsection