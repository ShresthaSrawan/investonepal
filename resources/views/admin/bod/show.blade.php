@extends('admin.master')

@section('title')
BOD
@endsection

@section('specificheader')
<style>
    .circle-image{
    width:200px !important;
    height:200px !important;
    border-radius:50% !important;
    background-image:url("{{$bod->getImage()}}");
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
        <div class="row">
            <div class="col-md-3">
                <div class="circle-image"> 
                    @if(is_null($bod->photo) || $bod->photo == "")
                        <img src="http://placehold.it/150x150/dddddd/333333?text=Photo" class="img-responsive">
                    @endif
                </div>
            </div>
            <div class="col-md-9" style="text-align:left">
                <h2>{{$bod->name}}</br>
                    {{ucwords($company->name)}}</br>
                    {{ucwords($bod->bodPost->label)}}</br>
                    
                </h2>
                <a href="{{route('admin.company.bod.edit',['cid'=>$bod->company->id, 'bid'=>$bod->id])}}" class="pull-right btn btn-primary btn-sm">
                    <i class="fa fa-pencil-square-o"> Edit</i>
                </a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <p>{{$bod->profile}}</p>
            </div>

            <div class="col-md-4 col-md-offset-4">
                <table class="table table-condensed table-hover">
                   <thead>
                       <tr>
                           <th><center>Fiscal Year</center></th>
                       </tr>
                   </thead>
                    <tbody>
                        @foreach($bod->bodFiscalYear as $bodFiscalYear)
                            <tr>
                                <td><center>{{$bodFiscalYear->fiscalYear->label}}</center></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <a href="{{route('admin.company.bod.edit',['cid'=>$bod->company->id, 'bid'=>$bod->id])}}" 
            class=" btn btn-primary btn-sm pull-right">
            <i class="fa fa-pencil-square-o"> Edit</i>
        </a>
    </div>
</div> 
@endsection
