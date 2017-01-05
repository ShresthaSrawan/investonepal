@if(isset($create))
<div class="form-group">
    {!! Form::label('company_id', 'Company',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::select('company_id',$company,old('company_id'),['class'=>'form-control chosen-select','data-placeholder'=>'Select a company','required'=>'','id'=>'company']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('company_id')}}</i></span>
    </div>
</div>
@endif
<div class="form-group">
    {!! Form::label('quarter_id', 'Quarter',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::select('quarter_id',$quarter,old('quarter_id'),['class'=>'form-control','data-placeholder'=>'Select a quarter','required'=>'']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('quarter_id')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('fiscal_year_id', 'Fiscal Year',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::select('fiscal_year_id',$fiscalYear,old('fiscal_year_id'),['class'=>'form-control','data-placeholder'=>'Select a fiscal year','required'=>'']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('fiscal_year_id')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('entry_by', 'Entry By',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::text('entry_by',old('entry_by'),['class'=>'form-control','placeholder'=>'Hari Ram','required'=>'']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('entry_by')}}</i></span>
    </div>
</div>
@if(isset($create))
<div class="form-group">
    {!! Form::label('entry_date', 'Entry Date',['class'=>'col-lg-2 control-label required']) !!}
    <?php
        $date = (old('entry_date') == NULL) ? date("Y-m-d") : old('entry_date');
    ?>
    <div class="col-sm-10">
        {!! Form::input('date','entry_date',$date,['class'=>'form-control','required'=>'']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('entry_date')}}</i></span>
    </div>
</div>
@else
<div class="form-group">
    {!! Form::label('entry_date', 'Entry Date',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-sm-10">
        {!! Form::input('date','entry_date',old('entry_date'),['class'=>'form-control','required'=>'']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('entry_date')}}</i></span>
    </div>
</div>
@endif