@extends('admin.master')

@section('title')
User
@endsection

@section('specificheader')
<style>
    .circle-image{
    margin-left: 40px;
    width:200px !important;
    height:200px !important;
    border-radius:50% !important;
    background-image:url("{{$user->getImage()}}");
    display:block !important;
    background-position-y:25% !important;
    background-size: cover;
    background-repeat: no-repeat;
    box-shadow: 0px 0px 8px 1px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <div class="row">
            <div class="circle-image col-md-3">
                @if(is_null($user->profile_picture) || $user->profile_picture == "")
                    <img src="http://placehold.it/150x150/dddddd/333333?text=NA" class="img-responsive">
                @endif
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <h2 align="right">{{$user->userInfo->first_name}} {{$user->userInfo->last_name}}</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-9" style="text-align:right">
                        <h4>{{$user->userType->label}}<br>
                        {{$user->userInfo->phone}}<br></h4>
                        <a href="{{route('admin.user.edit',$user->id)}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square-o"> Edit</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-6 col-md-offset-3">
            <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th colspan="2"><center>User Details</center></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Username</th>
                        <td>{{$user->username}}</td>
                    </tr>
                    <tr>
                        <th>E-Mail</th>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        @if($user->status == 0)
                            <td>Inactive</td>
                        @elseif($user->status == 1)
                            <td>Active</td>
                        @else
                            <td>Pending</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Expiry Date</th>
                        <td>{{$user->expiry_date}}</td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td>{{$user->userInfo->dob}}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{is_null($user->userInfo->address) ? 'NA' : $user->userInfo->address}}</td>
                    </tr>
                    <tr>
                        <th>Occupation</th>
                        <td>{{is_null($user->userInfo->work) || $user->userInfo->work == "" ? 'NA' : $user->userInfo->work}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection