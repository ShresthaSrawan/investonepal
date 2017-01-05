@extends('admin.master')

@section('title')
Index Types
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user fa-fw"></i> Index Type :List:</h3>
        {!! Form::open(['route' => 'admin.indexType.store']) !!}
            <div class="box-header-create input-group">
                {!! Form::text('label',old('label'),['class'=>'form-control','placeholder'=>'Index Type','required'=>'required']) !!}
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-plus"></i> Add
                    </button>
                </span>
            </div>
        {!! Form::close() !!}
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th class='col-sm-1'>S.No.</th>
                    <th class='col-sm-9'>Label</th>
                    <th class='col-sm-2'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter =1; ?>
                @foreach($indexTypes as $indexType)
                <tr class="edit-row">
                    <td>{{$counter}}</td>
                    <td>{{$indexType->name}}</td>
                    <td>
                        {!! Form::open(['route'=>['admin.indexType.destroy',$indexType->id],'method'=>'delete']) !!}
                            <button type="button" class="btn btn-primary btn-xs editbtn" data-toggle="modal"
                                data-target="#editindexType" data-label="{{$indexType->name}}"
                                data-url="{{route('admin.indexType.update', $indexType->id)}}">
                                <i class="glyphicon glyphicon-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-xs delbtn" data-toggle="modal" 
                                data-target="#deleteIndexType">
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

<!-- Delete Modal-->
<div class="modal fade" id="deleteIndexType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

<!-- Update Modal-->
<div class="modal fade" id="editindexType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'put','id'=>'indexType_edit']) !!}
            <div class="modal-header">
                <h4>Edit Index Type</h4>
            </div>
            <div class="modal-body">
                {!! Form::text('name',old('name'),['class'=>'form-control','id'=>'indexType_label','required'=>'required']) !!}
            </div>
            <div class="modal-footer">
                {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
@section('endscript')
<script type="text/javascript">    
    $(document).on('click','.editbtn',function(){
        label = $(this).data('label');
        url = $(this).data('url');
        $('#indexType_label').attr('value',label);
        $('#indexType_edit').attr('action',url);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteIndexType');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
