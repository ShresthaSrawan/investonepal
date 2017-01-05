@extends('admin.master')

@section('title')
    Nepse Group
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-th-list fa-fw"></i> Nepse Group :List
            </h3>
            <div class="alert alert-validation" role="alert" style="margin-top:10px;">
                {!! Form::open(['route'=>'nepseGroup.upload','files'=>true]) !!}
                    <div class="row">
                        <div class="col-lg-6" style="margin-top:6px;">
                            Nepse Group should be in XLS format and only contain company quote and grade.
                        </div>
                        <div class="col-lg-6" style="margin-bottom: -15px">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="file" name="file" class="form-control">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-flat" type="submit">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table class="table datatable">
                <thead>
                <tr>
                    <th class='col-sm-2'>Fiscal Year</th>
                    <th class='col-sm-9'>Company</th>
                </tr>
                </thead>
                <tbody>
                    @if(!$nepseGroup->isEmpty())
                        @foreach($nepseGroup as $i=>$nepse)
                            <tr>
                                <td>{{$nepse->fiscalYear->label}}</td>
                                <td>
                                    <div class="box box-solid collapsed-box no-margin">
                                        <div class="box-header">
                                            <h3 class="box-title">Nepse Group</h3>
                                            <div class="box-tools">
                                                <div class="no-margin pull-right">
                                                    <button class="btn btn-box-tool" data-widget="collapse" type="button"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body no-padding">
                                            <table class="table table-condensed no-padding no-border table-hover">
                                                <tbody><tr>
                                                    <th>#</th>
                                                    <th>Company</th>
                                                    <th>Grade</th>
                                                </tr>
                                                @foreach($nepse->nepseGroupGrade as $key=>$grade)
                                                    <tr>
                                                        <td>{{++$key}}</td>
                                                        <td>{{$grade->company->name}}</td>
                                                        <td>{{ucwords($grade->grade)}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="box-footer no-padding">
                                            {!!  Form::open(['route'=>['nepseGroup.destroy',$nepse->id],'method'=>'delete','class'=>'form-inline pull-right']) !!}
                                                <button class="btn btn-box-tool btn-box-danger delbtn" type="submit" 
                                                data-toggle="modal" data-target="#deleteNepseGroup" data-fiscal="{{$nepse->fiscalYear->label}}">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteNepseGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p class="text-danger">Are you sure you want to delete nepse group of <strong></strong>?</p>
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
            $form=$(this).closest('form');
            var fiscalYear = $(this).data('fiscal');
            $('#deleteNepseGroup').find('strong').text(fiscalYear);
            e.preventDefault();
            $('.confirm-delete').click(function(){
                $form.submit();
            });
        });
    </script>
@endsection