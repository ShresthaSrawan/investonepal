@extends('admin.master')

@section('title')
    Announcement Subtypes
@endsection

@section('content')
@include('admin.partials.validation')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bullhorn fa-fw"></i><strong>{{ucwords($anonType->label)}}</strong> :Subtypes:</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            {!! Form::open(array('route' => ['admin.announcement-type.subtype.store',$anonType->id],'class'=>'form-horizontal'))!!}
                <div class="input-group clearfix box-header-create">
                    {!! Form::text('label',old('label'),['class'=>'form-control','placeholder'=>'Subtype Label']) !!}
                    @if($errors->has('label'))
                        <span class="text-danger col-lg-9 col-lg-offset-2">{{$errors->first('label')}}</span>
                    @endif
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </span>
                </div>
            {!! Form::close() !!}
        </div><!-- /.box-header -->
        <div class="box-body">
            @include('admin.partials.validation')
            <div class="col-lg-12">
                <table class="table datatable">
                    <thead>
                    <tr>
                        <th>Sn</th>
                        <th>Label</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($anonType->subTypes as $index=>$subtype)
                        <tr>
                            <td>{{++$index}}</td>
                            <td>{{$subtype->label}}</td>
                            <td>
                                {!! Form::open(['route'=>['admin.announcement-type.subtype.destroy',$anonType->id,$subtype->id],'method'=>'delete']) !!}
                                <div class="btn-group-xs">
                                    <button type="button" class="btn btn-default editbtn" data-id="{{$subtype->id}}" data-label="{{$subtype->label}}" data-url="{{route('admin.announcement-type.subtype.update',[$anonType->id,$subtype->id])}}" data-toggle="modal" data-target="#editSub">
                                        <i class="glyphicon glyphicon-edit"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-default deleteSubtype" data-toggle="modal" data-target="#deleteAnnouncementSubtype"><i class="fa fa-trash"></i> Delete</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade in out" id="deleteAnnouncementSubtype" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected announcement subtype ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger confirmDelete"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal-->
    <div class="modal fade" id="editSub" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['method'=>'put','id'=>'sub_edit']) !!}
                    <div class="modal-header">
                        <h4>Edit News Category</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::label('label', 'News Category',['class'=>'required']) !!}
                            {!! Form::text('label',old('label'),['class'=>'form-control','id'=>'sub_label','required'=>'required']) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Update
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('endscript')
    <script>
        $(document).on('click','.editbtn',function(){
            label = $(this).data('label');
            url = $(this).data('url');
            $('#sub_label').attr('value',label);
            $('#sub_edit').attr('action',url);
        });

        $(document).ready(function(){
            $('.deleteSubtype').click(function(e){
                e.preventDefault();
                var $form = $(this).closest('form');

                $('.confirmDelete').click(function(){
                    $form.submit();
                });
            });
        });
    </script>
@endsection