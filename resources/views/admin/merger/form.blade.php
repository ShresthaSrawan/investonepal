<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('type', 'Type') !!}
            {!! Form::select('type', ['MERGER' => 'MERGER', 'ACQUISITION' => 'ACQUISITION'], old('type'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('type') !!}</i></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('status', 'Status') !!}
            {!! Form::select('status', ['ON PROCESS' => 'ON PROCESS', 'COMPLETED' => 'COMPLETED'], old('status'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('status') !!}</i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('companies', 'Companies') !!}
            {!! Form::text('companies',old('companies'),['class'=>'form-control', 'required']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('companies') !!}</i></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('company_id', 'Company') !!}
            {!! Form::select('company_id', $companies, old('company_id'),['class'=>'form-control', 'required']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('company_id') !!}</i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('remarks', 'Remarks') !!}
            {!! Form::text('remarks',old('remarks'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('remarks') !!}</i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('loi_date', 'LOI Date') !!}
            {!! Form::input('date', 'loi_date',old('loi_date'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('loi_date') !!}</i></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('deadline_date', 'Deadline Date') !!}
            {!! Form::input('date', 'deadline_date',old('deadline_date'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('deadline_date') !!}</i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('application_date', 'Application Date') !!}
            {!! Form::input('date', 'application_date',old('application_date'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('application_date') !!}</i></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('mou_date', 'MOU date') !!}
            {!! Form::input('date', 'mou_date',old('mou_date'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('mou_date') !!}</i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('approved_date', 'Approved Date') !!}
            {!! Form::input('date', 'approved_date',old('approved_date'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('approved_date') !!}</i></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('join_transaction_date', 'Join Transaction Date') !!}
            {!! Form::input('date', 'join_transaction_date',old('join_transaction_date'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('join_transaction_date') !!}</i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('swap_ratio', 'Swap Ratio') !!}
            {!! Form::text('swap_ratio',old('swap_ratio'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('swap_ratio') !!}</i></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('trading', 'Trading') !!}
            {!! Form::select('trading', ['YES' => 'YES', 'NO' => 'NO', 'SUSPEND' => 'SUSPEND'], old('trading'),['class'=>'form-control']) !!}
            <span class="error-display"><i style='color: red;'>  {!! $errors->first('trading') !!}</i></span>
        </div>
    </div>
</div>