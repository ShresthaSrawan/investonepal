@extends('admin.master')

@section('title')
Bullion Price
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-history fa-fw"></i> Bullion Price :List:</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.bullionPrice.create')}}">
                <i class="fa fa-plus"></i> Add Bullion Price
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
            <tr>
                <th class='col-sm-2'>Date</th>
                <th class='col-sm-3'>Price</th>
                <th class='col-sm-2'>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bullionPrices as $bullion)
            <tr>
                <td>{{$bullion->date}}</td>
                <td>
                    <table class="table table-bordered table-nested">
                        <thead>
                            <th>Type</th>
                            <th style="width: 100px;">Price</th>
                        </thead>
                        <tbody>
                            @foreach($bullion->bullionPrice as $price)
                                <tr>
                                    <td>{{$price->type->name}}</th>
                                    <td>{{$price->price}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td>
                    {!! Form::open(['route'=>['admin.bullionPrice.destroy',$bullion->id],'method'=>'delete']) !!}
                        <a href="{{route('admin.bullionPrice.edit',$bullion->id)}}" class="btn btn-primary btn-xs editbtn">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-xs delbtn" 
                            data-toggle="modal" data-target="#deleteBullionPrice">
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
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.bullionPrice.create')}}">
            <i class="fa fa-plus"></i> Add Bullion Price
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteBullionPrice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteBullionPrice');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
