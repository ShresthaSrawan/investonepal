@extends('admin.master')

@section('title')
Financial Report
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <table class="table-condensed borderless">
            <thead>
                <th style="font-size: 25px; font-weight: 400">
                    <i class="fa fa-file"></i> Financial Report :Show:
                </th>
            </thead>
            <tbody>
                <tr>
                    <th>Company</th>
                    <td>: {{ucwords($financialReport->company->name)}}</td>
                </tr>
                <tr>
                    <th>Fiscal Year</th>
                    <td>: {{($financialReport->fiscalYear->label)}}</td>
                </tr>
                <tr>
                    <th>Quarter</th>
                    <td>: {{($financialReport->quarter->label)}}</td>
                </tr>
                <tr>
                    <th>Sector</th>
                    <td>: {{ucwords($financialReport->company->sector->label)}}</td>
                </tr>
            </tbody>
        </table>
    </div><!-- /.box-header -->
    <div class="box-body nav-tabs-custom">
        <ul class="nav nav-tabs">
			<li role="presentation" class="active">
				<a href="#" onclick="showBalanceSheet()" id="showBSBtn">Balance Sheet</a>
			</li>
			<li role="presentation">
				<a href="#" onclick="showIncomeStatement()" id="showISBtn">Income Statement</a>
			</li>
			<li role="presentation">
				<a href="#" onclick="showConsolidateRevenue()" id="showCRBtn">Consolidate Revenue Account</a>
			</li>
		</ul>
		<div class="tab-pane" id='balanceSheet'>
			</br>
			@if(!($financialReport->balanceSheet->isEmpty()))
				<h3 style="text-align: center;">Balance Sheet</h3>
				<a href="{{route('admin.financialReport.balanceSheet.edit', 
					['fid'=>$financialReport->id])}}" class="btn btn-primary btn-sm pull-right">
					<i class="fa fa-edit"></i> Edit
				</a>
				<table class="table table-condensed table-hover">
			        <thead>
			            <tr>
			            	<th style="width: 5%;">#</th>
			                <th style="width: 80%;">Attribute</th>
			                <th style="width: 15%;">Value</th>
			            </tr>
			        </thead>
			        <tbody>
			        	<?php $counter=0; ?>
			            @foreach($financialReport->balanceSheet as $report)
			            <tr>
			            	<td>{{++$counter}}</td>
			                <td>{{$report->reportLabel->label}}</td>
			                <td>{{is_null($report->value) ? 'NA' : $report->value}}</td>
			            </tr>
			            @endforeach
			        </tbody>
		        </table>
		        <div class="box-footer clearfix">
		        	{!! Form::open(['route'=>['admin.financialReport.balanceSheet.destroy',$financialReport->id],'method'=>'delete']) !!}
				        <button type="button" class="btn btn-danger btn-sm delbtn pull-right" 
				        data-toggle="modal" data-target="#deleteReport">
	                        <i class="fa fa-trash"></i> Delete
				        </button>
					{!! Form::close() !!}
				</div>
			@else
				<div class="alert alert-validation" role="alert">
					<p style="line-height:2.5;">
						There is no balance sheet for 
						{{ucwords($financialReport->company->name)}}, 
						{{($financialReport->fiscalYear->label)}}, 
						{{($financialReport->quarter->label)}}.
						<a href="{{route('admin.financialReport.balanceSheet.create', $financialReport->id)}}" class="btn btn-primary btn-sm pull-right">
							<i class="fa fa-plus"></i> Create
						</a>
					</p>
				</div>
				{!! Form::open(['route'=>['admin.financialReport.upload',$financialReport->id,'bs'],'files'=>true]) !!}
					<div class="alert alert-validation" role="alert">
						<div class="row">
							<div class="col-lg-6">
								Before uploading balance sheet, please download sample file <a href="{{route('admin.sampleReport',['type'=>'bs'])}}" style="color:green">here</a>.
							</div>
							<div class="col-lg-6" style="margin-bottom: -15px">
								<div class="form-group">
									<div class="input-group">
										<input type="file" name="file" class="form-control">
										<div class="input-group-btn">
				                            <button class="btn btn-primary btn-flat" type="submit">
				                            	<i class="fa fa-upload"></i>
				                            </button>
			                            </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			@endif
		</div>
		<div class="tab-pane" id='incomeStatement'>
			</br>
			@if(!($financialReport->incomeStatement->isEmpty()))
				<h3 style="text-align: center;">Income Statement</h3>
				<a href="{{route('admin.financialReport.incomeStatement.edit', 
					['fid'=>$financialReport->id])}}" class="btn btn-primary btn-sm pull-right">
					<i class="fa fa-edit"></i> Edit
				</a>
				<table class="table table-condensed table-hover">
			        <thead>
			            <tr>
			                <th style="width: 5%;">#</th>
			                <th style="width: 80%;">Attribute</th>
			                <th style="width: 15%;">Value</th>
			            </tr>
			        </thead>
			        <tbody>
			        	<?php $counter=0; ?>
			            @foreach($financialReport->incomeStatement as $report)
			            <tr>
			            	<td>{{++$counter}}</td>
			                <td>{{$report->reportLabel->label}}</td>
			                <td>{{is_null($report->value) ? 'NA' : $report->value}}</td>
			            </tr>
			            @endforeach
			        </tbody>
		        </table>
		        <div class="box-footer clearfix">
		        	{!! Form::open(['route'=>['admin.financialReport.incomeStatement.destroy',$financialReport->id],'method'=>'delete']) !!}
				        <button type="button" class="btn btn-danger btn-sm delbtn pull-right" 
				        data-toggle="modal" data-target="#deleteReport">
	                        <i class="fa fa-trash"></i> Delete
				        </button>
					{!! Form::close() !!}
				</div>
			@else
				<div class="alert alert-validation" role="alert">
					<p style="line-height:2.5;">
						There is no income statement for 
						{{ucwords($financialReport->company->name)}}, 
						{{($financialReport->fiscalYear->label)}}, 
						{{($financialReport->quarter->label)}}.
						<a href="{{route('admin.financialReport.incomeStatement.create', $financialReport->id)}}" class="btn btn-primary btn-sm pull-right">
							<i class="fa fa-plus"></i> Create
						</a>
					</p>
				</div>
				{!! Form::open(['route'=>['admin.financialReport.upload',$financialReport->id,'is'],'files'=>true]) !!}
					<div class="alert alert-validation" role="alert">
						<div class="row">
							<div class="col-lg-6">
								Before uploading income statement, please download sample file <a href="{{route('admin.sampleReport',['type'=>'is'])}}" style="color:green">here</a>.
							</div>
							<div class="col-lg-6" style="margin-bottom: -15px">
								<div class="form-group">
									<div class="input-group">
										<input type="file" name="file" class="form-control">
										<div class="input-group-btn">
				                            <button class="btn btn-primary btn-flat" type="submit">
				                            	<i class="fa fa-upload"></i>
				                            </button>
			                            </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			@endif
		</div>
		<div class="tab-pane" id='consolidateRevenue'>
			</br>
			@if(!($financialReport->consolidateRevenue->isEmpty()))
				<h3>Consolidate Revenue</h3>
				<a href="{{route('admin.financialReport.consolidateRevenue.edit', 
					['fid'=>$financialReport->id])}}" class="btn btn-primary btn-sm pull-right">
					<i class="fa fa-edit"></i> Edit
				</a>
				<table class="table table-condensed table-hover">
			        <thead>
			            <tr>
			                <th style="width: 5%;">#</th>
			                <th style="width: 80%;">Attribute</th>
			                <th style="width: 15%;">Value</th>
			            </tr>
			        </thead>
			        <tbody>
			        	<?php $counter=0; ?>
			            @foreach($financialReport->consolidateRevenue as $report)
			            <tr>
			            	<td>{{++$counter}}</td>
			                <td>{{$report->reportLabel->label}}</td>
			                <td>{{is_null($report->value) ? 'NA' : $report->value}}</td>
			            </tr>
			            @endforeach
			        </tbody>
		        </table>
		        <div class="box-footer clearfix">
		        	{!! Form::open(['route'=>['admin.financialReport.consolidateRevenue.destroy',$financialReport->id],'method'=>'delete']) !!}
				        <button type="button" class="btn btn-danger btn-sm delbtn pull-right" 
				        data-toggle="modal" data-target="#deleteReport">
	                        <i class="fa fa-trash"></i> Delete
				        </button>
					{!! Form::close() !!}
				</div>
			@else
				<div class="alert alert-validation" role="alert">
					<p style="line-height:2.5;">
						There is no consolidate revenue account for 
						{{ucwords($financialReport->company->name)}}, 
						{{($financialReport->fiscalYear->label)}}, 
						{{($financialReport->quarter->label)}}.
						<a href="{{route('admin.financialReport.consolidateRevenue.create', $financialReport->id)}}" class="btn btn-primary btn-sm pull-right">
							<i class="fa fa-plus"></i> Create
						</a>
					</p>
				</div>
				{!! Form::open(['route'=>['admin.financialReport.upload',$financialReport->id,'cr'],'files'=>true]) !!}
					<div class="alert alert-validation" role="alert">
						<div class="row">
							<div class="col-lg-6">
								Before uploading consolidate revenue account, please download sample file <a href="{{route('admin.sampleReport',['type'=>'cr'])}}" style="color:green">here</a>.
							</div>
							<div class="col-lg-6" style="margin-bottom: -15px">
								<div class="form-group">
									<div class="input-group">
										<input type="file" name="file" class="form-control">
										<div class="input-group-btn">
				                            <button class="btn btn-primary btn-flat" type="submit">
				                            	<i class="fa fa-upload"></i>
				                            </button>
			                            </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			@endif
		</div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this report?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger confirm-delete">
                    <i class="fa fa-trash"></i> Yes
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('endscript')
<script type="text/javascript">
	$(document).ready(function(){
		showBalanceSheet();
	});

	$(document).on('click','.delbtn',function(e){
        e.preventDefault();
        $form=$(this).closest('form');
        $modal=$('#deleteReport');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });

	function showBalanceSheet () {
		$('#balanceSheet').show();
		$('#showBSBtn').parent().addClass('active');
		$('#incomeStatement').hide();
		$('#showISBtn').parent().removeClass('active');
		$('#consolidateRevenue').hide();
		$('#showCRBtn').parent().removeClass('active');
	}
	function showIncomeStatement () {
		$('#balanceSheet').hide();
		$('#showBSBtn').parent().removeClass('active');
		$('#incomeStatement').show();
		$('#showISBtn').parent().addClass('active');
		$('#consolidateRevenue').hide();
		$('#showCRBtn').parent().removeClass('active');
	}
	function showConsolidateRevenue () {
		$('#balanceSheet').hide();
		$('#showBSBtn').parent().removeClass('active');
		$('#incomeStatement').hide();
		$('#showISBtn').parent().removeClass('active');
		$('#consolidateRevenue').show();
		$('#showCRBtn').parent().addClass('active');
	}
</script>
@endsection