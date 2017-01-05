@extends('admin.master')

@section('title')
IPO Pipeline
@endsection

@section('specificheader')
{!! HTML::style('vendors/chosen/chosen.css') !!}
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-send-o fa-fw"></i> IPO Pipeline :List:</h3>
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.ipoPipeline.create')}}">
            <i class="fa fa-plus fa-fw"></i> Add IPO Pipeline
        </a>
    </div>
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Sn</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th>Fiscal</th>
                    <th>Issue Manager</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $key = 0; ?>
                @foreach($ipoPipelines as $ipoPipeline)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{ucwords($ipoPipeline->company->name)}}</td>
                        <td>{{ucwords($ipoPipeline->announcementSubType->label)}}</td>
                        <td>{{ucwords($ipoPipeline->fiscalYear->label)}}</td>
                        <td>
                            <ol>
                                @foreach($ipoPipeline->ipoIssueManager as $ipoman)
                                  <li>{{$ipoman->issueManager->company}}</li>
                                @endforeach
                            </ol>
                        </td>
                        <?php $issue = $ipoPipeline->issue_status==1?"Yes":"No"; ?>
                        <td>
                            {!! Form::open(['route'=>['admin.ipoPipeline.destroy',$ipoPipeline->id],'method'=>'delete']) !!}
                                <button type="button" 
                                    data-url="{{route('admin.ipoPipeline.edit',$ipoPipeline->id)}}"
                                    data-companyname="{{ucwords($ipoPipeline->company->name)}}" 
                                    data-fiscalyear="{{$ipoPipeline->fiscalYear->label}}" 
                                    data-announcementsubtype = "{{$ipoPipeline->announcementSubType->label}}" 
                                    data-amountofsecurities="{{$ipoPipeline->amount_of_securities}}"
                                    data-amountofpublicsecurities="{{$ipoPipeline->amount_of_public_securities}}" 
                                    data-approvaldate="{{$ipoPipeline->approval_date}}" 
                                    data-applicationdate = "{{$ipoPipeline->application_date}}" 
                                    data-amountofpublicissue = "{{$ipoPipeline->amount_of_public_issue}}"
                                    data-issuestatus="{{$issue}}" 
                                    data-remarks="{{$ipoPipeline->remarks}}" 
                                    data-toggle="modal" data-target="#viewDetails"
                                    class="btn btn-primary btn-xs viewbtn">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-xs delbtn" 
                                    data-toggle="modal" data-target="#deleteIpoPipeline">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.ipoPipeline.create')}}">
            <i class="fa fa-plus fa-fw"></i> Add IPO Pipeline
        </a>
    </div>
</div>

<!-- Update Modal-->
<div class="modal fade" id="viewDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>IPO Pipeline - Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">Company Name</div>
                    <div class="col-md-6" id="company"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Fiscal Year</div>
                    <div class="col-md-6" id="fiscal_year"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Type of Securities</div>
                    <div class="col-md-6" id="type_of_securities"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Amount of Securities</div>
                    <div class="col-md-6" id="amount_of_securities"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Amount of Public Issue</div>
                    <div class="col-md-6" id="amount_of_public_issue"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">Approval Date</div>
                    <div class="col-md-6" id="approval_date"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">Application Date</div>
                    <div class="col-md-6" id="application_date"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">Issue Status</div>
                    <div class="col-md-6" id="issue_status"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">Remarks</div>
                    <div class="col-md-6" id="remark"></div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" id="editDetails">Edit</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteIpoPipeline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
{!! HTML::script('vendors/chosen/chosen.jquery.min.js') !!}
<script type="text/javascript">
    $(document).ready(function(){
        $('.datatable').DataTable({
            aoColumnDefs:[{'bSortable': false, 'aTargets': [  4,5 ] }],
        });
    });

    $('.mymulti').chosen();

    $(document).on('click','.viewbtn',function(){

        var company = $(this).data('companyname');
        var fiscalYear = $(this).data('fiscalyear');
        var typeOfSecurities = $(this).data('announcementsubtype');
        var amountOfSecurities = $(this).data('amountofsecurities');
        var amountOfPublicIssue = $(this).data('amountofpublicissue')
        var approvalDate = $(this).data('approvaldate');
        var applicationDate = $(this).data('applicationdate');
        var issueStatus = $(this).data('issuestatus');
        var remarks = $(this).data('remarks');
        var url = $(this).data('url');


        $('#editDetails').attr('href',url);
        $('#company').html(company);
        $('#fiscal_year').html(fiscalYear);
        $('#amount_of_public_issue').html(amountOfPublicIssue);
        $('#type_of_securities').html(typeOfSecurities);
        $('#amount_of_securities').html(amountOfSecurities);
        $('#approval_date').html(approvalDate);
        $('#application_date').html(applicationDate);
        $('#issue_status').html(issueStatus);
        $('#remark').html(remarks);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteIpoPipeline');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
