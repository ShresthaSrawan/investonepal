@extends('admin.master')

@section('title')
IPO Result
@endsection

@section('specificheader')
{!! HTML::style('vendors/chosen/chosen.css') !!}
@endsection()

@section('content')

{!! Form::open(['route' => 'admin.ipo-result.store','files'=>true]) !!}
<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-file-text fa-fw"></i>IPO Result :Add</h3>
	</div>
	<div class="box-body">
		<div class="row">
		    <div class="col-md-12">
		    	<div class="row">            
		            <div class="col-md-6" id="options">
		                <span id="companyList">
		                    {!! Form::label('company_id', 'Company') !!}
		                    {!! Form::select('company_id',$company,old('company_id'),['class'=>'form-control']) !!}
		                    <span class="text-danger"><i>{{$errors->first('company_id')}}</i></span>
		                </span>	                
		            </div>
		            <div class="col-md-6">
		                {!! Form::label('date', 'Date') !!}
		                <?php
		                    $date = (old('date') == NULL) ? date("Y-m-d") : old('date');
		                ?>
		                {!! Form::input('date','date',$date,['class'=>'form-control', '', 'required'=>'']) !!}
		                <span class="text-danger"><i>{{$errors->first('date')}}</i></span>
		            </div>
		        </div>
		        <div class="row" style="padding-top:20px;">
		            <div class="col-md-12">
			            <div class="alert alert-info" role="alert">
			            	{!! Form::label('excel', 'Excel') !!}
			            	{!! Form::input('file','excel',old('excel'),['class'=>'form-control', 'files'=>true]) !!}
			            	<span class="text-danger"><i>{{$errors->first('excel')}}</i></span>
	                        Ipo Result should be in XLSX and must match the format provided below.
	                        <a href="{{url('/')}}/assets/sample_reports/ipo_result_sample.xlsx">Sample.
	                        </a>
				        </div>
			        </div>
		        </div>
		        <div class="row">
		            <div class="col-sm-12">
	                    {!! Form::submit('Add',['class'=>'btn btn-primary']) !!}
	                    {!! Form::reset('Clear',['class'=>'btn btn-primary']) !!}
		            </div>
		        </div>
		    </div>
		    <div class="col-sm-4"></div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@endsection

@section('endscript')
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
<script type="text/javascript">
	var config = {
        allow_single_deselect:true,
        disable_search_threshold:5,
        no_results_text:'No company found with name '
    };
    $(document).ready(function(){
        $('select[name=company_id]').chosen(config);
    });
</script>
@endsection