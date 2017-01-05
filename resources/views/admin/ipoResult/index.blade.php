@extends('admin.master')

@section('title')
IPO Result
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-file-text fa-fw"></i>IPO Result :List</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.ipo-result.create')}}">
                <i class="fa fa-plus"></i> Add Ipo Result
            </a>
        </div>
    </div>
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Sn</th>
                    <th>Applicants</th>
                    <th>Company</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteIpoResult" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
    var ipoResultURL = "{{route('api-get-ipo-result')}}";
    var ipoResultTable;
    var csrf="{{csrf_token()}}";
    $(document).ready(function(){
        $(document).on('click','.delbtn',function(e){
            e.preventDefault();
            var $form = $(this).closest('form');
            var $modal = $('#deleteNews').show();
            $modal.modal();
            $('.confirm-delete').click(function(){
                $form.submit();
            });
        });
    });
</script>
{!! HTML::script('vendors/date/date.js') !!}
{!! HTML::script('assets/nsm/admin/js/iporesult.js') !!}
@endsection
