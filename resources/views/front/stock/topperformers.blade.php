@extends('front.main')

@section('title')
    Stock : Gainer Loser Active
@endsection

@section('specificheader')
<style type="text/css">
    table td:nth-child(n+3){
        text-align: right;
    }
</style>
@endsection

@section('content')
    <section class="main-content col-md-9">
        <div class="row" style="padding-top:10px;">
            <div class="col-sm-6">
                <label for="data" class="control-label">Data as of:</label>
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
        <div class="row">
            <div class="col-sm-12">
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a id="gain" href="#gainer" aria-controls="gainer" role="tab" data-toggle="tab">Gainer</a></li>
                    <li role="presentation"><a id="loss" href="#loser" aria-controls="loser" role="tab" data-toggle="tab">Loser</a></li>
                    <li role="presentation"><a id="perform" href="#top-performer" aria-controls="top-performer" role="tab" data-toggle="tab">Top Performer</a></li>
                </ul>

            <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="gainer">
                        <table class="table table-condensed with-border gainer table-hover table-striped datatable table-responsive"  width="100%">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Quote</th>
                                <th>Company</th>
                                <th><abbr title="Transaction Count">Tran.</abbr></th>
                                <th>Closing</th>
                                <th><abbr title="Traded Shares">Shares</abbr></th>
                                <th class="text-right">Amount</th>
                                <th><abbr title="Previous Closing">Prev.</abbr></th>
                                <th>Change</th>
                                <th><abbr title="Change Percentage">%</abbr></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="loser">
                        <table class="datatable table-responsive table table-condensed with-border loser table-hover table-striped" width="100%">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Quote</th>
                                <th>Company</th>
                                <th><abbr title="Transaction Count">Tran.</abbr></th>
                                <th>Closing</th>
                                <th><abbr title="Traded Shares">Shares</abbr></th>
                                <th class="text-right">Amount</th>
                                <th><abbr title="Previous Closing">Prev.</abbr></th>
                                <th>Change</th>
                                <th><abbr title="Change Percentage">%</abbr></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="top-performer">
                        <table class="datatable table-responsive table mostactive table-condensed with-border table-hover table-striped" width="100%">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Quote</th>
                                <th>Company</th>
                                <th><abbr title="Transaction Count">Tran.</abbr></th>
                                <th>Closing</th>
                                <th><abbr title="Traded Shares">Shares</abbr></th>
                                <th class="text-right">Amount</th>
                                <th><abbr title="Previous Closing">Prev.</abbr></th>
                                <th>Change</th>
                                <th><abbr title="Change Percentage">%</abbr></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>                    
            </div>
        </div>
    </section>
@endsection
@section('endscript')
    <script type="text/javascript">
    	var gainerURL = "{{route('api-get-gainer')}}";
    	var loserURL = "{{route('api-get-loser')}}";
    	var activeURL = "{{route('api-get-active')}}";
		var lastDate = "{{$lastDate}}";
        var table1, table2,table3;
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/highstock.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/modules/exporting.js" type="text/javascript"></script>
    {!! HTML::script('assets/nsm/front/js/topPerformer.js') !!}
@endsection