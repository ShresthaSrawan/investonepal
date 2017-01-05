<div class="form-group">
    {!! Form::label('name', 'Name',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Namrata Shrestha','required'=>'required']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('name')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('post_id', 'Post',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-md-10">
        {!! Form::select('post_id',$posts,old('post_id'),['class'=>'form-control','required'=>'required']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('post_id')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('fiscal_year', 'Fiscal Year',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        <?php
        $fiscalYr = old('fiscal_year');
        if(is_null($fiscalYr)){
            $fiscalYr = (isset($fisYears)) ? $fisYears : null;
        }
        ?>
        {!! Form::select('fiscal_year[]',$fiscalYears,$fiscalYr,['class'=>'form-control mymulti','data-placeholder'=>'Select Fiscal Year(s).','multiple'=>'multiple','required'=>'required']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('fiscal_year')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('photo', 'Photo', ['class'=>'col-lg-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::input('file','photo',old('photo'),['class'=>'form-control file']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('photo')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('profile', 'Profile',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::textarea('profile',old('profile'),['class'=>'form-control']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('profile')}}</i></span>
    </div>
</div>


