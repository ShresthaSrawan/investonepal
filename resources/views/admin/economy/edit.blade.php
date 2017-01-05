@extends('admin.master')

@section('title')
Economy
@endsection

@section('specificheader')
{!! HTML::style('vendors/chosen/chosen.css') !!}
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> Economy <small>:Edit</small></h3>
        <div class="box-tools pull-right">
            <a class="btn btn-info btn-flat btn-xs" href="{{route('admin.economy.index')}}"><i class="fa fa-eye"></i> View</a>
        </div>
    </div>
    {!! Form::model($economy,['route'=>['admin.economy.update',$economy->id],'class'=>'form-horizontal','method'=>'put']) !!}
    <div class="box-body">
        @include('admin.partials.validation')
        <div class="form-group">
            <div class="col-lg-12">
                {!! Form::label('fiscal_year_id', 'Fiscal Year',['class'=>'control-label required']) !!}
                {!! Form::select('fiscal_year_id',$fiscalYears,old('fiscal_year_id'),['class'=>'form-control ']) !!}
            </div>
        </div>
        <div id="template" class="hide">
            <div class="form-group group{increment}">
                <div class="col-lg-4">
                    <label class="control-label required">Economy Label</label>
                    {!! Form::select('label[{increment}]',([''=>'']+$economyLabels),null,['class'=>'form-control select{increment}']) !!}
                </div>
                <div class="col-lg-4">
                    <label class="control-label required">Value</label>
                    {!! Form::input('number','value[{increment}]',null,['class'=>'form-control','step'=>'any']) !!}
                </div>
                <div class="col-lg-4">
                    <label class="control-label required">Date</label>
                    <div class="input-group">
                        {!! Form::input('date','date[{increment}]',null,['class'=>'form-control']) !!}
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger removeRow"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dynamic">
            @if(empty(old()))
                @foreach($economy->values as $key=>$value)
                    <div class="form-group group{{$key}}">
                        <div class="col-lg-4">
                            <label class="control-label required">Economy Label</label>
                            {!! Form::select('label['.$key.']',([''=>'']+$economyLabels),$value->label_id,['class'=>'form-control select{increment}']) !!}
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label required">Value</label>
                            {!! Form::input('number','value['.$key.']',$value->value,['class'=>'form-control','step'=>'any']) !!}
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label required">Date</label>
                            <div class="input-group">
                                {!! Form::input('date','date['.$key.']',$value->date,['class'=>'form-control']) !!}
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger removeRow"><i class="fa fa-remove"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @elseif(!empty(old()))
                <?php
                    $count = count(old('label'));
                    $count = ($count > count(old('value'))) ? $count : count(old('value'));
                    $count = ($count > count(old('date'))) ? $count : count(old('date'));
                ?>

                @for($id = 0; $id < $count; $id++)
                    <div class="form-group group{{$id}}">
                        <div class="col-lg-4">
                            <label class="control-label required">Economy Label</label>
                            {!! Form::select('label['.$id.']',([''=>'']+$economyLabels),old('label['.$id.']'),['class'=>'form-control select{increment}']) !!}
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label required">Value</label>
                            {!! Form::input('number','value['.$id.']',old('value['.$id.']'),['class'=>'form-control','step'=>'any']) !!}
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label required">Date</label>
                            <div class="input-group">
                                {!! Form::input('date','date['.$id.']',old('date['.$id.']'),['class'=>'form-control']) !!}
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger removeRow"><i class="fa fa-remove"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            @endif
        </div>

        <div class="form-group">
            <div class="col-lg-12">
                <button type="button" id="addEconomyLabel" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> More</button>
            </div>
        </div>
    </div>
    <div class="box-footer clearfix no-border">
        <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-edit"></i> Update</button>
    </div>
    {!! Form::close() !!}
</div>
@endsection

@section('endscript')
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
<script type="text/javascript">
    var increment = 0;
    var $template = $('#template').remove();
    var availableEntries = countAvailableEntry();
    $(document).ready(function(){
        $(document).on('click','#addEconomyLabel',function(){
            console.log(increment,availableEntries);
            if(increment > availableEntries) return;
            var local = getTemplate();
            $('.dynamic').append(local.html);
            applyChosen(local.select);
        });

        $(document).on('click','.removeRow',function(){
            $formGroup = $(this).closest('.form-group');
            console.log($(this).closest('select[name*=label]'));
            $formGroup.remove();
        });

        applyChosen();
    });

    function countAvailableEntry(){
        increment =
                this.dCount = $('.dynamic').find('.form-group').length;
        this.tCount = $template.find('select[name*=label]').children('option').length;
        this.finalCount = this.tCount - this.dCount;
        return this.finalCount;
    }

    function getTemplate(){
        var raw = $template.html();
        var regex = new RegExp('{'+'increment'+'}', "igm");

        var tmplt =  {
            select:'.select'+increment,
            html:raw.replace(regex,increment)
        };
        increment++;
        return tmplt;
    }

    function applyChosen(select){
        $('select[name *= label]').chosen();
    }
</script>
@endsection