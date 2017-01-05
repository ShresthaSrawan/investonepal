@extends('admin.master')

@section('title')
Balance Sheet
@endsection

@section('content')
{!! Form::open(['route' =>['admin.financialReport.db',$financialReport->id,$type]]) !!}
<div class="box box-info">
    <div class="box-header with-border">
        <table class="table-condensed borderless">
            <thead>
                <th style="font-size: 25px; font-weight: 400">
                    <i class="fa fa-file"></i> Financial Report :Excel:
                </th>
            </thead>
            <tbody>
                <tr>
                    <th>Company</th>
                    <td>: {{ucwords($financialReport->company->name)}}</td>
                </tr>
                <tr>
                    <th>Fiscal Year</th>
                    <td>: {{($financialReport->fiscalYear->label)}}</td>
                </tr>
                <tr>
                    <th>Quarter</th>
                    <td>: {{($financialReport->quarter->label)}}</td>
                </tr>
                <tr>
                    <th>Sector</th>
                    <td>: {{ucwords($financialReport->company->sector->label)}}</td>
                </tr>
                <tr>
                    <th>Report Type</th>
                    <td>
                        @if($type=='bs')
                            : Balance Sheet
                        @elseif($type=='pl')
                            : Profit Loss
                        @elseif($type=='pi')
                            : Principal Indicators
                        @elseif($type=='is')
                            : Income Statement
                        @elseif($type=='cr')
                            : Consolidate Revenue Account
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="box-tools pull-right">
            {!! Form::submit('Add to DB',['class'=>'btn btn-primary pull-right disabled addtodb','disabled'=>true]) !!}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th style="width:75%">Report Label</th>
                    <th style="width:20%">Value</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter=0; ?>
                @foreach($data['matched'] as $id=>$val)
                    <tr>
                        <td>{{++$counter}}</td>
                        <td>{!! Form::select('label['.$id.']',$allLabels,$id, ['class'=>'form-control','required'=>'required']) !!}</td>
                        <td>{!! Form::input('number','value['.$id.']',$val,['class'=>'form-control','required'=>'']) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        {!! Form::submit('Add to DB',['class'=>'btn btn-primary pull-right disabled addtodb','disabled'=>true]) !!}
    </div>
</div>
{!! Form::close() !!}

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
                <a type="button" class="btn btn-default " onclick="window.location.reload(true);"><i class="fa fa-refresh"></i> Refresh</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('endscript')
    <script type="text/javascript">
        var reportLabels = {!! json_encode($data['unknown']) !!};

        $(document).ready(function(){
            if(reportLabels.length>0){
                showAddLabels(reportLabels);
            } else {
                $('.addtodb').removeClass('disabled').prop('disabled',false);
            }
        });

        function showAddLabels(reportLabels)
        {
            htmlTag = "";
            htmlTag += "<div class='row'><div class='col-sm-12'><h4>The following report labels do not exist in the database. Add the following labels before adding balancesheet.</h4></div></div>";
            htmlTag += "<div class='row'><div class='col-sm-12'>";
            for(i=0;i<reportLabels.length;i++)
            {
                htmlTag += "<a href='{{route('admin.reportLabel.index')}}/"+reportLabels[i]+"/{{$type}}' target='_blank' class='btn btn-primary'>"+reportLabels[i]+"</a>";
            }
            htmlTag +="</h4></div></div>";
            $('#dialog-header').html("Unknown Report Labels");
            $('#dialog-icon').html("<i class='fa fa-exclamation-triangle'></i> ");
            $('#dialog-message').html(htmlTag);
            $('#dialog').modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    </script>
@endsection