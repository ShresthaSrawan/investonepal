@extends('admin.master')

@section('title')
Article
@endsection

@section('specificheader')
    <style>
        <?php $ueImage = "";
            if(is_null($article->externalDetail)):
                $ueImage = $article->user;
            else:
                $ueImage = $article->externalDetail;
            endif;
        ?>

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
                    <i class="fa fa-file-text"></i> Article :Show:
                    @if(is_null($article->user_id))
                        External
                    @else
                        Internal
                    @endif
                </th>
            </thead>
            <tbody>
                <tr>
                    <th>Title</th>
                    <td>: {{ucwords($article->title)}}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>: {{$article->category->label}}</td>
                </tr>
                    @if(ucwords($article->category->label) == "Bullion")
                        <tr>
                            <th>Bullion Type</th>
                            <td>: {{$article->bullionType->name}}</td>
                    @elseif(ucwords($article->category->label) == "Stock")
                            <th>Company</th>
                            <td>: {{is_null($article->company) ? 'NA' : $article->company->name}}</td>
                        </tr>
                    @endif
                <tr>
                    <th>Date Created</th>
                    <td>: {{$article->pub_date}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                       @if($article->status==0)
                            : Draft
                        @else
                            : Published
                        @endif 
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.article.edit', $article->id)}}">
                <i class="fa fa-edit"></i> Edit Article
            </a>
        </div>        
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6 pull-left">
                <div class="row">
                    @if(is_null($article->user_id))
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
                                   <th colspan="2">Writer Details (External)</th>
                               </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td>{{$article->externalDetail->name}}</td>
                                </tr>
                                <tr>
                                    <th>Organization</th>
                                    <td>{{is_null($article->externalDetail->organization) ? 'NA' : $article->externalDetail->organization}}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{$article->externalDetail->address}}</td>
                                </tr>
                                <tr>
                                    <th>Contact</th>
                                    <td>{{is_null($article->externalDetail->contact) ? 'NA' : $article->externalDetail->contact}}</td>
                                </tr>
                                <tr>
                                    <th>Position</th>
                                    <td>{{is_null($article->externalDetail->position) ? 'NA' : $article->externalDetail->position}}</td>
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
                                   <th colspan="2">Writer Details (Internal)</th>
                               </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Username</th>
                                    <td>{{$article->user->username}}</td>
                                </tr>
                                <tr>
                                    <th>E-Mail</th>
                                    <td>{{$article->user->email}}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    @if($article->user->status == 0)
                                        <td>Inactive</td>
                                    @elseif($article->user->status == 1)
                                        <td>Active</td>
                                    @else
                                        <td>Pending</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{is_null($article->user->userInfo->address) ? 'NA' : $article->user->userInfo->address}}</td>
                                </tr>
                                <tr>
                                    <th>Occupation</th>
                                    <td>{{is_null($article->user->userInfo->work) || $article->user->userInfo->work == "" ? 'NA' : $article->user->userInfo->work}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>                    
            </div>
            <div class="col-md-6 pull-right">
                <h4>Details: </h4>
                <p>{!! $article->details !!}</p>
            </div>
        </div>
    </div>
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.article.edit', $article->id)}}">
            <i class="fa fa-edit"></i> Edit Article
        </a>
    </div>
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-image"></i> Featured Images: <strong>{{ucwords($article->title)}}</strong>
    </div>
    <div class="box-body">
        @foreach($article->featuredImage as $i=>$image)
            <div class="thumbnail col-md-3">
                <img src="{{$image->getImage()}}" class="img-responsive" style="height:100px !important;">
            </div>
        @endforeach
    </div>
</div>
@endsection