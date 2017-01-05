@extends('admin.master')

@section('title')
Budget
@endsection

@section('specificheader')
@endsection

@section('content')

<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">
			<i class="fa fa-file"></i> Budget Source :Create:
		</h3>
		<h3 class="box-title pull-right">
			<i class="fa fa-calendar"></i> Fiscal Year: {{$fiscalYear->label}}
		</h3>
	</div>
	<div class="box-body">
		<div class="col-lg-12">
			<div class="form-group">
				<label class="sr-only">Budget Label</label>
				<div class="input-group col-lg-10 col-lg-offset-1">
					{!! Form::select('budgetLabel',$budgetLabel,null,['class'=>'form-control budgetLabel'])!!}
					<span class="input-group-btn">
					<button class="btn btn-default" type="button" id="showSubLabel"><i class="fa fa-plus"></i> Add</button>
				</span>
				</div>
			</div>
		</div>
		{!! Form::open(['route'=>['admin.fiscalYear.budget.store',$fiscalYear->id,$type],'class'=>'form form-horizontal']) !!}
		<div class="col-md-12">
			<div class="subLabelPlaceHolder">

			</div>
			<div class="budgetLabelPlaceHolder">

			</div>
			<div class="budgetSubmitPlaceHolder">
				<div class="form-group">
					<div class="input-group col-lg-10 col-lg-offset-1">
						<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Create</button>
					</div>
				</div>
			</div>
		</div>
		{!! Form::close () !!}
	</div>
</div>

@endsection
@section('endscript')
<script>
    var budgetLabelSearchUrl = "{{route('admin.api-search-budgetLabel')}}";
</script>
{!! HTML::script('/assets/nsm/admin/js/budget.js') !!}
@endsection