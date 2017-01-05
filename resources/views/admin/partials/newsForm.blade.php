<div class="row">
    <div class="col-md-6">
        {!! Form::label('newsCategory', 'News Category') !!}
        <?php
          if(!array_key_exists("newsCategory", old())){
              $selected = isset($news) ? $news->category->id : null;
          }else{
            $selected = old('newsCategory');
          }
        ?>
        {!! Form::select('newsCategory',$newsCategory,$selected,['class'=>'form-control']) !!}
        <span class="text-danger"><i>{{$errors->first('newsCategory')}}</i></span>
    </div>
    <div class="col-md-6" id="options">
        <span id="companyList">
            {!! Form::label('company', 'Company') !!}
            {!! Form::select('company_id',([0=>'None']+$company),old('company_id'),['class'=>'form-control']) !!}
            <span class="text-danger"><i>{{$errors->first('company_id')}}</i></span>
        </span>
        <span id="bullionList">
            {!! Form::label('bullion_id', 'Bullion') !!}
            {!! Form::select('bullion_id',$bullion,old('bullion_id'),['class'=>'form-control']) !!}
            <span class="text-danger"><i>{{$errors->first('bullion_id')}}</i></span>
        </span>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {!! Form::label('title', 'Title',['class'=>'required']) !!}
        {!! Form::text('title',old('title'),['class'=>'form-control', 'required'=>'']) !!}
        <span class="text-danger"><i>{{$errors->first('title')}}</i></span>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        {!! Form::label('details', 'Details',['class'=>'required']) !!}
        {!! Form::textarea('details',old('details'),['class'=>'editor','required'=>'required']) !!}
        <span class="text-danger"><i>{{$errors->first('details')}}</i></span>
    </div>
</div>
<div class="row">
    <div class="col-md-1">
        {!! Form::label('event', 'Event',['class'=>'control-label col-md-12']) !!}
        <div class="col-md-12">
            {!! Form::checkbox('event',old('event'),false,['class'=>'form-control hide','id'=>'event']) !!}
        </div>
    </div>
    <div class="col-md-5">
        {!! Form::label('event_date', 'Event Date') !!}
        <div class='input-group date datetimepicker'>
            <input type='text' class="form-control eventdate" value="{{old('event_date')}}" name="event_date" id="event_date"/>
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        <span class="text-danger"><i>{{$errors->first('event_date')}}</i></span>
    </div>
    @if(isset($edit))
        <div class="col-md-6">
        	{!! Form::label('location', 'Location') !!}
            {!! Form::text('location',old('location'),['class'=>'form-control','placeholder' => 'Kathmandu']) !!}
        </div>
    @else
        <div class="col-md-6">
            {!! Form::label('location', 'Location') !!}
            <?php
                $location = (old('location') == NULL) ? "Kathmandu" : old('location');
            ?>
            {!! Form::text('location',$location,['class'=>'form-control','placeholder' => 'Kathmandu']) !!}
        </div>
    @endif
    
</div>
<div class="row">
   <div class="col-md-6">
        {!! Form::label('source', 'Source') !!}
        {!! Form::text('source',old('source'),['class'=>'form-control','placeholder' => 'Newspaper']) !!}
    </div>
    <div class="col-md-6">
    	{!! Form::label('user_id', 'Author') !!}
        {!! Form::select('user_id',$user,old('user_id'),['class'=>'form-control']) !!}
        <span class="text-danger"><i>{{$errors->first('user_id')}}</i></span>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        {!! Form::label('featured_image', 'Featured Image',['class'=>'required']) !!}
        {!! Form::input('file','featured_image[]',null,['class'=>'form-control file','multiple'=>true, 'required'=>'required']) !!}
        <span class="text-danger"><i>{{$errors->first('featured_image')}}</i></span>
    </div>
    @if(isset($edit))
        <div class="col-md-6">
            {!! Form::label('pub_date', 'Publish Date',['class'=>'required']) !!}
            <?php
                $pubDate = (array_key_exists('pub_date',old())) ? old('pub_date') : date_create($news->pub_date)->format("Y-m-d\TH:i:s");
            ?>
            <div class='input-group date datetimepicker'>
                <input type='text' class="form-control" value="{{$pubDate}}" name="pub_date" required/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <span class="text-danger"><i>{{$errors->first('pub_date')}}</i></span>
        </div>
    @else
        <div class="col-md-6">
            {!! Form::label('pub_date', 'Publish Date',['class'=>'required']) !!}
            <?php
                $date = (old('pub_date') == NULL) ? date("Y-m-d\TH:i:s") : old('pub_date');
            ?>
            <div class='input-group date datetimepicker'>
                <input type='text' class="form-control" value="{{$date}}" name="pub_date" required/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <span class="text-danger"><i>{{$errors->first('pub_date')}}</i></span>
        </div>
    @endif
</div>
<div class="row">
	<div class="col-md-12">
        {!! Form::label('tags[]', 'Tags',['class'=>'required']) !!}
        {!! Form::select('tags[]',$tags,isset($checked)?$checked:old('tags'),['class'=>'form-control' ,'id'=>'tags','multiple','required']) !!}
    </div>
</div>
