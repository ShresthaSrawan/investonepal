@extends('admin.master')

@section('title')
Month
@endsection

@section('content')
@include('admin.partials.errors')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-calendar-o fa-fw"></i> <strong>{{ucwords($quarter->label)}}</strong>: Months :List:</h3>
        {!! Form::open(array('route' => ['admin.quarter.month.store',$quarter->id]))!!}
            <div class="input-group clearfix">
                {!! Form::text('label',old('label'),['class'=>'form-control','placeholder'=>'Month Label','required'=>'required']) !!}
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
                    <th class='col-sm-1'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 0; ?>
                @foreach($quarter->month as $month)
                <tr>
                    <td>{{++$counter}}</td>
                    <td>{{$month->label}}</td>
                    <td>
                        {!! Form::open(['route'=>['admin.quarter.month.destroy','qid'=>$month->quarter->id,'mid'=>$month->id],'method'=>'delete']) !!}
                            <button type="button" class="btn btn-xs btn-primary editbtn" data-toggle="modal" 
                            data-target="#editMonthModal" data-label="{{$month->label}}"
                            data-url="{{route('admin.quarter.month.update',['quarter'=>$month->quarter->id, 'month'=>$month->id])}}">
                                <i class="fa fa-pencil-square-o"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-xs delbtn" data-toggle="modal" 
                                data-target="#deleteMonth">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Update-Modal -->
<div class="modal fade" id="editMonthModal" tabindex="-1" role="dialog" aria-labelledby="EditMonthModal">
    <div class="modal-dialog">
        <div class="modal-content">
        {!! Form::open(['method'=>'put','id'=>'month_update']) !!}
            <div class="modal-header">
                <h4 class="modal-title">Edit Month</h4>
            </div>
            <div class="modal-body">
                <input type="text" name="label" id="month_label" class="form-control" required="required">
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
<div class="modal fade" id="deleteMonth" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                    <i class="glyphicon glyphicon-trash"></i> Yes
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('endscript')
<script>
    $('.editbtn').on('click',function(){
        url = $(this).data('url');
        label = $(this).data('label');
        $('#month_label').val(label);
        $('#month_update').attr('action',url);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteMonth');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection