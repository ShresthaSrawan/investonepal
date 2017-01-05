@extends('admin.master')

@section('title')
Company
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-gears fa-fw"></i> Company :List:</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.company.create')}}">
                <i class="fa fa-plus"></i> Add Company
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Sector</th>
                    <th>BOD</th>
                    <th>Base Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.company.create')}}">
            <i class="fa fa-plus"></i> Add Company
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteCompany" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
            order : [[0,'asc']],
            processing: true,
            serverSide:true,
            paging:true,
            lengthMenu: [[50,100,150,200],[50,100,150,200]],
            aoColumnDefs:[{'bSortable': false, 'aTargets': [ 3,4,5 ] }],
            ajax:{
                url: '{{route("get-company-datatable")}}',
                type: 'POST'
            },
            columns: [
                {data: 'name',name:'name',render:function(name,type,row,meta){
                    action ='<a href="{{url("/")}}/admin/company/'+ row.id +'" target="_blank">'+name+'</a>';
                    return action;
                }},
                {data: 'quote',name:'quote'},
                {data: 'sector',name:'sector.label',render:function(sector){
                    return sector.label;
                }},
                {data: 'quote',searchable:false,render:function(data,type,row,meta){
                    action = '\
                        <a href="{{url("/")}}/admin/company/'+ row.id +'/bod" target="_blank" class="btn btn-default btn-xs">\
                            <i class="fa fa-eye"></i>\
                        </a>';
                    return action;
                }},
                {data: 'quote',searchable:false,render:function(data,type,row,meta){
                    action = '\
                        <a href="{{url("/")}}/admin/company/'+ row.id +'/basePrice" target="_blank" class="btn btn-default btn-xs">\
                            <i class="fa fa-eye"></i>\
                        </a>';
                    return action;
                }},
                {data: 'quote',searchable:false,render:function(data,type,row,meta){
                    action = '\
                    <form method="POST" action="{{url("/")}}/admin/company/' + row.id + '" accept-charset="UTF-8">\
                    <input name="_method" type="hidden" value="DELETE">\
                    <input name="_token" type="hidden" value="{{csrf_token()}}">\
                        <a href="{{url("/")}}/admin/company/'+ row.id +'" target="_blank" class="btn btn-primary btn-xs">\
                            <i class="glyphicon glyphicon-eye-open"></i>\
                        </a>\
                        <button type="button" class="btn btn-danger btn-xs delbtn"\
                            data-toggle="modal" data-target="#deleteNews">\
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
            $modal=$('#deleteCompany');
            $modal.modal();
            $('.confirm-delete').click(function(){
                $form.submit();
            });
        });
    });
</script>
@endsection