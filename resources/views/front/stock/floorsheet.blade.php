@extends('front.main')

@section('specificheader')
<style type="text/css">
    #mydatatable{
        width: auto !important;
    }
    input {
        width: 100% !important;
        padding: 5px 8px;
    }
    #dateWrap, #lengthWrap{
        width: 50%;
    }
    #lengthWrap{
        text-align: right;
    }
</style>
@endsection

@section('title')
    Stock : Floorsheet
@endsection

@section('content')
<section class="main-content col-md-9 col-xs-12">
    <div class="row no-margin" style="padding-top:10px;">
        <div class="pull-left" id="mydate">
            <div class="form-group">
                <div class='input-group date datepicker'>
                    <input type='text' class="form-control searchdate" value="" id="date" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row no-margin">
        <div class="col-sm-12">
            <table class="table table-condensed datatable responsive display table-striped with-border no-wrap" id="mydatatable">
                <thead>
                    <tr id="filterrow">
                        <th width="10%"></th>
                        <th width="40%">
                            <input type="text" class="quote" onclick="stopPropagation(event);" placeholder="Quote" value="" />
                        </th>
                        <th width="40%">
                            <input type="text" class="company" onclick="stopPropagation(event);" placeholder="Company" value="" />
                        </th>
                        <th>
                            <input type="text" class="buyer_broker" onclick="stopPropagation(event);" placeholder="Buyer" value="" />
                        </th>
                        <th>
                            <input type="text" class="seller_broker" onclick="stopPropagation(event);" placeholder="Seller" value="" />
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>SN</th>
                        <th>Quote</th>
                        <th>Company Name</th>
                        <th>Buyer</th>
                        <th>Seller</th>
                        <th><abbr title="Quantity">Qty.</abbr></th>
                        <th>Rate</th>
                        <th><abbr title="Amount">Amt</abbr></th>
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
    var floorsheetURL = "{{route('api-get-floorsheet')}}";
	var lastDate = "{{$lastDate}}";
    var table;
</script>
    {!! HTML::script('assets/nsm/front/js/floorsheet.js') !!}
@endsection