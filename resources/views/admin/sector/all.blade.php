@extends('admin.master')

@section('title')
Sector
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-th-list fa-fw"></i> Sector :List:
        </h3>
        {!! Form::open(['route'=>'admin.sector.store']) !!}
            <div class="input-group clearfix box-header-create">
                {!! Form::text('label',null,['class'=>'form-control','placeholder'=>'Eg. Finance','required'=>'required']) !!}
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-plus"></i> Add
                    </button>
                </span>
            </div>
        {!! Form::close() !!}
    </div><!-- /.box-header -->

    <div class="box-body">
        @include('admin.partials.validation')
        <table class="table datatable">
            <thead>
                <tr>
                    <th class='col-sm-1'>S.No.</th>
                    <th class='col-sm-9'>Sector</th>
                    <th class='col-sm-2'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter =1; ?>
                @foreach($sectors as $sector)
                <tr class="edit-row">
                    <td>{{$counter}}</td>
                    <td>{{$sector->label}}</td>
                    <td>
                    {!! Form::open(['route'=>['admin.sector.destroy',$sector->id],'method'=>'delete']) !!}
                        <button type="button" class="btn btn-primary btn-xs editbtn" 
                        data-toggle="modal" data-target="#editSector" data-label="{{$sector->label}}"
                        data-url="{{route('admin.sector.update',$sector->id)}}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-xs delbtn" data-toggle="modal" 
                            data-target="#deleteSector">
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteSector" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
<div class="modal fade" id="editSector" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'put','id'=>'sector_edit']) !!}
            <div class="modal-header">
            <h4>Edit Sector</h4>
            </div>
            <div class="modal-body">
                {!! Form::label('label', 'Sector',['class'=>'required']) !!}
                    {!! Form::text('label',null,['class'=>'form-control','id'=>'sector_label','required'=>'required']) !!}
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
        $('#sector_label').attr('value',label);
        $('#sector_edit').attr('action',url);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteSector');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection