{!! Form::hidden('type',$type)!!}
<div class="row">
    <div class="col-md-6">
            {!! Form::label('newsCategory', 'Category',['class'=>'required']) !!}
            {!! Form::select('newsCategory',$newsCategory,$selected,['class'=>'form-control','required'=>true]) !!}
            <span class="text-danger"><i>{{$errors->first('newsCategory')}}</i></span>
    </div>
    <div class="col-md-6" id="options">
        <span id="companyList">
            {!! Form::label('company_id', 'Company') !!}
            {!! Form::select('company_id',([0=>'None']+$company),old('company_id'),['class'=>'form-control']) !!}
        </span>
        <span id="bullionList">
            {!! Form::label('bullion_type_id', 'Bullion') !!}
            {!! Form::select('bullion_type_id',$bullion,old('bullion_type_id'),['class'=>'form-control']) !!}
        </span>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {!! Form::label('title', 'Title',['class'=>'required']) !!}
        {!! Form::text('title',old('title'),['class'=>'form-control','required'=>true]) !!}
        <span class="text-danger"><i>{{$errors->first('title')}}</i></span>
    </div>
</div>

<div class="row">
	@if(isset($edit))
        <div class="col-md-6">
            {!! Form::label('pub_date', 'Publish Date',['class'=>'required']) !!}
            <div class='input-group date datetimepicker'>
	            <input type='text' class="form-control pub_date" value="{{isset($interview) ? $interview->pub_date : $article->pub_date}}" name="pub_date" id="pub_date" required/>
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
	            <input type='text' class="form-control pub_date" value="{{$date}}" name="pub_date" id="pub_date" required/>
	            <span class="input-group-addon">
	                <span class="glyphicon glyphicon-calendar"></span>
	            </span>
	        </div>
            <span class="text-danger"><i>{{$errors->first('pub_date')}}</i></span>
        </div>
    @endif
	<div class="col-md-6">
	    {!! Form::label('location', 'Location') !!}
	    {!! Form::text('location',old('location'),['class'=>'form-control']) !!}
	</div>
</div></br>

@if($type==0)
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>			
				<i class="fa fa-microphone fa-fw"></i> Interviewé Details
			</h4>
		</div>
		<div class="panel-body">
		    <div class="row">
			    <div class="col-md-6">
			        {!! Form::label('interviewe_name', 'Name',['class'=>'required']) !!}
			        {!! Form::text('intervieweDetail[name]',old('interviewe_name'),['class'=>'form-control','required'=>true]) !!}
			        <span class="text-danger"><i>{{$errors->first('intervieweDetail.name')}}</i></span>
			    </div>
			    <div class="col-md-6">
			        {!! Form::label('interviewe_organization', 'Organization',['class'=>'required']) !!}
			        {!! Form::text('intervieweDetail[organization]',old('interviewe_organization'),['class'=>'form-control','required'=>true]) !!}
			        <span class="text-danger"><i>{{$errors->first('intervieweDetail.organization')}}</i></span>
			    </div>
			</div>
			<div class="row">
			    <div class="col-md-6">
			        {!! Form::label('interviewe_address', 'Address',['class'=>'required']) !!}
			        {!! Form::text('intervieweDetail[address]',old('interviewe_address'),['class'=>'form-control','required'=>true]) !!}
			        <span class="text-danger"><i>{{$errors->first('intervieweDetail.address')}}</i></span>
			    </div>
			    <div class="col-md-6">
			         {!! Form::label('interviewe_contact', 'Contact',['class'=>'required']) !!}
			         {!! Form::text('intervieweDetail[contact]',old('interviewe_contact'),['class'=>'form-control','required'=>true]) !!}
			         <span class="text-danger"><i>{{$errors->first('intervieweDetail.contact')}}</i></span>
			     </div>		     
			</div>
			<div class="row">
				<div class="col-md-6">
			       {!! Form::label('interviewe_position', 'Position') !!}
			       {!! Form::text('intervieweDetail[position]',old('position'),['class'=>'form-control']) !!}
			   	</div>
			   	<div class="col-md-6">
					{!! Form::label('interviewe_photo', 'Photo') !!}
					{!! Form::input('file','interviewe_photo',old('interviewe_photo'),['class'=>'form-control file']) !!}
					<span class="text-danger"><i>{{$errors->first('interviewe_photo')}}</i></span>
				</div>
			</div>
		</div>
	</div>
