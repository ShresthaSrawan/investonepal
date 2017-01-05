@extends('admin.master')

@section('title')
Currency Type
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-th-list fa-fw"></i> Currency Type :Add:
        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm btn-flat" 
                data-toggle="modal" data-target="#createCurrencyType">
                <i class="fa fa-plus"></i> Add
            </button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th class='col-sm-1'>S.No.</th>
                    <th class='col-sm-6'>name</th>
                    <th class='col-sm-3'>Unit</th>
                    <th class='col-sm-2'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter =1; ?>
                @foreach($currencyTypes as $currencyType)
                <tr class="edit-row">
                    <td>{{$counter}}</td>
                    <td>{{$currencyType->name}}</td>
                    <td>{{$currencyType->unit}}</td>

                    <td>
                        {!! Form::open(['route'=>['admin.currencyType.destroy',$currencyType->id],'method'=>'delete']) !!}
                            <button type="button" class="btn btn-primary btn-xs editbtn" data-unit="{{$currencyType->unit}}"
                            data-name="{{($currencyType->name)}}" data-toggle="modal" data-target="#editCurrencyType"
                            data-url="{{route('admin.currencyType.update',$currencyType->id)}}">
                                <i class="glyphicon glyphicon-edit"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-xs delbtn" 
                            data-toggle="modal" data-target="#deleteCurrencyType">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                <?php $counter++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createCurrencyType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'admin.currencyType.store']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add Currency Type</h4>
            </div>
            <div class="modal-body">
                {!! Form::label('name', 'Currency Type',['class'=>'required']) !!}
                {!! Form::text('name',null,['class'=>'form-control','required'=>'required']) !!}

                {!! Form::label('unit', 'Currency Unit',['class'=>'required']) !!}
                {!! Form::text('unit',null,['class'=>'form-control','required'=>'required']) !!}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {!! Form::submit('Create',['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Update Modal-->
<div class="modal fade" id="editCurrencyType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'put','id'=>'currencyType_edit']) !!}
            <div class="modal-header">
                <h4>Edit Currency Type</h4>
            </div>
            <div class="modal-body">
                {!! Form::label('name', 'Currency Type',['class'=>'required']) !!}
                {!! Form::text('name',null,['class'=>'form-control','id'=>'currencyType_name']) !!}

                {!! Form::label('unit', 'Currency Unit',['class'=>'required']) !!}
                {!! Form::text('unit',null,['class'=>'form-control','id'=>'currencyType_unit']) !!}

            </div>
            <div class="modal-footer">
                {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteCurrencyType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
        $('.datatable').DataTable();
    });

    $(document).on('click','.editbtn',function(){
        var name = $(this).data('name');
        var unit = $(this).data('unit');
        var url = $(this).data('url');

        $('#currencyType_name').attr('value',name);
        $('#currencyType_unit').attr('value',unit);
        $('#currencyType_edit').attr('action',url);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteCurrencyType');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
