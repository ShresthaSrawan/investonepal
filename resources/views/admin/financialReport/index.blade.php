@extends('admin.master')

@section('title')
Financial Report
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title" style="font-size: 25px; font-weight: 400">
            <i class="fa fa-files-o fa-fw"></i> Financial Report :List:
        </h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.financialReport.create')}}">
                <i class="fa fa-plus"></i> Add Financial Report
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Fiscal Year</th>
                    <th>Quarter</th>
                    <th>Company</th>
                    <th>Entry Date</th>
                    <th>Reports</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($financialReport as $report)
                <tr>
                    <td>{{$report->fiscalYear->label}}</td>
                    <td>{{$report->quarter->label}}</td>
                    <td>{{$report->company->name}}</td>
                    <td>{{$report->entry_date}}</td>
                    <td>
                        <a href="{{route('admin.financialReport.show',$report->id)}}" class="btn btn-primary btn-xs">
                            <i class="fa fa-eye"></i> Add Report
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['route'=>['admin.financialReport.destroy',$report->id],'method'=>'delete']) !!}
                            <a href="{{route('admin.financialReport.edit',$report->id)}}" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger btn-xs delbtn" 
                                    data-toggle="modal" data-target="#deleteFinancialReport">
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
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.financialReport.create')}}">
            <i class="fa fa-plus"></i> Add Financial Report
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteFinancialReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
            order : [[0,'desc']]
        });
    });

    $(document).on('click','.delbtn',function(e){
        e.preventDefault();
        $form=$(this).closest('form');
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection