@extends('admin.master')

@section('specificheader')
<style type="text/css">
    table.table tr td{
        vertical-align: middle;
    }
</style>
@endsection

@section('title')
Market Index
@endsection

@section('content')
@include('admin.partials.validation')
{!! Form::open(['route'=>['admin.marketIndex.update',$id],'method'=>'put']) !!}
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-thumb-tack fa-fw"></i> Market Index :Edit:</h3>
        {!! Form::submit('Update',['class'=>'btn btn-primary pull-right']) !!}
    </div>
    <div class="box-body">
        @include('admin.partials.validation')
        <table class="table table-condensed" id="main-table">
            <thead>
                <tr>
                    <th>Index Type</th>
                    @foreach($previousIndex as $date => $v)
                        <th class="hidden-xs hidden-sm">{{$date}}</th>
                    @endforeach
                    <th>New Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($indexType as $id=>$name)
                    <tr>
                        <th class="index-name">{{$name}}</th>
                        @foreach($previousIndex as $values)
                            <td class="hidden-xs hidden-sm">{{array_key_exists($name,$values) ? $values[$name] : 'NA'}}</td>
                        @endforeach
                        <td>
                            {!! Form::input('number','value['.$id.']',$current[$name],['step'=>'any','class'=>'form-control','placeholder'=>'Value','required'=>true]) !!}
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