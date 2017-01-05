@extends('front.main')

@section('title')
Brokerage Firm
@endsection

@section('specificheader')
<style type="text/css">
	.dataTables_filter {
	    display: block;
	}
	.dataTables_wrapper>.row:nth-child(1){
		padding-top: 10px;
	}
</style>
@endsection

@section('content')
<section class="col-md-9 col-xs-12 main-content">
	<div class="row no-margin">
		<div class="col-md-12">
			<table id="datatable" class="table datatable table-condensed table-striped table-responsive with-border" width="100%">
				<thead>
					<tr>
						<th class="hidden-xs hidden-sm">S.N.</th>
						<th>Firm</th>
						<th>Code</th>
						<th class="hidden-xs hidden-sm">Director</th>
						<th>Address</th>
						<th class="hidden-xs hidden-sm">Mobile</th>
						<th>Phone</th>
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
	var brokerageFirmURL = "{{route('api-get-brokerage-firm')}}";
	var brokerageFirmTable;
</script>
{!! HTML::script('assets/nsm/front/js/brokeragefirm.js') !!}
@endsection