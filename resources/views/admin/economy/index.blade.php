@extends('admin.master')

@section('title')
    Economy
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-bar-chart-o fa-fw"></i> Economy :List
            </h3>
            <div class="box-tools pull-right">
                <a type="button" class="btn btn-primary btn-sm btn-flat" href="{{route('admin.economy.create')}}">
                    <i class="fa fa-plus"></i> Create
                </a>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table class="table dataTable">
                <thead>
                <tr>
                    <th class='col-sm-1'>#</th>
                    <th class='col-sm-2'>Fiscal Year</th>
                    <th class='col-sm-9'>Economy</th>
                </tr>
                </thead>
                <tbody>
                    <? $fid = null; ?>
                    @if(!$economies->isEmpty())
                        @foreach($economies as $i=>$economy)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$economy->fiscalYear->label}}</td>
                                <td>
                                    <div class="box box-solid collapsed-box no-margin">
                                        <div class="box-header">
                                            <h3 class="box-title">Economy</h3>
                                            <div class="box-tools">
                                                <div class="no-margin pull-right">
                                                    <button class="btn btn-box-tool" data-widget="collapse" type="button"><i class="fa fa-plus"></i></button>
                                                    <a class="btn btn-box-tool btn-box-info" href="{{route('admin.economy.edit',$economy->id)}}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body no-padding">
                                            <table class="table table-condensed no-padding no-border table-hover">
                                                <tbody><tr>
                                                    <th>#</th>
                                                    <th>Label</th>
                                                    <th>Value</th>
                                                    <th>Date</th>
                                                </tr>
                                                @foreach($economy->values as $key=>$value)
                                                    <tr>
                                                        <td>{{++$key}}</td>
                                                        <td>{{$value->label->name}}</td>
                                                        <td>{{$value->value}}</td>
                                                        <td><span class="label label-success">{{date_create($value->date)->format('j M Y')}}</span></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="box-footer no-padding">
                                            {!!  Form::open(['route'=>['admin.economy.destroy',$economy->id],'method'=>'delete','class'=>'form-inline pull-right']) !!}
                                            <button class="btn btn-box-tool btn-box-danger delbtn" type="submit" data-toggle="modal" data-target="#deleteEconomy" data-fiscal="{{$economy->fiscalYear->label}}"><i class="fa fa-trash-o"></i> Delete</button>
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
    <div class="modal fade" id="deleteEconomy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    <p class="text-danger">Are you sure you want to delete economy of <strong></strong>?</p>
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
            $('.dataTable').dataTable();
        });
        $(document).on('click','.delbtn',function(e){
            $form=$(this).closest('form');
            var fiscalYear = $(this).data('fiscal');
            $('#deleteEconomy').find('strong').text(fiscalYear);
            e.preventDefault();
            $('.confirm-delete').click(function(){
                $form.submit();
            });
        });
    </script>
@endsection
