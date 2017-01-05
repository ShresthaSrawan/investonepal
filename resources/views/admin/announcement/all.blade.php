@extends('admin.master')

@section('title')
Announcement
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-bullhorn fa-fw"></i> Announcement <small>:List:</small></h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-flat btn-xs" href="{{route('admin.announcement.create')}}">Make Announcement</a>
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table no-margin datatable">
            <thead>
            <tr>
                <th>Sn</th>
                <th>Title</th>
                <th>Company</th>
                <th>Type</th>
                <th>Subtype</th>
                <th>Pub. Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<div class="modal fade in out" id="deleteAnnouncement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the selected announcement ?
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
<script type="text/javascript">
var root = "{{url('/admin')}}";
var token = $('meta[name=csrf-token]').attr('content');
var searchAnnouncemnet = "{{route('admin.api.search.announcement')}}";
var rowCount = 0;
var dtSettings = {
    processing: true,
    paging: true,
    serverSide: true,
    ajax: {
        url: searchAnnouncemnet,
        type: 'POST'
    },
	order:[[5,'desc']],
    columns: [
        {data: 'id', name:'id',searchable:false,orderable:false},
        {data: 'title', name:'title'},
        {data: 'company.name', name:'company.name', visible: false},
        {data: 'type.label', name:'type.label'},
        {data: 'subtype.label', name:'subtype.label', "render": function(data,type,row){
            if(data)
                return data;
            return "NA";
        }},
        {data: 'pub_date', name:'pub_date'},
        {
            data: 'id',
            name:'id',
            searchable:false,
            orderable:false,
            render:function(id,type,row,meta){
                return '<form method="post" action="'+root+'/announcement/'+id+'"><input type="hidden" name="_token" value="'+token+'"><input type="hidden" name="_method" value="delete"><div class="btn-group-xs"><a class="btn btn-default" href="'+root+'/announcement/'+id+'"><i class="fa fa-eye"></i> Show</a><a class="btn btn-default btn-xs" href="'+root+'/announcement/'+id+'/edit"><i class="fa fa-edit"></i> Edit</a><button class="btn btn-default btn-xs deleteAnon" type="submit"><i class="fa fa-trash"></i> Delete</button></div><form>';
            }
        }
    ],
    lengthMenu: [[100, 200, 300], [100, 200, 300]]
};

$(document).ready(function() {
    annTable = $('.datatable').DataTable(dtSettings);

    annTable.on( 'order.dt search.dt page.dt draw.dt', function () {
        annTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        });
    }).draw();

    $(document).on('click','.deleteAnon',function(e){
        e.preventDefault();
        var $form = $(this).closest('form');
        var $modal = $('#deleteAnnouncement').show();
        $modal.modal();
        $('.confirmDelete').click(function(){
            $form.submit();
        });
    });
});
</script>
@endsection