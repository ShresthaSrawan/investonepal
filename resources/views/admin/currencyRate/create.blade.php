@extends('admin.master')

@section('specificheader')
<style type="text/css">
    table.table tr td{
        vertical-align: middle;
    }
</style>
@endsection

@section('title')
Currency Rate
@endsection

@section('content')
{!! Form::open(['route'=>'admin.currencyRate.store']) !!}
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-btc fa-fw"></i> Currency Rate :Add:</h3>
            {!! Form::reset('Reset',['class'=>'btn btn-primary pull-right']) !!}
        </div>
        <div class="box-body">
            @include('admin.partials.validation')
            <table class="table table-condensed table-bordered" id="main-table">
                <thead>
                    <tr>
                        <th>Index Type</th>
                        @foreach($previousCurrency as $date => $v)
                            <th class="hidden-xs hidden-sm">{{$date}}</th>
                        @endforeach
                        <th>New Buy</th>
                        <th>New Sell</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($currencyType as $id=>$name)
                        <tr>
                            <th class="currency-name">{{$name}}</th>
                                @foreach($previousCurrency as $values)
                                    <td class="hidden-xs hidden-sm"><strong>Buy:</strong> {{array_key_exists($name,$values) ? $values[$name]['buy'] : 'NA'}}</br>
                                        <strong>Sell:</strong> {{array_key_exists($name,$values) && !is_null($values[$name]['sell'])? $values[$name]['sell'] : 'NA'}}</td>
                                @endforeach
                            <td>
                                {!! Form::input('number','buy['.$id.']',null,['step'=>'any','class'=>'form-control','placeholder'=>'Buy','required'=>'required']) !!}
                            </td>
                            <td>
                                {!! Form::input('number','sell['.$id.']',null,['step'=>'any','class'=>'form-control','placeholder'=>'Sell']) !!}
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
