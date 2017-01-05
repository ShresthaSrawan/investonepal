@extends('admin.master')

@section('title')
Issue Manager
@endsection

@section('specificheader')
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-male fa-fw"></i> Issue Manager :List:</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.issueManager.create')}}">
                <i class="fa fa-plus"></i> Add Issue Manager
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th class='col-sm-1'>S.No.</th>
                    <th class='col-sm-5'>Name</th>
                    <th class='col-sm-5'>Company</th>
                    <th class='col-sm-1'>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php $counter =1; ?>
            @foreach($issueManagers as $issueManager)
            <tr>
                <td>{{$counter}}</td>
                <td>{{ucfirst($issueManager->name)}}</td>
                <td>{{ucwords($issueManager->company)}}</td>
                <td>
                    {!! Form::open(['route'=>['admin.issueManager.destroy',$issueManager->id],'method'=>'delete']) !!}
                        <a href="#" class="btn btn-primary btn-xs editbtn"
                           data-url="{{route('admin.issueManager.edit',$issueManager->id)}}"
                           data-company="{{ucwords($issueManager->company)}}"
                           data-name="{{ucwords($issueManager->name)}}" 
                           data-address="{{ucwords($issueManager->address)}}"
                           data-phone="{{$issueManager->phone}}" 
                           data-email="{{$issueManager->email}}"
                           data-web="{{$issueManager->web}}" 
                           data-toggle="modal" data-target="#viewIssueManager">
                            <i class="glyphicon glyphicon-eye-open"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-xs delbtn"
                            data-toggle="modal" data-target="#deleteIssueManager">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                    {!! Form::close() !!}
                </td>
            </tr>
            <?php $counter++; ?>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.issueManager.create')}}">
            <i class="fa fa-plus"></i> Add Issue Manager
        </a>
    </div>
</div>

<!-- View Modal-->
<div class="modal fade" id="viewIssueManager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Issue Manager Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <table class="table table-condensed table-hover">
                           <thead>
                               <tr>
                                   <th>Field</th>
                                   <th>Value</th>
                               </tr>
                           </thead>
                            <tbody>
                                <tr>
                                    <td>Company</td>
                                    <td id="issueManager_company"></td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td id="issueManager_name"></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td id="issueManager_address"></td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td id="issueManager_phone"></td>
                                </tr>
                                <tr>
                                    <td>E-Mail</td>
                                    <td id="issueManager_email"></td>
                                </tr>
                                <tr>
                                    <td>Web</td>
                                    <td id="issueManager_web"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary editLink"><i class="fa fa-pencil-square-o"></i> Edit</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteIssueManager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
    $(document).on('click','.editbtn',function(){
        var url = $(this).data('url');
        var name = $(this).data('name');
        var address = $(this).data('address');
        var phone = $(this).data('phone');
        var email = $(this).data('email');
        var web = $(this).data('web');
        var company = $(this).data('company');


        $('.editLink').prop('href',url);
        $('#issueManager_name').html(name);
        $('#issueManager_company').html(company);
        $('#issueManager_address').html(address ? address : 'NA');
        $('#issueManager_phone').html(phone ? phone : 'NA');
        $('#issueManager_email').html(email ? email : 'NA');
        $('#issueManager_web').html(web ? web : 'NA');
    });

    $(document).ready(function(){
        $('.datatable').DataTable();
    });
    
    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteIssueManager');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection