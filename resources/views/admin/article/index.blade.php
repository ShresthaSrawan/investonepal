@extends('admin.master')

@section('title')
Article
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-file-text fa-fw"></i> Article :List:
        </h3>

        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.article.create')}}">
                <i class="fa fa-plus"></i> Add Article
            </a>
        </div>
    </div>

    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.article.create')}}">
            <i class="fa fa-plus"></i> Add Article
        </a>
    </div>
</div>

<div class="modal fade" id="deleteArticle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
            order : [[0,'desc']],
            processing: true,
            serverSide:true,
            paging:true,
            aoColumnDefs:[{'bSortable': false, 'aTargets': [ 3 ] }],
            ajax:{
                url: '{{route("get-article-datatable")}}',
                type: 'POST'
            },
            columns: [
                {data: 'pub_date',name:'pub_date'},
                {data: 'title',name:'title'},
                {data: 'category',name:'category',render:function(category){
                    return category.label;
                }},
                {data: 'pub_date',name:'pub_date',searchable:false,render:function(date,type,row,meta){
                    action = '\
                    <form method="POST" action="{{url("/")}}/admin/article/' + row.id + '" accept-charset="UTF-8">\
                    <input name="_method" type="hidden" value="DELETE">\
                    <input name="_token" type="hidden" value="{{csrf_token()}}">\
                        <a href="{{url("/")}}/admin/article/'+ row.id +'" class="btn btn-primary btn-xs">\
                            <i class="glyphicon glyphicon-eye-open"></i>\
                        </a>\
                        <button type="button" class="btn btn-danger btn-xs delbtn"\
                            data-toggle="modal" data-target="#deleteArticle">\
                            <i class="glyphicon glyphicon-trash"></i>\
                        </button>\
                        </form>';
                        return action;
                }}
            ]
        });

        $(document).on('click','.delbtn',function(e){
            e.preventDefault();
            $form=$(this).closest('form');
            $('.confirm-delete').click(function(){
                $form.submit();
            });
        });
    });
</script>
@endsection