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
{!! Form::open(['route'=>['admin.currencyRate.update',$id],'method'=>'put']) !!}
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-diamond fa-fw"></i> Currency Rate :Edit:</h3>
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
        </div>
        <div class="box-body">
            @include('admin.partials.validation')
            <table class="table table-condensed" id="main-table">
                <thead>
                    <tr>
                        <th>Currency Type</th>
                        @foreach($previousCurrency as $date => $v)
                            <th class="hidden-xs hidden-sm">{{$date}}</th>
                        @endforeach
                        <th>Edit Buy</th>
                        <th>Edit Sell</th>
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
                                {!! Form::input('number','buy['.$id.']',$current[$name]['buy'],['step'=>'any','class'=>'form-control','placeholder'=>'Price','required'=>true]) !!}
                            </td>
                            <td>
                                {!! Form::input('number','sell['.$id.']',$current[$name]['sell'],['step'=>'any','class'=>'form-control','placeholder'=>'Price']) !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer clearfix">
            {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
        </div>
    </div>
{!! Form::close() !!}
@endsection