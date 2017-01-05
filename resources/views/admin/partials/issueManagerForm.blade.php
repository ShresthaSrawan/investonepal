<div class="form-group">
    {!! Form::label('company', 'Company',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::text('company',old('company'),['class'=>'form-control','placeholder'=>'XYZ Pvt. Ltd.','required'=>'required']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('company')}}</i></span>
    </div>
</div>

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
    {!! Form::label('address', 'Address',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('address',old('address'),['class'=>'form-control','placeholder'=>'Lalitpur, Bagmanti']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('address')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('phone', 'Phone',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('phone',old('phone'),['class'=>'form-control','placeholder'=>'7654321']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('phone')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('email', 'Email',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('email',old('email'),['class'=>'form-control','placeholder'=>'example@domain.com']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('email')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('web', 'Web',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('web',old('web'),['class'=>'form-control','placeholder'=>'www.domain.com']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('web')}}</i></span>
    </div>
</div>

