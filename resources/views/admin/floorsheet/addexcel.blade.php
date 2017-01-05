@extends('admin.master')
@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="panel-title">Summary of Data</h3>
                        </div>
                        <div class="col-sm-6">
                            <a class="btn btn-primary pull-right" href="{{route('admin.addFloorsheet')}}">Upload New Excel</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            <button type="button" class="btn md-date-label">Floorsheet Data as of ::</button>
                        </div>
                        <div class="col-md-7">
                            {!! Form::input('date','date',$summary['date'],['class'=>'form-control md-date-input','id'=>'date'])!!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Summary of Floorsheet</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Total Number of Transactions</div>
                        <div class="col-md-3">{{$summary['nofTransactions']}}</div>
                        <div class="col-md-3">Total Quantity</div>
                        <div class="col-md-3">{{$summary['totalQuantity']}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Total Number of Companies</div>
                        <div class="col-md-3">{{$summary['nofCompanies']}}</div>
                        <div class="col-md-3">Total Amount</div>
                        <div class="col-md-3">{{$summary['totalAmount'] }}</div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            {!! Form::input('button','','Add to DB',['class'=>'btn btn-primary addtodb disabled pull-right'])!!}
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    {!! Form::close() !!}
@endsection
@section('endscript')
    <script type="text/javascript">
        var companys = [
            <?php
                foreach($summary['unknownCompanies'] as $key => $val)
                {
                    echo "'$val'".',';
                }
            ?>
        ];
        $(document).ready(function(){
            if(companys.length>0){
                showAddCompanies(companys);

            } else {
                $('.addtodb').removeClass('disabled');
            }
        });
        $('.addtodb').on('click',function(){
            var btn = $(this);
            $.ajax({
                type: 'POST',
                url: '{{route("admin.floorsheet-updateAll")}}',
                beforeSend: function(){
                    btn.button('loading');
                },
                data: {date:$('#date').val()},
                success: function(response) {
                    console.log(response);
                    btn.button('reset');
                    if(response==1)
                    {
                        html = " <div class='row'>\
                        <div class='col-sm-6 col-sm-offset-3'><h4>All Good to go!!</h4></div>";
                        $('.panel-body').html(html);
                        btn.removeClass('addtodb').removeClass('btn-default').addClass('btn-success').text('Done');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    btn.button('reset');
                }
            });
        });
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