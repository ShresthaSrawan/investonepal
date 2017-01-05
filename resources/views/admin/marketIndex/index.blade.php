@extends('admin.master')

@section('title')
Market Index
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-history fa-fw"></i> Market Index :List:</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.marketIndex.create')}}">
                <i class="fa fa-plus"></i> Add Market Index
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
            <tr>
                <th>Date</th>
                <th>Value</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($indexValue as $index)
            <tr>
                <td>{{$index->date}}</td>
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
                        @foreach($index->indexValue as $key=>$value)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$value->type->name}}</td>
                                <td>{{$value->value}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
                <td>
                    {!! Form::open(['route'=>['admin.marketIndex.destroy',$index->id],'method'=>'delete']) !!}
                        <a href="{{route('admin.marketIndex.edit',$index->id)}}" class="btn btn-primary btn-xs editbtn">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-xs delbtn" data-toggle="modal" data-target="#deleteIndexValue">
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
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.marketIndex.create')}}">
            <i class="fa fa-plus"></i> Add Market Index
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteIndexValue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
            'order' : [[0,'desc']],
            'lengthMenu': [[7,14,21,28],[7,14,21,28]]
        });
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteIndexValue');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection