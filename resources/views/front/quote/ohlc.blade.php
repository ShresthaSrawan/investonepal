<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Technical Analysis | {{$company->name}}</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    {!! HTML::style('assets/nsm/front/css/technical.css') !!}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>
</head>
<body>

<div style="background:rgba(240,240,240,0.5);position:fixed; width:100%; height:100%; z-index:1000; display:none"
     id="backdrop">
    <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>
<div id="watermark"><h1>{{strtoupper($company->quote)}}</h1></div>
<div class="navbar yamm navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle"><span
                        class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            <a href="{{url('/')}}" class="navbar-brand">InvestoNepal</a>
        </div>
        <div id="navbar-collapse-1" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{route('quote',$company->quote)}}">{{strtoupper($company->quote)}}</a></li>
                <li><a href="{{ route('technical-analysis', $company->quote) }}">Line Chart</i></a></li>
            </ul>
            {!! Form::open(['route'=>'technical-analysis-index','id'=>'index-search-form','class'=>'navbar-form navbar-right']) !!}
            <div class="form-group">
                <select name="index" id="index"
                        class="search-index-selector-nav search-select form-control"
                        required="required" placeholder="Select Index" style="height:28px">
                    <option value="" selected>Select Index</option>
                    @foreach($indexTypes as $in)
                        <option value="{{$in->id}}">{{strtoupper($in->name)}}</option>
                    @endforeach
                </select>
            </div>
            {!! Form::close() !!}
            {!! Form::open(['route'=>'technical-analysis','id'=>'company-search-form','class'=>'navbar-form navbar-right']) !!}
            <div class="form-group">
                <select name="quote" id="quote"
                        class="search-company-selector-nav search-select form-control"
                        required="required" placeholder="Select Company/Quote" style="width:200px">
                </select>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <span id="company-ohlcv" style="height:90%;width:95%;"></span>
        </div>
    </div>
</div>
<script type="text/javascript">
    var ohlcURL = "{{route('api-get-company-close',[$company->id,1])}}";
    var getTodaysPriceOHLCURL = '{{route("api-get-todays-price-ohlc")}}';
    var quote = "{{$company->quote}}";
    var id = "{{$company->id}}";
    var c_name = "{{$company->name}}";
    var searchCompanyUrl = "{{route('api-search-company')}}";
    var is_index = false;
    var lastDate = "{{$lastDate}}";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"
        type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/highstock.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highstock/2.1.8/modules/exporting.js"
        type="text/javascript"></script>
{!! HTML::script('vendors/highstock/js/technical-indicators.src.js') !!}
{!! HTML::script('vendors/highstock/js/annotations.js') !!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
{!! HTML::script('vendors/highstock/js/highstock.darkunica.js') !!}
{!! HTML::script('assets/nsm/front/js/technical.ohlc.js') !!}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>
</html>