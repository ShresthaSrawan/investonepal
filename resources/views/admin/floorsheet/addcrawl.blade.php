@extends('admin.master')

@section('title')
    Floorsheet
@endsection

@section('content')
    <?php $ourFields = ['SN','Transaction No','Stock Symbol','Buyer Broker','Seller Broker','Quantity','Rate','Amount']; $counter=0; ?>
    <form id="mapform">
    <input type="hidden" id="floorsheetDate" value="{{date('Y-m-d')}}">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-file-text"></i> Floorsheet :Match Headers:</h3>
            <div class="pull-right">
                <label for="date" class="md-date-label">Date</label>
                <input type="date" value="{{$date}}" class="form-control md-date-input" id="date">
            </div>
        </div>
        <div class="box-body">
            <div class="row col-lg-8 col-lg-offset-2">
                <div class="col-sm-3"><h4>Database Fields</h4></div>
                <div class="col-sm-9"><h4>Crawled Fields</h4></div>
            </div>
            @foreach($headers as $val => $header)
                <div class="row col-lg-8 col-lg-offset-2" style="margin-bottom:2px;">
                    <div class="col-sm-3" style="text-align:center; padding: 2px 0">
                        {{$ourFields[$counter]}}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::select(str_replace(' ', '_', strtolower($ourFields[$counter])),$headers,$val,['class'=>'form-control']) !!}
                    </div>
                </div>
                <?php $counter++;?>
            @endforeach
        </div>
        <div class="box-footer clearfix">
            <button class="btn btn-primary btn-sm btn-flat pull-right fetch" type="button">
                Next <i class="fa fa-forward"></i>
            </button>
        </div>
    </div>
    </form>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="dialog-header"></h4>
            </div>
            <div class="modal-body">
                <div id="dialog-icon"></div>
                <h4 id="dialog-message"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('endscript')
    <script type="text/javascript">
        var previousform;
        $(document).on('click','button.fetch',function(){
            console.log('attempting');
            btn = $(this);
            $.ajax({
                type: 'POST',
                url: '{{route("admin.floorsheet-crawler")}}',
                beforeSend: function(){
                    btn.button('loading');
                },
                data: $('#mapform').serialize(),
                success: function(response) {
                    btn.button('reset');
                    console.log(response);
                    if(response!=0)
                    {
                        if(response.summary!=null)
                        {
                            showSummary(response.summary);
                        } else if(response.unknown!=null)
                        {
                            showAddCompanies(response.unknown);
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    btn.button('reset');
                }
            });
        });
        $(document).on('click','button.finish',function(){
            console.log('finalizing');
            btn = $(this);
            $.ajax({
                type: 'POST',
                url: '{{route("admin.floorsheet-updateAll")}}',
                beforeSend: function(){
                    btn.button('loading');
                },
                data:{date:$('#date').val()},
                success: function(response) {
                    btn.button('reset');
                    if(response!=0)
                    {
                        html = " <div class='row'>\
                        <center><h1 class='btn btn-success'>All Good to go!!</h1></center>";
                        $('.box-body').html(html);
                        $('.box-footer button').remove();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    btn.button('reset');
                }
            });
        });
        function showSummary(summary)
        {
            html = " <div class='row col-lg-8 col-lg-offset-2'>\
                        <div class='col-sm-3'><h4>Details</h4></div>\
                        <div class='col-sm-9'><h4>Values</h4></div>\
                    </div>\
                    <div class='row col-lg-8 col-lg-offset-2'>\
                        <div class='col-sm-3'>Total Transactions</div>\
                     <div class='col-sm-9'>"+summary.nofTransactions+"</div>\
                    </div>\
                    <div class='row col-lg-8 col-lg-offset-2'>\
                        <div class='col-sm-3'>Total Companies</div>\
                     <div class='col-sm-9'>"+summary.nofCompanies+"</div>\
                    </div>\
                    <div class='row col-lg-8 col-lg-offset-2'>\
                        <div class='col-sm-3'>Total Quantity</div>\
                     <div class='col-sm-9'>"+summary.totalQuantity+"</div>\
                    </div>\
                    <div class='row col-lg-8 col-lg-offset-2'>\
                        <div class='col-sm-3'>Total Amount</div>\
                     <div class='col-sm-9'>"+summary.totalAmount+"</div>\
                    </div>";
            $('.box-body').html(html);
            $('.box-footer button').removeClass('fetch').addClass('finish').text('Finish');
        }

        function showAddCompanies(companies)
        {
            htmlTag = "";
            htmlTag += "<div class='row'><div class='col-sm-12'><h4>The following companies does not exist in the database. Add the following companies before updating the floorsheet.</h4></div></div>";
            htmlTag += "<div class='row'><div class='col-sm-12'>";
            for(i=0;i<companies.length;i++)
            {
                htmlTag += "<a href='{{route('admin.company.create')}}/"+companies[i]+"' target='_blank' class='btn btn-primary'>"+companies[i]+"</a>";
            }
            htmlTag +="</h4></div></div>";
            $('#dialog-header').html("Unknown Companies");
            $('#dialog-icon').html("<i class='fa fa-exclamation-triangle'></i> ");
            $('#dialog-message').html(htmlTag);
            $('#dialog').modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    </script>
@endsection