@extends('admin.master')

@section('title')
Energy Price
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-history fa-fw"></i> Energy Price :List:</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.energyPrice.create')}}">
                <i class="fa fa-plus"></i> Add Energy Price
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
            <tr>
                <th>Date</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($energyPrices as $energy)
            <tr>
                <td>{{$energy->date}}</td>
                <td>
                    <table class="table table-nested">
                        <thead>
                        <tr>
                            <th style="width: 10px;">#</th>
                            <th>Type</th>
                            <th style="width: 50px;">Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($energy->energyPrice as $key=>$price)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$price->type->name}}</td>
                                <td>{{$price->price}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
                <td>
                    {!! Form::open(['route'=>['admin.energyPrice.destroy',$energy->id],'method'=>'delete']) !!}
                        <a href="{{route('admin.energyPrice.edit',$energy->id)}}" class="btn btn-primary btn-xs editbtn">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-xs delbtn" data-toggle="modal" data-target="#deleteEnergyPrice">
                            <i class="fa fa-trash"></i>
                        </button>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.energyPrice.create')}}">
            <i class="fa fa-plus"></i> Add Energy Price
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteEnergyPrice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
            order : [[0,'desc']]
        });
    });
    
    $(document).on('click','.editbtn',function(){
        var type = $(this).data('type');
        var price = $(this).data('price');
        var date = $(this).data('date');
        var url = $(this).data('url');

        $('#energy_type').val(type);
        $('#energy_price').val(price);
        $('#energy_date').val(date);
        $('#energyPrice_edit').attr('action',url);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteEnergyPrice');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
