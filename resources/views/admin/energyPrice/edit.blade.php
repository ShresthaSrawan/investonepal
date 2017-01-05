@extends('admin.master')

@section('specificheader')
<style type="text/css">
    table.table tr td{
        vertical-align: middle;
    }
</style>
@endsection

@section('title')
Energy Price
@endsection

@section('content')
{!! Form::open(['route'=>['admin.energyPrice.update',$id],'method'=>'put']) !!}
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-diamond fa-fw"></i> Energy Price :Edit:</h3>
        <div class="box-tools pull-right">
            {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
        </div>
    </div>
    <div class="box-body">
        @include('admin.partials.validation')
        <table class="table table-condensed" id="main-table">
            <thead>
                <tr>
                    <th>Energy Type</th>
                    @foreach($previousEnergy as $date => $v)
                        <th class="hidden-xs hidden-sm">{{$date}}</th>
                    @endforeach
                    <th>New Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($energyType as $id=>$name)
                    <tr>
                        <th class="energy-name">{{$name}}</th>
                        @foreach($previousEnergy as $values)
                            <td class="hidden-xs hidden-sm">{{array_key_exists($name,$values) ? $values[$name] : 'NA'}}</td>
                        @endforeach
                        <td>
                            {!! Form::input('number','price['.$id.']',$current[$name],['step'=>'any','class'=>'form-control','placeholder'=>'Price','required'=>true]) !!}
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
@section('endscript')
@endsection