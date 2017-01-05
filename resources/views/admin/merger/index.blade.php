@extends('admin.master')

@section('title')
 Merger &amp; Acquisition
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-building fa-fw"></i> Merger :List:</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.merger.create')}}">
                <i class="fa fa-plus"></i> Add Merger
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Companies</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mergers as $id => $merger)
                    <tr>
                        <td>{{ $merger->companies }}</td>
                        <td>{{ $merger->company->name }}</td>
                        <td>{{ $merger->type }}</td>
                        <td>{{ $merger->status }}</td>
                        <td>
                            {!! Form::open(['route'=>['admin.merger.destroy', $merger->id],'method'=>'DELETE']) !!}
                                <a href="{{ route('admin.merger.edit', $merger->id) }}" class="btn btn-primary">Edit</a>
                                <button type="button" class="btn btn-danger delbtn">Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.merger.create')}}">
            <i class="fa fa-plus"></i> Add Merger
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
        $('.datatable').DataTable({
            order : [[0,'desc']],
            processing: true,
            serverSide:false,
            paging:true,
        });

        $(document).on('click','.delbtn',function(e){
            e.preventDefault();
            var $form = $(this).closest('form');
            var $modal = $('#deleteNews').show();
            $modal.modal();
            $('.confirm-delete').click(function(){
                $form.submit();
            });
        });
    });
</script>
@endsection
