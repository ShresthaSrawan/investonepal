@extends('front.main')

@section('title')
    Stock : Last Traded Price
@endsection

@section('specificheader')
<style type="text/css">
    .datatable{
        width: 100% !important;
    }
</style>
@endsection

@section('content')
<section class="main-content col-md-12 col-xs-12">
    <div class="row" style="padding-top:10px;">
        <div id="sector-selector">
            <div class="form-group">
                <div class='input-group'>
                    <span class="input-group-addon">
                        <span>Sector:</span>
                    </span>
                    {!! Form::select('sector',['0'=>'All']+$sectorList,0,['class'=>'sector form-control','id'=>'sector']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row no-margin">
        <div class="col-sm-12">
            <table class="table datatable with-border table-condensed table-hover table-striped" id="lastprice">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Quote</th>
                    <th>Company Name</th>
                    <th>Close Price</th>
                    <th>Date</th>
                    <th>Listed Share</th>
                    <th>Paid Up Value</th>
                    <th>Market Cap.</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>
@endsection
@section('endscript')
    <script type="text/javascript">
        var lastpriceURL = "{{route('api-get-latest-traded-price')}}";
        var table;
    </script>
    {!! HTML::script('assets/nsm/front/js/lastTradedPrice.js') !!}
@endsection