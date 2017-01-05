@extends('front.main')

@section('title')
Benifits BOD Approved
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
        <div class="col-sm-12">
            <div class="form-group">
                <div class='input-group' id="sector-list">
                    <span class="input-group-addon">Sector</span>
                    {!! Form::select('sector_id',$sectorList,old('sector_id'),['class'=>'form-control sectorList']) !!}
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
						<th>Bonus</th>
						<th>Cash Dividend</th>
						<th>Approved Date</th>
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
	var bodApprovedURL = "{{route('front.bodApproved')}}";
	var bodApprovedTable;
</script>
{!! HTML::script('assets/nsm/front/js/bodapproved.js') !!}
@endsection