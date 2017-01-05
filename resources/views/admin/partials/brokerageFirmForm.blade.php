<div class="form-group">
    {!! Form::label('firmName', 'Firm Name',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::text('firm_name',old('firmName'),['class'=>'form-control','placeholder'=>'XYZ Pvt. Ltd.','required'=>'required']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('firmName')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('code', 'Code',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::text('code',old('code'),['class'=>'form-control','placeholder'=>'Code','required'=>'required']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('code')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('phone', 'Phone',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('phone',old('phone'),['class'=>'form-control','placeholder'=>'01-5550612']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('phone')}}</i></span>
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
    {!! Form::label('directorName', 'Director Name',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('director_name',old('directorName'),['class'=>'form-control','placeholder'=>'Priyanka Karki']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('directorName')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('mobile', 'Mobile',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('mobile',old('mobile'),['class'=>'form-control','placeholder'=>'9851011111']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('mobile')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('photo', 'Photo',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::input('file','photo',null,['class'=>'form-control file']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('photo')}}</i></span>
    </div>
</div>