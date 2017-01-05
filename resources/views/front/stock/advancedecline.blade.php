@extends('front.main')

@section('title')
    Stock : Advance/Decline
@endsection

@section('specificheader')
@endsection

@section('content')
    <section class="main-content col-md-9">
        <div class="row">
            <div class="col-sm-12">
                <div id="chart-container" class="chart-container" style="width:100%; height:400px;"></div>
                <div id="ratio-chart-container" class="chart-container" style="width:100%; height:400px;"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <p>The latest advance decline coounts within the last month are listed:</p>
                <table class="table datatable advancedecline table-striped table-condensed table-responsive with-border" width="100%">
                    <thead>
                        <tr>
                            <th class="hidden-sm hidden-xs">SN</th>
                            <th>Date</th>
                            <th>Advance</th>
                            <th>Decline</th>
                            <th>Ratio</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
@endsection
@section('endscript')
    <script type="text/javascript">
        var advanceDeclineUrl = "{{route('api-get-advance-decline')}}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/highstock.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/modules/exporting.js" type="text/javascript"></script>
    {!! HTML::script('assets/nsm/front/js/advancdDecline.js') !!}
@endsection