<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Technical Analysis | {{$index->name}}</title>
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
<div id="watermark"><h1>{{strtoupper($index->name)}}</h1></div>
<div class="navbar yamm navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle"><span
                        class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            <a href="{{url('/')}}" class="navbar-brand">InvestoNepal</a>
        </div>
        <div id="navbar-collapse-1" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{route('stock','index')}}">{{strtoupper($index->name)}}</a></li>
                <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Indicators<b
                                class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="yamm-content">
                                <div class="row">
                                    <div id="indicatorAccordion" class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <input type="checkbox" value="" onchange="updateChart()"
                                                           id="sma">
                                                    <a data-toggle="collapse" data-parent="#indicatorAccordion"
                                                       href="#sma_acc" aria-expanded="false">Simple Mean Average
                                                        (SMA)</a>
                                                </h4>
                                            </div>
                                            <div id="sma_acc" class="panel-collapse collapse">
                                                <div class="panel-body row">
                                                    <div class="form-group col-xs-7 col-xs-offset-1">
                                                        <label for="preiod_sma" class="control-label">Period</label>
                                                        <input type='number' min="0" max="50" step="1"
                                                               onchange="updateChart()" value="14" id="period_sma"
                                                               class="form-control">
                                                    </div>
                                                    <div class="form-group col-xs-3">
                                                        <label class="control-label">Line Weight</label>

                                                        <div class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-xs btn-primary active">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_sma" autocomplete="off"
                                                                       value="-1" checked> 1
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_sma" autocomplete="off"
                                                                       value="1"> 2
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_sma" autocomplete="off"
                                                                       value="2"> 3
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <input type="checkbox" value="" onchange="updateChart()"
                                                           id="ema">
                                                    <a data-toggle="collapse" data-parent="#indicatorAccordion"
                                                       href="#ema_acc">Exponential Moving Average (EMA)</a>
                                                </h4>
                                            </div>
                                            <div id="ema_acc" class="panel-collapse collapse">
                                                <div class="panel-body row">
                                                    <div class="form-group col-xs-7 col-xs-offset-1">
                                                        <label for="std_devs_ema"
                                                               class="control-label">Period</label>
                                                        <input type='number' min="0" max="50" step="1"
                                                               onchange="updateChart()" value="14" id="period_ema"
                                                               class="form-control">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label class="control-label">Line Weight</label>

                                                        <div class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-xs btn-primary active">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_ema" autocomplete="off"
                                                                       value="-1" checked> 1
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_ema" autocomplete="off"
                                                                       value="1"> 2
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_ema" autocomplete="off"
                                                                       value="2"> 3
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <input type="checkbox" value="" onchange="updateChart()"
                                                           id="macd">
                                                    <a data-toggle="collapse" data-parent="#indicatorAccordion"
                                                       href="#macd_acc">Moving Average Convergence Divergence
                                                        (MACD)</a>
                                                </h4>
                                            </div>
                                            <div id="macd_acc" class="panel-collapse collapse">
                                                <div class="panel-body row">
                                                    <div class="form-group col-xs-4 col-xs-offset-1">
                                                        <label class="control-label">Show\Hide</label>

                                                        <div class="btn-group">
                                                            <label class="btn btn-default btn-xs">
                                                                <input type="checkbox" value=""
                                                                       onchange="updateChart()" id="signal"
                                                                       autocomplete="off" checked> Signal Line
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-xs-3">
                                                        <label class="control-label">Show\Hide</label>

                                                        <div class="btn-group">
                                                            <label class="btn btn-default btn-xs">
                                                                <input type="checkbox" value=""
                                                                       onchange="updateChart()" id="histogram"
                                                                       autocomplete="off" checked> Histogram
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-xs-3">
                                                        <label class="control-label">Line Weight</label>

                                                        <div class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-xs btn-primary active">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_macd" autocomplete="off"
                                                                       value="-1" checked> 1
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_macd" autocomplete="off"
                                                                       value="1"> 2
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_macd" autocomplete="off"
                                                                       value="2"> 3
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <input type="checkbox" value="" onchange="updateChart()"
                                                           id="bollinger">
                                                    <a data-toggle="collapse" data-parent="#indicatorAccordion"
                                                       href="#bollinger_acc">Bollinger Bands (BB)</a>
                                                </h4>
                                            </div>
                                            <div id="bollinger_acc" class="panel-collapse collapse">
                                                <div class="panel-body row">
                                                    <div class="form-group col-xs-4 col-xs-offset-1">
                                                        <label for="preiod_bol" class="control-label">Period</label>
                                                        <input type='number' min="0" max="50" step="1"
                                                               onchange="updateChart()" value="14" id="period_bol"
                                                               class="form-control">
                                                    </div>
                                                    <div class="form-group col-xs-3">
                                                        <label for="std_devs_bol" class="control-label">Std
                                                            Dev</label>
                                                        <input type='number' min="0" max="50" step="1"
                                                               onchange="updateChart()" value="2" id="std_devs_bol"
                                                               class="form-control">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label class="control-label">Line Weight</label>

                                                        <div class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-xs btn-primary active">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_bol" autocomplete="off"
                                                                       value="-1" checked> 1
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_bol" autocomplete="off"
                                                                       value="1"> 2
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_bol" autocomplete="off"
                                                                       value="2"> 3
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <input type="checkbox" value="" onchange="updateChart()"
                                                           id="rsi">
                                                    <a data-toggle="collapse" data-parent="#indicatorAccordion"
                                                       href="#rsi_acc">Relative Strength Index (RSI)</a>
                                                </h4>
                                            </div>
                                            <div id="rsi_acc" class="panel-collapse collapse">
                                                <div class="panel-body row">
                                                    <div class="form-group col-xs-7 col-xs-offset-1">
                                                        <label for="std_devs_rsi"
                                                               class="control-label">Period</label>
                                                        <input type='number' min="0" max="50" step="1"
                                                               onchange="updateChart()" value="14" id="period_rsi"
                                                               class="form-control">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label class="control-label">Line Weight</label>

                                                        <div class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-xs btn-primary active">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_rsi" autocomplete="off"
                                                                       value="1" checked> 1
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_rsi" autocomplete="off"
                                                                       value="2"> 2
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_rsi" autocomplete="off"
                                                                       value="3"> 3
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <input type="checkbox" value="" onchange="updateChart()"
                                                           id="stoch">
                                                    <a data-toggle="collapse" data-parent="#indicatorAccordion"
                                                       href="#stoch_acc">Stochastic Oscillator</a>
                                                </h4>
                                            </div>
                                            <div id="stoch_acc" class="panel-collapse collapse">
                                                <div class="panel-body row">
                                                    <div class="form-group col-xs-4 col-xs-offset-1">
                                                        <div class="btn-group">
                                                            <label for="period_k_stoch" class="control-label">%K
                                                                Period</label>
                                                            <input type='number' min="0" max="50" step="1"
                                                                   onchange="updateChart()" value="14"
                                                                   id="period_k_stoch" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-xs-3">
                                                        <div class="btn-group">
                                                            <label for="period_d_stoch" class="control-label">%D
                                                                Period</label>
                                                            <input type='number' min="0" max="50" step="1"
                                                                   onchange="updateChart()" value="3"
                                                                   id="period_d_stoch" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label class="control-label">Line Weight</label>

                                                        <div class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-xs btn-primary active">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_stoch" autocomplete="off"
                                                                       value="-1" checked> 1
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_stoch" autocomplete="off"
                                                                       value="1"> 2
                                                            </label>
                                                            <label class="btn btn-xs btn-primary">
                                                                <input type="radio" class="thickness"
                                                                       name="thickness_stoch" autocomplete="off"
                                                                       value="2"> 3
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Classic dropdown -->
                <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Tools<b
                                class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li>
                            <label for="annotations">
                                <input type="checkbox" value="" onchange="updateChart()" id="annotations" checked>
                                Annotations
                            </label>
                        </li>
                        <li>
                            <label for="crosshair">
                                <input type="checkbox" value="" onchange="updateChart()" id="crosshair" checked>
                                Crosshairs
                            </label>
                        </li>
                        <li>
                            <label for="fixed_tooltip">
                                <input type="checkbox" value="" onchange="updateChart()" id="fixed_tooltip">
                                Fixed Tooltip
                            </label>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#" id="clean-all"><i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clean
                            </a></li>
                    </ul>
                </li>
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
            <span id="analysis" style="height:90%;width:95%;"></span>
        </div>
    </div>
</div>
<script type="text/javascript">
    var ohlcURL = "{{route('api-get-index-close',[$index->id])}}";
    var id = "{{$index->id}}";
    var i_name = "{{$index->name}}";
    var is_index = true;
    var searchCompanyUrl = "{{route('api-search-company')}}";
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
{!! HTML::script('assets/nsm/front/js/technical.js') !!}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>
</html>