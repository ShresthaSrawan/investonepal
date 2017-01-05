@extends('front.main')

@section('title')
Certificates and Benifits Distribution
@endsection

@section('specificheader')
@endsection

@section('content')
<section class="main-content col-md-9 col-xs-12">
	<div class="row">
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
						<th class="hidden-sm hidden-xs">SN</th>
						<th class="hidden-sm hidden-xs">Company</th>
						<th class="hidden-lg">Quote</th>
						<th>Detail</th>
						<th class="hidden-sm hidden-xs">Bonus</th>
						<th class="hidden-sm hidden-xs">Cash Dividend</th>
						<th>Distribution Date</th>
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
	var certificateURL = "{{route('front.certificate')}}";
	var certificateTable;
</script>
{!! HTML::script('assets/nsm/front/js/certificate.js') !!}
@endsection