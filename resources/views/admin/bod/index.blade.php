
@extends('admin.master')

@section('title')
BOD
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user-md fa-fw"></i> BOD of <strong>{{$company->name}}</strong> :List:</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.company.bod.create',$company->id)}}">
                <i class="fa fa-plus"></i> Add BOD
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th class='col-sm-1'>Sn</th>
                    <th class='col-sm-5'>Name</th>
                    <th class='col-sm-2'>Post</th>
                    <th class='col-sm-2'>Fiscal Year</th>
                    <th class='col-sm-2'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $key = 0; ?>
                @foreach($bods as $bod)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{ucwords($bod->name)}}</td>
                    <td>{{ucwords($bod->bodPost->label)}}</td>
                    <td>
                        <ol>
                        @foreach($bod->bodFiscalYear as $bodFiscalYear)
                            <li>{{$bodFiscalYear->fiscalYear->label}}</li>
                        @endforeach
                        </ol>
                    </td>
                    <td>
                        {!! Form::open(['route'=>['admin.company.bod.destroy','cid'=>$bod->company->id,'bid'=>$bod->id],'method'=>'delete']) !!}
                        <a href="{{route('admin.company.bod.edit',['cid'=>$bod->company->id, 'bid'=>$bod->id])}}"
                            class="btn btn-primary btn-xs">
                            <i class="glyphicon glyphicon-edit"></i>
                        </a>
                        <a href="{{route('admin.company.bod.show', ['cid'=>$bod->company->id, 'bid'=>$bod->id])}}"
                            class="btn btn-primary btn-xs">
                            <i class="glyphicon glyphicon-eye-open"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-xs delbtn" data-toggle="modal" data-target="#deletebod">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.company.bod.create',$company->id)}}">
            <i class="fa fa-plus"></i> Add BOD
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deletebod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
<script type="text/javascript">
    $('.mymulti').chosen();

    $(document).ready(function(){
        $('.datatable').DataTable();
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deletebod');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
