@extends('admin.master')

@section('title')
    Economy Label
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-th-list fa-fw"></i> Economy Label :List
            </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-primary btn-sm btn-flat"
                        data-toggle="modal" data-target="#createCurrencyType">
                    <i class="fa fa-plus"></i> Add
                </button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.validation')
            <table class="table datatable">
                <thead>
                <tr>
                    <th class='col-sm-1'>#</th>
                    <th class='col-sm-9'>Name</th>
                    <th class='col-sm-2'>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($labels as $i=>$label)
                    <tr class="edit-row">
                        <td>{{++$i}}</td>
                        <td>{{$label->name}}</td>
                        <td>
                            {!! Form::open(['route'=>['admin.economyLabel.destroy',$label->id],'method'=>'delete']) !!}
                            <button type="button" class="btn btn-primary btn-sm editbtn" data-unit="{{$label->unit}}"
                                    data-name="{{($label->name)}}" data-toggle="modal" data-target="#editEconomyLabel"
                                    data-url="{{route('admin.economyLabel.update',$label->id)}}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delbtn"
                                    data-toggle="modal" data-target="#deleteEconomyLabel">
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

    <!-- Create Modal -->
    <div class="modal fade" id="createCurrencyType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => 'admin.economyLabel.store']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Add Economy Label</h4>
                </div>
                <div class="modal-body">
                    {!! Form::label('name', 'Name',['class'=>'required']) !!}
                    {!! Form::text('name',null,['class'=>'form-control','required'=>'required']) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit('Create',['class'=>'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!-- Update Modal-->
    <div class="modal fade" id="editEconomyLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['method'=>'put','id'=>'currencyType_edit']) !!}
                <div class="modal-header">
                    <h4>Edit Economy Label</h4>
                </div>
                <div class="modal-body">
                    {!! Form::label('name', 'Name',['class'=>'required']) !!}
                    {!! Form::text('name',null,['class'=>'form-control','id'=>'currencyType_name']) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteEconomyLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected economy label?
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
            $('.datatable').DataTable();
        });

        $(document).on('click','.editbtn',function(){
            var name = $(this).data('name');
            var unit = $(this).data('unit');
            var url = $(this).data('url');

            $('#currencyType_name').attr('value',name);
            $('#currencyType_unit').attr('value',unit);
            $('#currencyType_edit').attr('action',url);
        });

        $(document).on('click','.delbtn',function(e){
            $form=$(this).closest('form');
            e.preventDefault();
            $modal=$('#deleteEconomyLabel');
            $modal.modal();
            $('.confirm-delete').click(function(){
                $form.submit();
            });
        });
    </script>
@endsection
