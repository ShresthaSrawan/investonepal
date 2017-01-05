@extends('admin.master')

@section('title')
Financial Report
@endsection

@section('content')
@include('admin.partials.errors')
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
				<a href="#" onclick="showProfitLoss()" id="showPLBtn">Profit Loss</a>
			</li>
			@if((strtolower($financialReport->company->sector->label) == strtolower('Commercial Banks')
            || strtolower($financialReport->company->sector->label) == strtolower('Development Bank') 
            || strtolower($financialReport->company->sector->label) == strtolower('Finance')) && $financialReport->quarter_id == '5')
            	<li role="presentation">
					<a href="#" onclick="showPrincipalIndicators()" id="showPIBtn">Principal Indicators</a>
				</li>
            @endif
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
							<i class="fa fa-plus-square"></i> Create
						</a>
					</p>
				</div>
				<div class="alert alert-validation" role="alert">
					{!! Form::open(['route'=>['admin.financialReport.upload',$financialReport->id,'bs'],'files'=>true]) !!}
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
					{!! Form::close() !!}
				</div>
			@endif
		</div>
		<div class="tab-pane" id='profitLoss'>
			</br>
			@if(!($financialReport->profitLoss->isEmpty()))
				<h3 style="text-align: center;">Profit &amp; Loss</h3>
				<a href="{{route('admin.financialReport.profitLoss.edit', 
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
			            @foreach($financialReport->profitLoss as $report)
			            <tr>
			            	<td>{{++$counter}}</td>
			                <td>{{$report->reportLabel->label}}</td>
			                <td>{{is_null($report->value) ? 'NA' : $report->value}}</td>
			            </tr>
			            @endforeach
			        </tbody>
		        </table>
		        <div class="box-footer clearfix">
		        	{!! Form::open(['route'=>['admin.financialReport.profitLoss.destroy',$financialReport->id],'method'=>'delete']) !!}
				        <button type="button" class="btn btn-danger btn-sm delbtn pull-right" 
				        data-toggle="modal" data-target="#deleteReport">
	                        <i class="fa fa-trash"></i> Delete
				        </button>
					{!! Form::close() !!}
				</div>
			@else
				<div class="alert alert-validation" role="alert">
					<p style="line-height:2.5;">
						There is no profit and loss for 
						{{ucwords($financialReport->company->name)}}, 
						{{($financialReport->fiscalYear->label)}}, 
						{{($financialReport->quarter->label)}}.
						<a href="{{route('admin.financialReport.profitLoss.create', $financialReport->id)}}" class="btn btn-primary btn-sm pull-right">
							<i class="fa fa-plus-square"></i> Create
						</a>
					</p>
				</div>
				<div class="alert alert-validation" role="alert">
					{!! Form::open(['route'=>['admin.financialReport.upload',$financialReport->id,'pl'],'files'=>true]) !!}
							<div class="row">
								<div class="col-lg-6">
									Before uploading profit loss, please download sample file <a href="{{route('admin.sampleReport',['type'=>'pl'])}}" style="color:green">here</a>.
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
					{!! Form::close() !!}
				</div>
			@endif
		</div>
		@if((strtolower($financialReport->company->sector->label) == strtolower('Commercial Banks')
            || strtolower($financialReport->company->sector->label) == strtolower('Development Bank') 
            || strtolower($financialReport->company->sector->label) == strtolower('Finance')) && $financialReport->quarter_id == '5')
			<div class="tab-pane" id='principalIndicators'>
				</br>
				@if(!($financialReport->principalIndicators->isEmpty()))
					<h3 style="text-align: center;">Principal Indicator</h3>
					<a href="{{route('admin.financialReport.principalIndicators.edit', 
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
				            @foreach($financialReport->principalIndicators as $report)
				            <tr>
				            	<td>{{++$counter}}</td>
				                <td>{{$report->reportLabel->label}}</td>
				                <td>{{is_null($report->value) ? 'NA' : $report->value}}</td>
				            </tr>
				            @endforeach
				        </tbody>
			        </table>
			        <div class="box-footer clearfix">
		        	{!! Form::open(['route'=>['admin.financialReport.principalIndicators.destroy',$financialReport->id],'method'=>'delete']) !!}
				        <button type="button" class="btn btn-danger btn-sm delbtn pull-right" 
				        data-toggle="modal" data-target="#deleteReport">
	                        <i class="fa fa-trash"></i> Delete
				        </button>
					{!! Form::close() !!}
					</div>
				@else
					<div class="alert alert-validation" role="alert">
						<p style="line-height:2.5;">
							There is no principal indicator for 
							{{ucwords($financialReport->company->name)}}, 
							{{($financialReport->fiscalYear->label)}}, 
							{{($financialReport->quarter->label)}}.
							<a href="{{route('admin.financialReport.principalIndicators.create', $financialReport->id)}}" class="btn btn-primary btn-sm pull-right">
								<i class="fa fa-plus-square"></i> Create
							</a>
						</p>
					</div>
					<div class="alert alert-validation" role="alert">
					{!! Form::open(['route'=>['admin.financialReport.upload',$financialReport->id,'pi'],'files'=>true]) !!}
							<div class="row">
								<div class="col-lg-6">
									Before uploading principal indicators, please download sample file <a href="{{route('admin.sampleReport',['type'=>'pi'])}}" style="color:green">here</a>.
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
					{!! Form::close() !!}
				</div>
				@endif
			</div>
		@endif
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
		$('#profitLoss').hide();
		$('#showPLBtn').parent().removeClass('active');
		$('#principalIndicators').hide();
		$('#showPIBtn').parent().removeClass('active');
	}
	function showProfitLoss () {
		$('#balanceSheet').hide();
		$('#showBSBtn').parent().removeClass('active');
		$('#profitLoss').show();
		$('#showPLBtn').parent().addClass('active');
		$('#principalIndicators').hide();
		$('#showPIBtn').parent().removeClass('active');
	}
	function showPrincipalIndicators () {
		$('#balanceSheet').hide();
		$('#showBSBtn').parent().removeClass('active');
		$('#profitLoss').hide();
		$('#showPLBtn').parent().removeClass('active');
		$('#principalIndicators').show();
		$('#showPIBtn').parent().addClass('active');
	}
</script>
@endsection