@extends('admin.master')

@section('title')
Quarters
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-pie-chart fa-fw"></i> Quarter :List:</h3>
        {!! Form::open(array('route' => 'admin.quarter.store'))!!}
            <div class="input-group clearfix">
                {!! Form::text('label',old('label'),['class'=>'form-control','placeholder'=>'Quarter label','required'=>'required']) !!}
                <span class="error-display"><i style='color: red;'>  {!! $errors->first('label') !!}</i></span>
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-plus"></i> Add
                    </button>
                </span>
            </div>
        {!! Form::close() !!}
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th class='col-sm-1'>Sn</th>
                    <th class='col-sm-9'>Label</th>
                    <th class='col-sm-1'>Edit</th>
                    <th class='col-sm-1'>Month</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quarters as $quarter)
                <tr>
                    <td>{{$quarter->id}}</td>
                    <td>{{$quarter->label}}</td>
                    <td>
                        {!! Form::open(['route'=>['admin.quarter.destroy',$quarter->id],'method'=>'delete']) !!}
                            <button type="button" class="btn btn-xs btn-primary edit-at" data-toggle="modal" 
                            data-target="#editQuarterModal" data-label="{{$quarter->label}}"
                            data-url="{{route('admin.quarter.update',$quarter->id)}}">
                                <i class="fa fa-pencil-square-o"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-xs delbtn" data-toggle="modal" 
                                data-target="#deleteQuarter">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        {!! Form::close() !!}
                    </td>
                    <td>
                        <a href="{{route('admin.quarter.month.index',$quarter->id)}}" class="btn btn-default btn-xs">
                            <i class="fa fa-plus-square"></i> Add
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Update-Modal -->
<div class="modal fade" id="editQuarterModal" tabindex="-1" role="dialog" aria-labelledby="EditQuarterModal">
    <div class="modal-dialog">
        <div class="modal-content">
        {!! Form::open(['method'=>'put','id'=>'quarter_edit']) !!}
            <div class="modal-header">
                <h4 class="modal-title">Edit Quarter</h4>
            </div>
            <div class="modal-body">
                <input type="text" name="label" id="quarter_label" class="form-control">
                <input type="hidden" value="{{csrf_token()}}" name="_token">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="form-submit">Update</button>
            </div>
        {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteQuarter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
<script>
    $('.edit-at').on('click',function(){
        label = $(this).data('label');
        url = $(this).data('url');

        $('#quarter_label').val(label);
        $('#quarter_edit').attr('action',url);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteQuarter');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection