@extends('admin.master')

@section('title')
    Announcement Misc
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-cube fa-fw"></i> Dynamic Title & Descriptions <small>{{$misc->type->label}} <i class="fa fa-angle-right"></i> {{$misc->subtype->label}} </small></h3>
            <div class="box-tools pull-right">
                <a href="{{route('admin.announcement.misc.edit',$misc->id)}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                <a class="btn btn-primary btn-flat btn-xs" href="{{route('admin.announcement.misc.create')}}"><i class="fa fa-plus"></i> Add</a>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <dl class="dl-horizontal">
                <dt>Title</dt>
                <dd>{{$misc->title}}</dd>
                <dt>Description</dt>
                <dd>{{$misc->description}}</dd>
                <dt>Type</dt>
                <dd>{{$misc->type->label}}</dd>
                <dt>Subtype</dt>
                <dd>{{$misc->subtype->label}}</dd>
            </dl>
        </div>
        <div class="box-footer clearfix no-border">
            {!! Form::open(['route'=>['admin.announcement.misc.destroy',$misc->id],'method'=>'delete']) !!}
            <button type="submit" class="btn btn-danger btn-xs delbtn pull-right"
                    data-toggle="modal" data-target="#delete">
                <i class="fa fa-trash"></i> Delete
            </button>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="modal fade in out" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected item ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger confirmDelete"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('endscript')
    <script>
        $(document).on('click','.delbtn',function(e){
            $form=$(this).closest('form');
            e.preventDefault();
            console.log('clicked');
            $('.confirmDelete').click(function(){
                $form.submit();
            });
        });
    </script>
@endsection
