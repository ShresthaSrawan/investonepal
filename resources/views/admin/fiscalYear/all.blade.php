@extends('admin.master')

@section('title')
Fiscal Year
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-calendar fa-fw"></i> Fiscal Year :List:
        </h3>
        {!! Form::open(['route' => 'admin.fiscalYear.store']) !!}
            <div class="input-group clearfix box-header-create">
                {!! Form::text('fiscalYear',old('fiscalYear'),['class'=>'form-control', 'placeholder'=>'E.g. 2070/071','required'=>'required']) !!}
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
                    <th style="width: 5%;">#</th>
                    <th style="width: 70%;">Fiscal Year</th>
                    <th style="width: 20%;">Action</th>

                </tr>
            </thead>
            <tbody>
            <?php $counter =0; ?>
            @foreach($fiscalYear as $year)
            <tr>
                <td>{{++$counter}}</td>
                <td>{{$year->label}}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm editbtn" data-label="{{$year->label}}" 
                        data-toggle="modal" data-target="#editFiscalYear" 
                        data-url="{{route('admin.fiscalYear.update',$year->id)}}">
                        <i class="fa fa-edit"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Update Modal-->
<div class="modal fade" id="editFiscalYear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'put','id'=>'year_edit']) !!}
            <div class="modal-header">
                <h4>Edit News Category</h4>
            </div>
            <div class="modal-body">
                {!! Form::label('label', 'Fiscal Year',['class'=>'required']) !!}
                    {!! Form::text('label',old('label'),['class'=>'form-control','id'=>'year_label','required'=>'required']) !!}
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
    $(document).ready(function(){
        $('.datatable').DataTable({
            order : [[1,'desc']]
        });
    });

    $(document).on('click','.editbtn',function(){
        label = $(this).data('label');
        url = $(this).data('url');
        $('#year_label').attr('value',label);
        $('#year_edit').attr('action',url);
    });
</script>
@endsection