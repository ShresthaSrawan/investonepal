<div class="row">
    <div class="col-md-6">
        {!! Form::label('first_name', 'First Name') !!}
        {!! Form::text('userInfo[first_name]',old('first_name'),['class'=>'form-control','placeholder'=>'Eg. John']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('userInfo.first_name') !!}</i></span>
    </div>
    <div class="col-md-6">
        {!! Form::label('last_name', 'Last Name') !!}
        {!! Form::text('userInfo[last_name]',old('last_name'),['class'=>'form-control','placeholder'=>'Eg. Doe']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('userInfo.last_name') !!}</i></span>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {!! Form::label('address', 'Address') !!}
        {!! Form::text('userInfo[address]',old('address'),['class'=>'form-control','placeholder'=>'Eg. Kathmandu, Nepal']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('userInfo.address') !!}</i></span>
    </div>
    <div class="col-md-6">
        {!! Form::label('work', 'Occupation') !!}
        {!! Form::text('userInfo[work]',old('work'),['class'=>'form-control','placeholder'=>'Eg. Reporter']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('userInfo.work') !!}</i></span>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {!! Form::label('dob', 'Date of Birth') !!}
        {!! Form::input('date','userInfo[dob]',old('dob'),['class'=>'form-control']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('userInfo.dob') !!}</i></span>
    </div>
    <div class="col-md-6">
        {!! Form::label('expiry_date', 'Expiry Date',['class'=>'required']) !!}
        {!! Form::input('date','expiry_date',old('expiry_date'),['class'=>'form-control','required'=>'required']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('expiry_date') !!}</i></span>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {!! Form::label('username', 'Username',['class'=>'required']) !!}
        {!! Form::text('username',old('username'),['class'=>'form-control','placeholder'=>'Eg. john123','required'=>'required']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('username') !!}</i></span>
    </div>
    <div class="col-md-6">{!! Form::label('profile_picture', 'Profile Picture (Max: 2 MB)') !!}
        {!! Form::input('file','profile_picture',old('profile_picture'),['class'=>'form-control file']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('profile_picture') !!}</i></span>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {!! Form::label('email', 'E-Mail',['class'=>'required']) !!}
        {!! Form::text('email',old('email'),['class'=>'form-control','placeholder'=>'Eg. johndoe@domain.com','required'=>'required']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('email') !!}</i></span>

    </div>
    <div class="col-md-6">
        {!! Form::label('phone', 'Phone No.') !!}
        {!! Form::text('userInfo[phone]',old('phone'),['class'=>'form-control','placeholder'=>'Eg. XXX-XXXXXXXXXX']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('userInfo.phone') !!}</i></span>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {!! Form::label('password', 'Password') !!}
        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Eg. Secret password']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('password') !!}</i></span>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {!! Form::label('password_confirmation', 'Password Conformation') !!}
        {!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Eg. Secret Password']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('password_confirmation') !!}</i></span>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php 
            $type = old('type');
            if(!$type && isset($user)){
                $type = $user->type_id;
            }
        ?>
        {!! Form::label('type', 'User Type',['class'=>'required']) !!}
        {!! Form::select('type',$usertypes,$type,['class'=>'form-control','required'=>'required']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('type') !!}</i></span>
    </div>
    <div class="col-md-6">
        {!! Form::label('status', 'Status',['class'=>'required']) !!}
        {!! Form::select('status',['0'=>'Inactive','1'=>'Active'],null,['class'=>'form-control','required'=>'required']) !!}
        <span class="error-display"><i style='color: red;'>  {!! $errors->first('status') !!}</i></span>
    </div>
</div>