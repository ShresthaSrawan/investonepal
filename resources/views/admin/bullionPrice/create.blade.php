@extends('admin.master')

@section('specificheader')
<style type="text/css">
    table.table tr td{
        vertical-align: middle;
    }
</style>
@endsection

@section('title')
Bullion Price
@endsection

@section('content')
{!! Form::open(['route'=>'admin.bullionPrice.store']) !!}
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-diamond fa-fw"></i> Bullion Price :Add:</h3>
        {!! Form::reset('Reset',['class'=>'btn btn-primary pull-right']) !!}
    </div>
    <div class="box-body">
        @include('admin.partials.validation')
        <table class="table table-condensed" id="main-table">
            <thead>
                <tr>
                    <th>Bullion Type</th>
                    @foreach($previousBullion as $date => $v)
                        <th class="hidden-xs hidden-sm">{{$date}}</th>
                    @endforeach
                    <th>New Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bullionType as $id=>$name)
                    <tr>
                        <th class="bullion-name">{{$name}}</th>
                        @foreach($previousBullion as $values)
                            <td class="hidden-xs hidden-sm">{{array_key_exists($name,$values) ? $values[$name] : 'NA'}}</td>
                        @endforeach
                        <td>
                            {!! Form::input('number','price['.$id.']',null,['step'=>'any','class'=>'form-control','placeholder'=>'Price','required'=>'required']) !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <div class="row">
            <div class="col-xs-6">
            </div>
            <div class="col-xs-6">
                <div class="form-group">
					<span class="md-date-label">Insert Date</span>
                    <?php $date = (is_null(old('date'))) ? date('Y-m-d') : old('date'); ?>
                    <div class="input-group pull-right md-date-input">
                        {!! Form::input('date','date',$date,['class'=>'form-control']) !!}
                        <div class="input-group-btn">
                            {!! Form::submit('Create',['class'=>'btn btn-primary']) !!}
                        </div>
                    </div>
                    <span class="text-danger"><i>{{$errors->first('date')}}</i></span>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection
@section('endscript')
@endsection