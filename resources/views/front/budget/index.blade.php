@extends('front.main')

@section('title')
Budget
@endsection

@section('specificheader')
<style type="text/css">
	.budget-selectors{
		margin-top: 10px;
		margin-bottom: 10px;
	}
</style>
@endsection

@section('content')
<section class="col-md-9 col-xs-12 main-content">
	<div class="row budget-selectors">
		<div class="col-md-3">
			{!! Form::select('fiscal_year_id',$fiscalYear,old('fiscal_year_id'),['class'=>'form-control fiscalYear','id'=>'fiscalYear']) !!}
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-pills" style="margin-bottom:10px;">
				<li class="active"><a href="#budgetSource" data-toggle="tab" aria-expanded="true">Source</a></li>
				<li class=""><a href="#budgetExpense" data-toggle="tab" aria-expanded="true">Expense</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade active in" id="budgetSource">
				</div>
				<div class="tab-pane fade" id="budgetExpense">
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('endscript')
<script>
	var budgetURL = "{{route('api-get-budget')}}";
</script>
{!! HTML::script('assets/nsm/front/js/budget.js') !!}
@endsection