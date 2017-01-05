        <div class="row">
            <div class="col-md-9">
                {!! Form::label('name', 'Company Name',['class'=>'required']) !!}
                {!! Form::text('name',old('name'),['class'=>'form-control','required'=>'required']) !!}
                <span class="error-display"><i style='color: red;'>  {!! $errors->first('name') !!}</i></span>
            </div>
            <div class="col-md-3">
                {!! Form::label('quote', 'Quote',['class'=>'required']) !!}
                {!! Form::text('quote',old('quote'),['class'=>'form-control','style'=>'text-transform:uppercase;','required'=>'required']) !!}
                <span class="error-display"><i style='color: red;'>  {!! $errors->first('quote') !!}</i></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('sector', 'Sector',['class'=>'required']) !!}
                {!! Form::select('sector[id]',$sectors,null,['class'=>'form-control','required'=>'required']) !!}
            </div>
            <div class="col-md-6">{!! Form::label('logo', 'Logo') !!}
                {!! Form::input('file','logo',old('logo'),['class'=>'form-control file']) !!}
                <span class="text-danger"><i>{{$errors->first('logo')}}</i></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                {!! Form::label('listed', 'Listed') !!}
                {!! Form::checkbox('listed','1',false,['id'=>'listed']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('listed_shares', 'Listed Shares') !!}
                {!! Form::input('number','listed_shares',old('listed_shares'),['step'=>'any','class'=>'form-control shares']) !!}
                <span class="error-display"><i style='color: red;'>  {!! $errors->first('listed_shares') !!}</i></span>
            </div>
            <div class="col-md-3">
                {!! Form::label('face_value', 'Face Value') !!}
                {!! Form::input('number','face_value',old('face_value'),['step'=>'any','class'=>'form-control facevalue']) !!}
                <span class="error-display"><i style='color: red;'>  {!! $errors->first('face_value') !!}</i></span>
            </div>
            <div class="col-md-4">
                {!! Form::label('total_paid_up_value', 'Total Paid Up Value') !!}
                {!! Form::input('number','total_paid_up_value',null,['step'=>'any','class'=>'form-control paidupvalue','id'=>'total_paid_up_value','readonly'=>'readonly']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('phone', 'Phone') !!}
                {!! Form::text('details[phone]',old('phone'),['class'=>'form-control']) !!}
                <span class="error-display"><i style='color: red;'>  {!! $errors->first('details.phone') !!}</i></span>
            </div>  
            <div class="col-md-6">
                {!! Form::label('address', 'Address') !!}
                {!! Form::text('details[address]',old('address'),['class'=>'form-control']) !!}
                <span class="error-display"><i style='color: red;'>  {!! $errors->first('details.address') !!}</i></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('web', 'Website') !!}
                {!! Form::text('details[web]',old('web'),['class'=>'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('email', 'E-Mail') !!}
                {!! Form::text('details[email]',old('email'),['class'=>'form-control']) !!}
                <span class="error-display"><i style='color: red;'>  {!! $errors->first('details.email') !!}</i></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('operation_date', 'Operation Date') !!}
                {!! Form::input('date','details[operation_date]',old('operation_date'),['class'=>'form-control']) !!}
                <span class="error-display"><i style='color: red;'>  {!! $errors->first('details.operation_date') !!}</i></span>
            </div>
            <div class="col-md-4">
                {!! Form::label('registerToShare', 'Register to Share') !!}
                {!! Form::select('details[issueManager][id]',["0"=>"Self"]+$issueManagers->toArray(),null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('issue_status', 'Issue Status',['class'=>'required']) !!}
                {!! Form::select('issue_status',['1'=>'Yes', '0'=>'No'],old('issue_status'),['class'=>'form-control']) !!}
                <span class="text-danger"><i>{{$errors->first('issue_status')}}</i></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label('profile', 'Profile') !!}
                {!! Form::textarea('details[profile]',null,['class'=>'editor']) !!}
            </div>
        </div>