@endif

<div class="row">
    <div class="col-sm-12">
        {!! Form::label('details', 'Details',['class'=>'required']) !!}
        {!! Form::textarea('details',old('details'),['class'=>'editor','required'=>true]) !!}
        <span class="text-danger"><i>{{$errors->first('details')}}</i></span>
    </div>
</div></br>

<div class="panel panel-default">
  <div class="panel-heading">  
  	<h4>			
		@if($type==0)
			<i class="fa fa-microphone fa-fw"></i> Interviewer Details
		@else
			<i class="fa fa-file-text fa-fw"></i> Writer Details		
		@endif
	</h4>    
  </div>
  <div class="panel-body">
    <div id="choice">
	    <span id="externalDetail">
	    	<div class="row">
	    		<div class="col-md-6">
	    			{!! Form::label('name', 'Name',['class'=>'required']) !!}
			        {!! Form::text('externalDetail[name]',old('name'),['class'=>'form-control','required'=>true]) !!}
			        <span class="text-danger"><i>{{$errors->first('externalDetail.name')}}</i></span>
	    		</div>
	    		<div class="col-md-6">
	    			{!! Form::label('organization', 'Organization',['class'=>'required']) !!}
			        {!! Form::text('externalDetail[organization]',old('organization'),['class'=>'form-control','required'=>true]) !!}
			        <span class="text-danger"><i>{{$errors->first('externalDetail.organization')}}</i></span>
	    		</div>
	    	</div>
	    	<div class="row">
				<div class="col-md-6">
					{!! Form::label('contact', 'Contact',['class'=>'required']) !!}
			        {!! Form::text('externalDetail[contact]',old('contact'),['class'=>'form-control','required'=>true]) !!}
			        <span class="text-danger"><i>{{$errors->first('externalDetail.contact')}}</i></span>
				</div>
				<div class="col-md-6">
					{!! Form::label('address', 'Address',['class'=>'required']) !!}
			        {!! Form::text('externalDetail[address]',old('address'),['class'=>'form-control','required'=>true]) !!}
			        <span class="text-danger"><i>{{$errors->first('externalDetail.address')}}</i></span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					{!! Form::label('position', 'Position') !!}
			        {!! Form::text('externalDetail[position]',old('position'),['class'=>'form-control']) !!}
				</div>
				<div class="col-md-6">
					{!! Form::label('photo', 'Photo') !!}
					{!! Form::input('file','photo',old('photo'),['class'=>'form-control file']) !!}
					<span class="text-danger"><i>{{$errors->first('photo')}}</i></span>
				</div>
			</div>    
	    </span>
	    <span id="internalDetail">
	        {!! Form::label('user_id', 'Writer',['class'=>'required']) !!}
	        {!! Form::select('user_id',$user,old('user_id'),['class'=>'form-control','required'=>true]) !!}
	        <span class="text-danger"><i>{{$errors->first('user_id')}}</i></span>
	    </span>
	</div>
  </div>
</div>

<div class="row">
	<div class="col-md-12">
        {!! Form::label('tags', 'Tags') !!}
        {!! Form::text('tags',old('tags'),['class'=>'form-control']) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {!! Form::label('featured_image', 'Featured Image') !!}
        {!! Form::input('file','featured_image[]',null,['class'=>'form-control file','multiple'=>true]) !!}
        <span class="text-danger"><i>{{$errors->first('featured_image')}}</i></span>
    </div>
</div>
