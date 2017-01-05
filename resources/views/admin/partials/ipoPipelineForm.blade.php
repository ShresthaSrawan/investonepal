<div class="form-group">
    {!! Form::label('company', 'Company',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::select('company_id',$company,old('company_id'),['class'=>'form-control chosen-select']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('company_id')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('announcement_subtype_id', 'Type of Securities',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::select('announcement_subtype_id',$announcementSubtype,old('announcement_subtype_id'),['class'=>'form-control']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('announcement_subtype_id')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('amount_of_securities', 'Amount of Securities',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::input('number','amount_of_securities',old('amount_of_securities'),['step'=>'any','class'=>'form-control','placeholder'=>'Number']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('amount_of_securities')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('amount_of_public_issue', 'Amount of Public Issue',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::input('number','amount_of_public_issue',old('amount_of_public_issue'),['step'=>'any','class'=>'form-control','placeholder'=>'Number']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('amount_of_public_issue')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('approval_date', 'Approval Date', ['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::input('date','approval_date',old('approval_date'),['class'=>'form-control eventdate', 'placeholder'=>'Approval Date ex. 20/20/2015']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('approval_date')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('issue_manager', 'Issue Manager',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
      <?php
        if(array_key_exists('issue_manager',old())){
          $selectedIM = old('issue_manager');
        }else{
          if(isset($ipoPipeline)){
            $selectedIM = $ipoPipeline->ipoIssueManager->lists('issue_manager_id')->toArray();
          }else{
            $selectedIM = [];
          }
        }
      ?>
        {!! Form::select('issue_manager[]',$issueManager,$selectedIM,['class'=>'form-control issueManager mymulti','multiple'=>'multiple']) !!}

    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('issue_manager')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('remarks', 'Remarks', ['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::input('remarks','remarks',old('remarks'),['class'=>'form-control ']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('remarks')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('fiscal_year_id', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::select('fiscal_year_id',$fiscalYear,old('fiscal_year_id'),['class'=>'form-control']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('fiscal_year_id')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('application_date', 'Application Date', ['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::input('date','application_date',old('application_date'),['class'=>'form-control eventdate', 'placeholder'=>'Application Date ex. 02/02/2015']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('application_date')}}</i></span>
    </div>
</div>
