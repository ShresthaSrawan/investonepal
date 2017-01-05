@extends('admin.master')

@section('title')
    Announcement Misc
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bullhorn fa-fw"></i>Dynamic Announcement Title & Description</h3>
            <div class="box-tools pull-right">
                <a class="btn btn-primary btn-xs" href="{{route('admin.announcement.misc.create')}}"><i class="fa fa-plus"></i> Add New</a>
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            @if($miscs->isEmpty())
                <div class="callout callout-custom-info">
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    <p>Sorry, no data available <a class="btn btn-primary btn-xs pull-right" href="{{route('admin.announcement.misc.create')}}"><i class="fa fa-plus"></i> Add New</a></p>
                </div>
            @else
            <table class="table no-margin datatable">
                <thead>
                <tr>
                    <th class='col-sm-1'>Sn</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Subtype</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($miscs as $index=>$misc)
                    <tr>
                        <td>{{++$index}}</td>
                        <td>{{$misc->title}}</td>
                        <td>{{$misc->type->label}}</td>
                        <td>{{$misc->subtype->label}}</td>
                        <td>
                            {!! Form::open(['route'=>['admin.announcement.misc.destroy',$misc->id],'method'=>'delete']) !!}
                            <a href="{{route('admin.announcement.misc.show',$misc->id)}}" class="btn btn-xs btn-default">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{route('admin.announcement.misc.edit',$misc->id)}}" class="btn btn-xs btn-primary">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="submit" class="btn btn-danger btn-xs delbtn"
                                    data-toggle="modal" data-target="#delete">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
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