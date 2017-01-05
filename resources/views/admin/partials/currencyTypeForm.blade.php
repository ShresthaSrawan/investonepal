<div class="form-group">
	<div class="col-md-2">{!! Form::label('country_name', 'Country Name',['class'=>'required']) !!}</div>
    <div class="col-lg-8">
        {!! Form::text('country_name',null,['class'=>'form-control','placeholder'=>'Nepal','required'=>'required']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('country_name')}}</i></span>
    </div>
</div>

<div class="form-group">
	<div class="col-md-2">{!! Form::label('name', 'Currency Type',['class'=>'required']) !!}</div>
    <div class="col-md-8">
        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nepali','required'=>'required']) !!}
    </div>
    <div class="col-md-10 col-md-offset-2">
        <span class="text-danger"><i>{{$errors->first('name')}}</i></span>
    </div>
</div>

<div class="form-group">
	<div class="col-md-2">{!! Form::label('unit', 'Currency Unit',['class'=>'required']) !!}</div>   
    <div class="col-lg-8">
        {!! Form::text('unit',null,['class'=>'form-control','placeholder'=>'1','required'=>'required']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('unit')}}</i></span>
    </div>
</div>    

<div class="form-group">
	<div class="col-md-2">{!! Form::label('country_flag', 'Country Flag',['class'=>'required']) !!}</div>	   
    <div class="col-lg-8">
        {!! Form::input('file','country_flag',null,['class'=>'form-control']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('photo')}}</i></span>
    </div>
</div>