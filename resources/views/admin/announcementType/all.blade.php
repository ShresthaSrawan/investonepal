@extends('admin.master')

@section('title')
    Announcement Type
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bullhorn fa-fw"></i> Announcement Type :List:</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(array('route' => 'admin.announcement-type.store'))!!}
                <div class="col-lg-12">
                    <div class="input-group">
                        {!! Form::text('label',old('label'),['class'=>'form-control','placeholder'=>'Announcement Type']) !!}
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>Create</button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}

            <table class="table datatable">
                <thead>
                <tr>
                    <th>Sn</th>
                    <th>Label</th>
                    <th>Action</th>
                    <th>Subtypes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($announcementTypes as $type)
                    <tr>
                        <td>{{$type->id}}</td>
                        <td>{{$type->label}}</td>
                        <td>
                            {!! Form::open(['route'=>['admin.announcement-type.destroy',$type->id],'method'=>'delete']) !!}
                                <div class="btn-group-xs">
                                    <button type="button" class="btn btn-primary edit-at" data-toggle="modal" data-target="#editAnnouncementTypeModal" data-url="{{route('admin.announcement-type.update',$type->id)}}" data-label="{{$type->label}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger deleteType" type="submit"><i class="glyphicon glyphicon-trash"></i></button>
                                </div>
                            {!! Form::close() !!}
                        </td>
                        <td>
                            <a href="{{route('admin.announcement-type.show',$type->id)}}" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-plus-sign"></i> Add</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade in out" id="deleteAnnouncementType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected announcement type ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger confirmDelete"><i class="fa fa-trash"></i> Delete</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAnnouncementTypeModal" tabindex="-1" role="dialog" aria-labelledby="EditAnnouncementTypeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Announcement Type</h4>
                </div>
                <form class="form" id="ann-update" method="post">
                    <div class="modal-body">
                        <input type="text" name="label" id="announcement-label" class="form-control">
                        <input type="hidden" value="{{csrf_token()}}" name="_token">
                        <input type="hidden" value="PUT" name="_method">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Update</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@section('endscript')
    <script>
        $('.edit-at').on('click',function(){
            label = $(this).data('label');
            url = $(this).data('url');
            $('#announcement-label').val(label);
            /*url = ''+id;*/
            $('#ann-update').attr('action',url);
        });

        $('.deleteType').click(function(e){
            e.preventDefault();
            var $form = $(this).closest('form');
            var $modal = $('#deleteAnnouncementType').show();
            $modal.modal();
            $('.confirmDelete').click(function(){
                $form.submit();
            });
        });
    </script>
@endsection