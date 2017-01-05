@extends('front.main')

@section('title')
Annual General Meeting
@endsection

@section('specificheader')
{!! HTML::style('vendors/dataTables/Responsive-1.0.7/css/responsive.bootstrap.css') !!}
@endsection

@section('content')
<section class="main-content col-md-12 col-xs-12">
	<div class="row" id="fiscal-year">
		<div class="col-sm-6">
            <div class="form-group">
                <div class='input-group'>
                	<span class="input-group-addon">Fiscal Year</span>
                    {!! Form::select('fiscal_year_id',$fiscalYear,old('fiscal_year_id'),['class'=>'form-control fiscalYear']) !!}
                </div>
            </div>
        </div>
		<div class="col-sm-6">
            <div class="form-group">
                <div class='input-group' id="sector">
                	<span class="input-group-addon">Sector</span>
                    {!! Form::select('sector_id',$sectors, old('sector_id'),['class'=>'form-control sector']) !!}
                </div>
            </div>
        </div>
	</div>
	<div class="row no-margin">
		<div class="col-md-12">
			<table id="datatable" class="table datatable table-condensed table-striped table-responsive with-border" width="100%">
				<thead>
					<tr>
						<th>Company</th>
						<th>Quote</th>
						<th>Count</th>
						<th>Venue</th>
						<th>Date</th>
						<th>Time</th>
						<th>Bonus</th>
						<th>Cash Dividend</th>
						<th>Book Closure From</th>
						<th>Book Closure To</th>
						<th>Agenda</th>
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
	var agmURL = "{{route('front.agm')}}";
	var agmTable;
</script>
{!! HTML::script('vendors/dataTables/Responsive-1.0.7/js/dataTables.responsive.min.js') !!}
{!! HTML::script('assets/nsm/front/js/agm.js') !!}
@endsection