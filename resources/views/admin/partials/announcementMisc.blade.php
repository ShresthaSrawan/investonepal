<div class="form-group">
    {!! Form::label('type_id', 'Type',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::select('type_id',$types,old('type_id'),['class'=>'form-control']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('type_id')}}</i></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('subtype_id', 'Subtype',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        <?php
            $sid = isset($subtype) ? $subtype : old('subtype_id');
            $sid = array_key_exists('subtype_id',old()) ? old('subtype_id') : $sid;
        ?>
        {!! Form::select('subtype_id',[],old('subtype_id'),['class'=>'form-control','data-old'=>$sid]) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('subtype_id')}}</i></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('title', 'Title',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::input('text','title',old('title'),['class'=>'form-control','required'=>'required']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('title')}}</i></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('description', 'Description',['class'=>'col-lg-2 control-label required']) !!}
    <div class="col-lg-10">
        {!! Form::textarea('description',old('description'),['class'=>'form-control','required'=>'required']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('description')}}</i></span>
    </div>
</div>