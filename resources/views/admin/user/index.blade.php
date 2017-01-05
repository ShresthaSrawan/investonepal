@extends('admin.master')

@section('title')
User
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-users fa-fw"></i> User :List:</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.user.create')}}">
                <i class="fa fa-plus"></i> Add User
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Expiry</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.user.create')}}">
            <i class="fa fa-plus"></i> Add User
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteUsers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
            order : [[1,'desc']],
            processing: true,
            serverSide:true,
            paging:true,
            aoColumnDefs:[{'bSortable': false, 'aTargets': [ 3 ] }],
            ajax:{
                url: '{{route("get-user-datatable")}}',
                type: 'POST'
            },
            columns: [
                {data: 'username',name:'username'},
                {data: 'email',name:'email'},
                {data: 'user_type.label',name:'user_type.label'},
                {data: 'status',name:'status',render:function(status){
                    if(status==0){
                        return 'Inactive';
                    }else if(status==1){
                        return 'Active';
                    }
                    return 'Invalid';
                }},
                {data: 'created_at',name:'created_at',render:function(data) {
                    return moment(data+"","YYYY-MM-DD HH:mm:ss").format('YYYY-MM-DD');
                }},
                {data: 'expiry_date',name:'expiry_date'},
                {data:null,searchable:false,render:function(date,type,row,meta){
                    action = '\
                    <form method="POST" action="{{url("/")}}/admin/user/' + row.id + '" accept-charset="UTF-8">\
                        <input name="_method" type="hidden" value="DELETE">\
                        <input name="_token" type="hidden" value="{{csrf_token()}}">\
                            <a href="{{url("/")}}/admin/user/'+ row.id +'/edit" class="btn btn-primary btn-xs">\
                                <i class="fa fa-edit"></i>\
                            </a>\
                            <a href="{{url("/")}}/admin/user/'+ row.id +'" class="btn btn-primary btn-xs">\
                                <i class="glyphicon glyphicon-eye-open"></i>\
                            </a>\
                            <button type="button" class="btn btn-danger btn-xs delbtn"\
                                data-toggle="modal" data-target="#deleteUsers">\
                                <i class="glyphicon glyphicon-trash"></i>\
                            </button>\
                    </form>';
                        return action;
                }}
            ]
        });
    
        $(document).on('click','.delbtn',function(e){
            $form=$(this).closest('form');
            e.preventDefault();
            $modal=$('#deleteUsers');
            $modal.modal();
            $('.confirm-delete').click(function(){
                $form.submit();
            });
        });

    });
</script>
@endsection