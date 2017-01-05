@extends('admin.master')

@section('title')
Budget &amp; Expense
@endsection

@section('content')
@include('admin.partials.validation')
<div class="box box-info">
	<div class="box-header with-border">
		<h2>
			Fiscal Year: {{$fiscalYear->label}}
		</h2>
		<ul class="nav nav-pills">
			<li class="active"><a href="#budgetSource" data-toggle="tab" aria-expanded="true">Source</a></li>
			<li class=""><a href="#budgetExpense" data-toggle="tab" aria-expanded="true">Expense</a></li>
		</ul>
	</div>
	<div class="box-body">
		<div class="tab-content">
			<div class="tab-pane fade active in" id="budgetSource">
				<?php $budgets = $fiscalYear->budget;?>
				@if($fiscalYear->hasType(0))
					<div class="col-lg-12">
						<div class="btn-group pull-right" role="group" aria-label="...">
							<a href="{{route('admin.fiscalYear.budget.edit',['id'=>$fiscalYear->id,'type'=>0])}}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
						</div>
					</div>
					<div class="col-lg-12">
					</br>
						@foreach($budgets as $budget)
							@if($budget->budgetLabel->type == 0)
								<div class="table-responsive">
									<table class="table table-condensed table-bordered">
										<thead>
										<tr class="active">
											<th style="width: 70%;">
												<strong>{{$budget->budgetLabel->label}}</strong>
											</th>
											<th style="width:30%;">
												<form action="{{route('admin.fiscalYear.budget.destroy',['id'=>$fiscalYear->id,'budget'=>$budget->id])}}" method="post" class="pull-right deleteBudgetForm">
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<input type="hidden" name="_method" value="delete">
													<button type="submit" class="btn btn-danger btn-sm deleteBudget"><i class="glyphicon glyphicon-trash"></i> Delete</button>
												</form>
											</th>
										</tr>
										</thead>
										<tbody>
										@if(!$budget->budgetLabel->subLabel->isEmpty())
											@foreach($budget->budgetLabel->subLabel as $sl)
												<tr>
													<td>{{$sl->label}}</td>
													<td>{{is_null($sl->getSubValue($budget->id)) ? 'NA' : $sl->getSubValue($budget->id)->value}}</td>
												</tr>
											@endforeach
										@endif
										</tbody>
										<tfoot>
										<tr>
											<th>Total</th>
											<th><strong>{{$budget->value}}</strong></th>
										</tr>
										</tfoot>
									</table>
								</div>
							@endif
						@endforeach
					</div>
				@else
					<div class="alert alert-validation" role="alert">
						<p style="line-height:2.5;">
							There is no budget source for
							{{($fiscalYear->label)}}.
							<a href="{{route('admin.fiscalYear.budget.create',[$fiscalYear->id, 0])}}" class="btn btn-primary btn-sm pull-right">
								<i class="fa fa-plus"></i> Create
							</a>
						</p>
					</div>
				@endif
			</div>
			<div class="tab-pane fade" id="budgetExpense">
				<?php $budgets = $fiscalYear->budget;?>
				@if($fiscalYear->hasType(1))
					<div class="col-lg-12">
						<div class="btn-group pull-right" role="group" aria-label="...">
							<a href="{{route('admin.fiscalYear.budget.edit',['id'=>$fiscalYear->id,'type'=>1])}}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
						</div>
					</div>
					<div class="col-lg-12">
					</br>
						@foreach($budgets as $budget)
							@if($budget->budgetLabel->type == 1)
								<div class="table-responsive">
									<table class="table table-condensed table-bordered">
										<thead>
										<tr class="active">
											<th style="width: 70%;">
												<strong>{{$budget->budgetLabel->label}}</strong>
											</th>
											<th style="width: 30%;">
												<form action="{{route('admin.fiscalYear.budget.destroy',['id'=>$fiscalYear->id,'budget'=>$budget->id])}}" method="post" class="pull-right deleteBudgetForm">
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<input type="hidden" name="_method" value="delete">
													<button type="submit" class="btn btn-danger btn-sm deleteBudget"><i class="glyphicon glyphicon-trash"></i> Delete</button>
												</form>
											</th>
										</tr>
										</thead>
										<tbody>
										@if(!$budget->budgetLabel->subLabel->isEmpty())
											@foreach($budget->budgetLabel->subLabel as $sl)
												<tr>
													<td>{{$sl->label}}</td>
													<td>{{is_null($sl->getSubValue($budget->id)) ? 'NA' : $sl->getSubValue($budget->id)->value}}</td>
												</tr>
										@endforeach
										@endif
										</tbody>
										<tfoot>
										<tr>
											<th>Total</th>
											<th><strong>{{$budget->value}}</strong></th>
										</tr>
										</tfoot>
									</table>
								</div>
							@endif
						@endforeach
					</div>
				@else
					<div class="alert alert-validation" role="alert">
						<p style="line-height:2.5;">
							There is no budget expense for
							{{($fiscalYear->label)}}.
							<a href="{{route('admin.fiscalYear.budget.create',[$fiscalYear->id, '1'])}}" class="btn btn-primary btn-sm pull-right">
								<i class="fa fa-plus"></i> Create
							</a>
						</p>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
<div class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="deleteBudget" id="deleteBudget">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
			</div>
			<div class="modal-body">
				<h5>Are you sure you want to delete?</h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="confirmDelete"><i class="glyphicon glyphicon-trash"></i> Delete</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('endscript')
<script>
	$(document).ready(function(){
		var $submit = $('button[type=submit].deleteBudget');
		var $modal = $('#deleteBudget');
		var $submitted = '';
		$submit.click(function(e){
			e.preventDefault();
			$submitted = $(this);
			$modal.modal('show');
		});

		$('#confirmDelete').click(function(){
			$submitted.parent().submit();
		});
	});
</script>
@endsection