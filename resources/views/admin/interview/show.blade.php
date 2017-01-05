@extends('admin.master')

@section('title')
Interview
@endsection

@section('specificheader')
    <style>
        <?php $ueImage = "";
            if(is_null($interview->externalDetail)):
                $ueImage = $interview->user;
            else:
                $ueImage = $interview->externalDetail;
            endif;
        ?>
        .circle-image
        {
            width:200px !important;
            height:200px !important;
            border-radius:50% !important;
            background-image:url("{{$interview->intervieweDetail->getImage()}}");
            display:block !important;
            background-position-y:25% !important;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .circle-image-ue, .circle-na
        {
            width:200px !important;
            height:200px !important;
            border-radius:50% !important;
            background-image:url("{{$ueImage->getImage()}}");
            display:block !important;
            background-position-y:25% !important;
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <table class="table-condensed borderless">
            <thead>
                <th style="font-size: 25px; font-weight: 400">
                    <i class="fa fa-microphone"></i> Interview :Show:
                    @if(is_null($interview->user_id))
                        External
                    @else
                        Internal
                    @endif
                </th>
            </thead>
            <tbody>
                <tr>
                    <th>Title</th>
                    <td>: {{ucwords($interview->title)}}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>: {{$interview->category->label}}</td>
                </tr>
                    @if(ucwords($interview->category->label) == "Bullion")
                        <tr>
                            <th>Bullion Type</th>
                            <td>: {{$interview->bullionType->name}}</td>
                    @elseif(ucwords($interview->category->label) == "Stock")
                            <th>Company</th>
                            <td>: {{is_null($interview->company) ? 'NA' : $interview->company->name}}</td>
                        </tr>
                    @endif
                <tr>
                    <th>Date Created</th>
                    <td>: {{$interview->pub_date}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                       @if($interview->status==0)
                            : Draft
                        @else
                            : Published
                        @endif 
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.interview.edit', $interview->id)}}">
                <i class="fa fa-edit"></i> Edit Interview
            </a>
        </div>        
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6 pull-left">
                <div class="row">
                    <div class="col-md-6 pull-left">
                        <div class="circle-image">
                            @if(url_exists($interview->intervieweDetail->getImage()) == 0)
                                <img src="http://placehold.it/150x150/dddddd/333333?text=NA" class="circle-na">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 pull-right">
                        <table class="table table-condensed">
                            <thead>
                               <tr>
                                   <th colspan="2">Interviewé Details</th>
                               </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td>{{$interview->intervieweDetail->name}}</td>
                                </tr>
                                <tr>
                                    <th>Organization</th>
                                    <td>{{is_null($interview->intervieweDetail->organization) ? 'NA' : $interview->intervieweDetail->organization}}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{$interview->intervieweDetail->address}}</td>
                                </tr>
                                <tr>
                                    <th>Contact</th>
                                    <td>{{is_null($interview->intervieweDetail->contact) ? 'NA' : $interview->intervieweDetail->contact}}</td>
                                </tr>
                                <tr>
                                    <th>Position</th>
                                    <td>{{is_null($interview->intervieweDetail->position) ? 'NA' : $interview->intervieweDetail->position}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    @if(is_null($interview->user_id))
                    <div class="col-md-6 pull-left">
                        <div class="circle-image-ue">
                            @if(is_null($ueImage->photo) || $ueImage->photo == "")
                                <img src="http://placehold.it/150x150/dddddd/333333?text=NA" class="circle-na">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 pull-right">
                        <table class="table table-condensed">
                            <thead>
                               <tr>
                                   <th colspan="2">Interviewer Details (External)</th>
                               </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td>{{$interview->externalDetail->name}}</td>
                                </tr>
                                <tr>
                                    <th>Organization</th>
                                    <td>{{is_null($interview->externalDetail->organization) ? 'NA' : $interview->externalDetail->organization}}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{$interview->externalDetail->address}}</td>
                                </tr>
                                <tr>
                                    <th>Contact</th>
                                    <td>{{is_null($interview->externalDetail->contact) ? 'NA' : $interview->externalDetail->contact}}</td>
                                </tr>
                                <tr>
                                    <th>Position</th>
                                    <td>{{is_null($interview->externalDetail->position) ? 'NA' : $interview->externalDetail->position}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="col-md-6 pull-left">
                        <div class="circle-image-ue">
                            @if(is_null($ueImage->profile_picture) || $ueImage->profile_picture == "")
                                <img src="http://placehold.it/150x150/dddddd/333333?text=NA" class="circle-na">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 pull-right">
                        <table class="table table-condensed">
                            <thead>
                               <tr>
                                   <th colspan="2">Interviewer Details (Internal)</th>
                               </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Username</th>
                                    <td>{{$interview->user->username}}</td>
                                </tr>
                                <tr>
                                    <th>E-Mail</th>
                                    <td>{{$interview->user->email}}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    @if($interview->user->status == 0)
                                        <td>Inactive</td>
                                    @elseif($interview->user->status == 1)
                                        <td>Active</td>
                                    @else
                                        <td>Pending</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{is_null($interview->user->userInfo->address) ? 'NA' : $interview->user->userInfo->address}}</td>
                                </tr>
                                <tr>
                                    <th>Occupation</th>
                                    <td>{{is_null($interview->user->userInfo->work) || $interview->user->userInfo->work == "" ? 'NA' : $interview->user->userInfo->work}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>                    
            </div>
            <div class="col-md-6 pull-right">
                <h4>Details: </h4>
                <p>{!! $interview->details !!}</p>
            </div>
        </div>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.interview.edit', $interview->id)}}">
            <i class="fa fa-edit"></i> Edit Interview
        </a>
    </div>
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-image"></i> Featured Images: <strong>{{ucwords($interview->title)}}</strong>
    </div>
    <div class="box-body">
        @foreach($interview->featuredImage as $i=>$image)
            <div class="thumbnail col-md-3">
                <img src="{{$image->getImage()}}" class="img-responsive" style="height:100px !important;">
            </div>
        @endforeach
    </div>
</div>
@endsection
