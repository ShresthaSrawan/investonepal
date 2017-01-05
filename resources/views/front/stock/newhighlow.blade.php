@extends('front.main')

@section('title')
    Stock : New High Low
@endsection

@section('specificheader')
@endsection

@section('content')
    <section class="main-content col-md-9">
        <div class="row" style="padding-top:10px;">
            <div class="col-sm-6">
                <label for="date" class="control-label">New High Low as of:</label>
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
                <li role="presentation" class="active"><a id="newhi" href="#newhigh" aria-controls="newhigh" role="tab" data-toggle="tab">New High</a></li>
                <li role="presentation"><a id="newlo" href="#newlow" aria-controls="newlow" role="tab" data-toggle="tab">New Low</a></li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="newhigh">
                    <table class="table table condensed datatable newhigh">
                    <thead>
                        <tr>
                            <th width="10%">SN</th>
                            <th width="60%">Name</th>
                            <th width="30%">New High</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="newlow">
                    <table class="table table condensed datatable newlow">
                        <thead>
                            <tr>
                                <th width="10%">SN</th>
                                <th width="60%">Name</th>
                                <th width="30%">New Low</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
              </div>
            </div>
        </div>
    </section>
@endsection
@section('endscript')
    <script type="text/javascript">
    var newHighURL = "{{route('api-get-new-high')}}";
    var newLowURL = "{{route('api-get-new-low')}}";
	var lastDate = "{{$lastDate}}"
    </script>
    {!! HTML::script('assets/nsm/front/js/newHighLow.js') !!}
@endsection