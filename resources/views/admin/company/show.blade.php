@extends('admin.master')

@section('title')
Company
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border row">
        <div class="col-md-3">
            @if(is_null($company->logo) || $company->logo == "")
                <img src="http://placehold.it/150x150/dddddd/333333?text=Logo" class="img-responsive">
            @else
                <img src="{{$company->getImage()}}" class="img-responsive">
            @endif
        </div>
        <div class="col-md-9 row">
            <div class="col-md-12">
                <h2 align="left">{{$company->name}}</h2>
            </div>
            <div class="col-md-12" style="text-align:left">
                {{$company->sector->label}}<br>
                {{$company->details->address}}<br>
                <a href="{{route('admin.company.edit',$company->id)}}" class=" btn btn-primary btn-sm">
                    <i class="fa fa-pencil-square-o"> Edit</i>
                </a>
                <a href="{{route('admin.company.bod.index',$company->id)}}" class=" btn btn-primary btn-sm">
                    <i class="fa fa-user-md"> BOD</i>
                </a>
                <a href="{{route('admin.company.basePrice.index',$company->id)}}" class=" btn btn-primary btn-sm">
                    <i class="fa fa-money"> Base Price</i>
                </a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-10 col-md-offset-1">
            <p>{!! $company->details->profile !!}</p>
        </div>
        
        <div class="row">
            <div class="col-md-6 pull-left">
                <table class="table table-condensed table-hover">
                   <thead>
                   <tr>
                       <th colspan="2">Listed Details</th>
                   </tr>
                   </thead>
                    <tbody>
                    <tr>
                        <th>Quote</th>
                        <td>{{is_null($company->quote) ? 'NA' : $company->quote}}</td>
                    </tr>
                    <tr>
                        <th>Listed Shares</th>
                        <td>{{is_null($company->listed_shares) ? 'NA' : $company->listed_shares}}</td>
                    </tr>
                    <tr>
                        <th>Face Value</th>
                        <td>{{is_null($company->face_value) ? 'NA' : $company->face_value}}</td>
                    </tr>
                    <tr>
                        <th>Listed</th>
                        @if($company->listed == 0)
                            <td>No</td>
                        @else
                            <td>Yes</td>
                        @endif
                    </tr>
                    <tr>
                        <th>RTS</th>
                        @if(is_null($company->details->issueManager))
                            <td>Self</td>
                        @else
                            <td>{{$company->details->issueManager->name}}</td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 pull-right">
                <table class="table table-condensed table-hover">
                   <thead>
                   <tr>
                       <th colspan="2">Contact Details</th>
                   </tr>
                   </thead>
                    <tbody>
                    <tr>
                        <th>Phone</th>
                        <td>{{is_null($company->details->phone) ? 'NA' : $company->details->phone}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{is_null($company->details->email) ? 'NA' : $company->details->email}}</td>
                    </tr>
                    <tr>
                        <th>Web</th>
                        <td>{{is_null($company->details->web) ? 'NA' : $company->details->web}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection