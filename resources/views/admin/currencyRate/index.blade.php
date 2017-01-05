@extends('admin.master')

@section('title')
Currency Rate
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-history fa-fw"></i> Currency Rate :List:</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.currencyRate.create')}}">
                <i class="fa fa-plus"></i> Add Currency Rate
            </a>
        </div>
        <div class="alert alert-info" role="alert" style="margin-top:10px;">
            {!! Form::open(['route'=>'admin.currencyRate.upload','files'=>true]) !!}
                <div class="row">
                    <div class="col-lg-6" style="margin-top:6px;">
                        Currency rate should be in XLS format and headers should follow this example.</br>Eg: title[space](buy/sell)
                        <a href="{{url('/')}}/assets/sample_reports/currencyrate.xls">Sample.
                        </a>
                    </div>
                    <div class="col-lg-6" style="margin-bottom: -15px">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="file" name="file" class="form-control" required="">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary btn-flat" type="submit">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
            <tr>
                <th class="col-md-2">Date</th>
                <th class="col-md-10">Rate</th>
            </tr>
            </thead>
            <tbody>
                @if(!$currencyRates->isEmpty())
                        @foreach($currencyRates as $i=>$currency)
                            <tr>
                                <td>{{$currency->date}}</td>
                                <td>
                                    <div class="box box-solid collapsed-box no-margin">
                                        <div class="box-header">
                                            <h3 class="box-title">Currency Rate</h3>
                                            <div class="box-tools">
                                                <div class="no-margin pull-right">
                                                    <button class="btn btn-box-tool" data-widget="collapse" type="button"><i class="fa fa-plus"></i></button>
                                                    <a class="btn btn-box-tool btn-box-info" href="{{route('admin.currencyRate.edit',$currency->id)}}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body no-padding">
                                            <table class="table table-condensed no-padding no-border table-hover">
                                                <tbody>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Type</th>
                                                    <th>Buy</th>
                                                    <th>Sell</th>
                                                </tr>
                                                @foreach($currency->currencyRate as $key=>$rate)
                                                    <tr>
                                                        <td>{{++$key}}</td>
                                                        <td>{{$rate->type->name}}</td>
                                                        <td>{{is_null($rate->buy) ? 'NA' : $rate->buy}}</td>
                                                        <td>{{is_null($rate->sell) ? 'NA' : $rate->sell}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="box-footer no-padding">
                                            {!!  Form::open(['route'=>['admin.currencyRate.destroy',$currency->id],'method'=>'delete','class'=>'form-inline pull-right']) !!}
                                            <button type="button" class="btn btn-danger btn-xs delbtn" data-toggle="modal" 
                                            data-target="#deleteCurrencyRate">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.currencyRate.create')}}">
            <i class="fa fa-plus"></i> Add Currency Rate
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteCurrencyRate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the selected item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger confirm-delete">
                    <i class="fa fa-trash"></i> Yes
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('endscript')

<script type="text/javascript">
    $(document).ready(function(){
        $('.datatable').DataTable({
            order : [[0,'desc']],
            'lengthMenu': [[7,14,21,28],[7,14,21,28]]
        });
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteCurrencyRate');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
