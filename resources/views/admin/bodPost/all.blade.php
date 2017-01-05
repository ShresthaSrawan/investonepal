@extends('admin.master')

@section('title')
BOD Post
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-user-md fa-fw"></i> BOD Post :List:
        </h3>
        {!! Form::open(['route' => 'admin.bodPost.store']) !!}
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th colspan="2"><h3><i class="fa fa-plus-square"></i> BOD Post :Create:</h3></th>
                    </tr>
                    <tr>
                        <th style="width:60%;">Label</th>
                        <th style="width:30%;">Type</th>
                        <th style="width:10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {!! Form::text('label',old('label'),['class'=>'form-control','placeholder'=>'BOD Post','required'=>'required']) !!}
                        </td>
                        <td>
                            {!! Form::select('type',['1'=>'Bod', '0'=>'Management'],null, ['class'=>'form-control','required'=>'required']) !!}
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fa fa-plus-square"></i> Create
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        {!! Form::close() !!}
    </div>

    <div class="box-body">
        <table class="table datatable">
            <thead>
            <tr>
                <th class='col-sm-2'>S.No.</th>
                <th class='col-sm-4'>Label</th>
                <th class='col-sm-2'>Type</th>
                <th class='col-sm-1'> </th>
            </tr>
            </thead>
            <tbody>
            <?php $counter =1; ?>
            @foreach($bodPosts as $bodPost)
            <tr class="edit-row">
                <td>{{$counter}}</td>
                <td>{{$bodPost->label}}</td>
                @if($bodPost->type==1)
                    <?php $type = "Bod"; ?>
                @elseif($bodPost->type==0)
                    <?php $type = "Management"; ?>
                @endif
                <td>{{$type}}</td>
                <td>
                    {!! Form::open(['route'=>['admin.bodPost.destroy',$bodPost->id],'method'=>'delete']) !!}
                        <button type="button" class="btn btn-primary btn-xs editbtn" data-toggle="modal" data-target="#editBodPost"
                           data-label="{{$bodPost->label}}" data-type="{{$bodPost->type}}"
                           data-url="{{route('admin.bodPost.update',$bodPost->id)}}">
                            <i class="glyphicon glyphicon-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-xs delbtn" 
                            data-toggle="modal" data-target="#deleteBodPost">
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

<!-- Update Modal-->
<div class="modal fade" id="editBodPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'put','id'=>'bodPost_edit']) !!}
            <div class="modal-header">
                <h4>Edit BOD Post</h4>
            </div>
            <div class="modal-body">
                {!! Form::label('bodPost_label', 'BOD Post',['class'=>'required']) !!}
                {!! Form::text('label',null,['class'=>'form-control','id'=>'bod_post','required'=>'required']) !!}

                {!! Form::label('bod_type', 'BOD Type',['class'=>'required']) !!}
                {!! Form::select('type',['1'=>'Bod', '0'=>'Management'],null, ['class'=>'form-control','id'=>'bod_type','required'=>'required']) !!}

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
<div class="modal fade" id="deleteBodPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

    $(document).on('click','.editbtn',function(){
        var label = $(this).data('label');
        var type = $(this).data('type');
        var url = $(this).data('url');

        $('#bod_post').val(label);
        $('#bod_type').val(type);
        $('#bodPost_edit').attr('action',url);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteBodPost');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
