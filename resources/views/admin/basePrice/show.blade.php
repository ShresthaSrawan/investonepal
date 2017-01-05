@extends('admin.master')

@section('title')
Base Price
@endsection

@section('specificheader')
<style type="text/css">
    .input-group{
        margin-bottom:5px; 
        width:100%;
    }
    .input-group-addon{
        width: 100px;
    }
</style>
@endsection

@section('content')
@include('admin.partials.errors')

<div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-money fa-fw"></i> Base Price :Summary:</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-xs-12">
                    <div class="input-group date datetimepicker">
                        <span class="input-group-addon"><strong>Entry Date: </strong></span>
                        {!! Form::input('date','date',date('Y-m-d'),['class'=>'form-control','id'=>'date'])!!}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><strong>Fiscal Year: </strong></span>
                        {!! Form::select('fiscalYear',$fiscalYear,count($fiscalYear),['class'=>'form-control','id'=>'fiscalYear'])!!}
                    </div>
                </div>
            </div>
            <h3>
                <center>Total Number of Price: {{$summary['nofPrice']}}</center>
            </h3>
        </div>
        <div class="box-footer">
            {!! Form::input('button','button','Add to DB',['class'=>'btn btn-primary addtodb disabled pull-right'])!!}
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

<div class="box box-primary list">
    <div class="box-header with-border list">
        <h3 class="box-title list">
            <i class="fa fa-money fa-fw"></i> Base Price :List:
        </h3>
    </div>

    <div class="panel-body list">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Fiscal Year</th>
                    <th>Company</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allBasePrice as $price)
                    <tr>
                        <td>{{$price->date}}</td>
                        <td>{{$price->fiscalYear->label}}</td>
                        <td>{{$price->company->quote}}</td>
                        <td>{{$price->price}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

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
            $('.datatable').DataTable({
                order : [[0,'desc']]
            });
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
                url: '{{route("admin.basePrice.db")}}',
                beforeSend: function(){
                    btn.button('loading');
                },
                data: {
                    date: $('#date').val(),
                    fiscalYear : $('#fiscalYear').val()
                },
                success: function(response) {
                    btn.button('reset');
                    if(response!=0)
                    {
                        html = " <div class='row'>\
                        <div class='col-sm-6 col-sm-offset-3'><h4>Base price have been added.</h4></div>";
                        $('.box-body').html(html);
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
            htmlTag += "<div class='row'><div class='col-sm-12'><h4>The following companies do not exist in the database. Add the following companies before updating the floorsheet.</h4></div></div>";
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