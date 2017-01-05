@extends('front.main')

@section('title')
Economy
@endsection

@section('specificheader')
<style>
	.panel-default > .panel-heading, .panel-footer {
		background-color: #F7F8FC;
		color: #295FA6;
	}
</style>
@endsection

@section('content')
<section class="row">
	<div class="col-md-9">
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
			@foreach($filteredLabel as $key=>$label)
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="heading{{$key}}">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}" class="collapsed">
								{{strtoupper($label->name)}} [+]
							</a>
						</h4>
					</div>
					<div id="collapse{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$key}}">
						<div class="panel-body">
							<table id="datatable" class="table datatable table-condensed table-hover table-responsive table-striped with-border no-margin">
								<thead>
									<tr>
										<th class="col-md-4">Fiscal Year</th>
										<th class="col-md-4">Published Date</th>
										<th class="col-md-4">Value</th>
									</tr>
								</thead>
								<tbody>
								@foreach($label->getRecentEconomyValue as $eco)
									<tr>
										<td>{{$eco->economy->fiscalYear->label}}</td>
										<td>{{date_create($eco->date)->format('M-d, Y')}}</td>
										<td>{{$eco->value}}</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>
@endsection

@section('endscript')
@endsection