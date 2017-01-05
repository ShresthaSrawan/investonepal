@extends('admin.master')

@section('title')
Bullion Type
@endsection

@section('content')
@include('admin.partials.errors')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-th-list fa-fw"></i> Bullion Type :Add:
        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm btn-flat" 
                data-toggle="modal" data-target="#createBullionType">
                <i class="fa fa-plus"></i> Add
            </button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th class='col-sm-1'>S.No.</th>
                    <th class='col-sm-6'>Name</th>
                    <th class='col-sm-3'>Unit</th>
                    <th class='col-sm-2'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter =1; ?>
                @foreach($bullionTypes as $bullionType)
                <tr class="edit-row">
                    <td>{{$counter}}</td>
                    <td>{{$bullionType->name}}</td>
                    <td>{{$bullionType->unit}}</td>
                    <td>
                        {!! Form::open(['route'=>['admin.bullionType.destroy',$bullionType->id],'method'=>'delete']) !!}
                            <a href="#" class="btn btn-primary btn-xs editbtn" data-toggle="modal" data-target="#editBullionType"
                            data-name="{{$bullionType->name}}" data-unit="{{$bullionType->unit}}"
                            data-url="{{route('admin.bullionType.update',$bullionType->id)}}">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger btn-xs delbtn" 
                            data-toggle="modal" data-target="#deleteBullionType">
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
<div class="modal fade" id="createBullionType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'admin.bullionType.store']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add Bullion Type</h4>
            </div>
            <div class="modal-body">
                {!! Form::label('name', 'Bullion Type',['class'=>'required']) !!}
                    {!! Form::text('name',null,['class'=>'form-control','required'=>'required']) !!}
                {!! Form::label('unit', 'Unit',['class'=>'required']) !!}
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
<!-- /Modal-->

<!-- Update Modal-->
<div class="modal fade" id="editBullionType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'put','id'=>'bullionType_edit']) !!}
            <div class="modal-header">
                <h4>Edit Bullion Type</h4>
            </div>
            <div class="modal-body">
                {!! Form::label('name', 'Bullion Type',['class'=>'required']) !!}
                    {!! Form::text('name',null,['class'=>'form-control','id'=>'bullionType_name','required'=>'required']) !!}

                {!! Form::label('bullionType_unit', 'Unit',['class'=>'required']) !!}
                    {!! Form::text('unit',null,['class'=>'form-control','id'=>'bullionType_unit','required'=>'required']) !!}
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
<div class="modal fade" id="deleteBullionType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

        $('#bullionType_name').val(name);
        $('#bullionType_unit').val(unit);
        $('#bullionType_edit').attr('action',url);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteBullionType');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
