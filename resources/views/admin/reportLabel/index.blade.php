@extends('admin.master')

@section('title')
Report Label
@endsection

@section('content')
@include('admin.partials.validation')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-tags fa-fw"></i> Report Labels :List:
        </h3>
        {!! Form::open(['route' => 'admin.reportLabel.store']) !!}
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th colspan="2"><h3><i class="fa fa-plus-square"></i> Report Label :Create:</h3></th>
                    </tr>
                    <tr>
                        <th style="width:60%;">Label</th>
                        <th style="width:30%;">Type</th>
                        <th style="width:10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {!! Form::text('label',old('label'),['class'=>'form-control','placeholder'=>'Report Label','required'=>'required']) !!}
                        </td>
                        <td>
                            {!! Form::select('type',['bs'=>'Balance Sheet','pl'=>'Profit Loss','pi'=>'Principal Indicators','cr'=>'Consolidate Revenue Account','is'=>'Income Statement'],null, ['class'=>'form-control','required'=>'required']) !!}
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fa fa-plus-square"></i> Create
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        {!! Form::close() !!}
    </div>
    <div class="box-body nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active">
                <a href="#" onclick="showBalanceSheet()" id="showBSBtn">Balance Sheet</a>
            </li>
            <li role="presentation">
                <a href="#" onclick="showProfitLoss()" id="showPLBtn">Profit Loss</a>
            </li>
            <li role="presentation">
                <a href="#" onclick="showPrincipalIndicators()" id="showPIBtn">Principal Indicators</a>
            </li>
            <li role="presentation">
                <a href="#" onclick="showIncomeStatement()" id="showISBtn">Income Statement</a>
            </li>
            <li role="presentation">
                <a href="#" onclick="showConsolidateRevenue()" id="showCRBtn">Consolidate Revenue Account</a>
            </li>
        </ul>
        </br>
        <div id='balanceSheet'>
            <table class="table datatable">
                <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 85%;">Label</th>
                    <th style="width: 10%;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter=0; ?>
                @foreach($reportLabel::whereType('bs')->get() as $label)
                <tr>
                    <td>{{++$counter}}</td>
                    <td>{{$label->label}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-primary edit-label" data-toggle="modal" 
                        data-target="#editReportLabel" data-id="{{$label->id}}" data-label="{{$label->label}}"
                        data-type="{{$label->type}}" data-url="{{route('admin.reportLabel.update',$label->id)}}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger delete-label" data-toggle="modal" 
                        data-target="#deleteReportLabel" data-id="{{$label->id}}" data-type="{{$label->type}}"
                        data-url="{{route('admin.reportLabel.destroy',$label->id)}}">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id='profitLoss'>
            <table class="table datatable">
                <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 85%;">Label</th>
                    <th style="width: 10%;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter=0; ?>
                @foreach($reportLabel::whereType('pl')->get() as $label)
                <tr>
                    <td>{{++$counter}}</td>
                    <td>{{$label->label}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-primary edit-label" data-toggle="modal" 
                        data-target="#editReportLabel" data-id="{{$label->id}}" data-label="{{$label->label}}"
                        data-type="{{$label->type}}" data-url="{{route('admin.reportLabel.update',$label->id)}}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger delete-label" data-toggle="modal" 
                        data-target="#deleteReportLabel" data-id="{{$label->id}}" data-type="{{$label->type}}"
                        data-url="{{route('admin.reportLabel.destroy',$label->id)}}">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id='principalIndicators'>
            <table class="table datatable">
                <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 85%;">Label</th>
                    <th style="width: 10%;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter=0; ?>
                @foreach($reportLabel::whereType('pi')->get() as $label)
                <tr>
                    <td>{{++$counter}}</td>
                    <td>{{$label->label}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-primary edit-label" data-toggle="modal" 
                        data-target="#editReportLabel" data-id="{{$label->id}}" data-label="{{$label->label}}"
                        data-type="{{$label->type}}" data-url="{{route('admin.reportLabel.update',$label->id)}}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger delete-label" data-toggle="modal" 
                        data-target="#deleteReportLabel" data-id="{{$label->id}}" data-type="{{$label->type}}"
                        data-url="{{route('admin.reportLabel.destroy',$label->id)}}">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id='incomeStatement'>
            <table class="table datatable">
                <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 85%;">Label</th>
                    <th style="width: 10%;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter=0; ?>
                @foreach($reportLabel::whereType('is')->get() as $label)
                <tr>
                    <td>{{++$counter}}</td>
                    <td>{{$label->label}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-primary edit-label" data-toggle="modal" 
                        data-target="#editReportLabel" data-id="{{$label->id}}" data-label="{{$label->label}}"
                        data-type="{{$label->type}}" data-url="{{route('admin.reportLabel.update',$label->id)}}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger delete-label" data-toggle="modal" 
                        data-target="#deleteReportLabel" data-id="{{$label->id}}" data-type="{{$label->type}}"
                        data-url="{{route('admin.reportLabel.destroy',$label->id)}}">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id='consolidateRevenue'>
            <table class="table datatable">
                <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 85%;">Label</th>
                    <th style="width: 10%;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter=0; ?>
                @foreach($reportLabel::whereType('cr')->get() as $label)
                <tr>
                    <td>{{++$counter}}</td>
                    <td>{{$label->label}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-primary edit-label" data-toggle="modal" 
                        data-target="#editReportLabel" data-id="{{$label->id}}" data-label="{{$label->label}}"
                        data-type="{{$label->type}}" data-url="{{route('admin.reportLabel.update',$label->id)}}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger delete-label" data-toggle="modal" 
                        data-target="#deleteReportLabel" data-id="{{$label->id}}" data-type="{{$label->type}}"
                        data-url="{{route('admin.reportLabel.destroy',$label->id)}}">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Modal-->
<div class="col-md-4">
    <div class="modal fade" id="deleteReportLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
                <form class="form" id="reportLabel-delete" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" value="{{csrf_token()}}" name="_token">
                        <input type="hidden" name="id" id="report-id">
                        <input type="hidden" name="type" id="report-type">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="form-submit">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal-->
<div class="modal fade" id="editReportLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'put','id'=>'reportLabel_edit']) !!}
            <div class="modal-header">
            <h4>Edit Report Label</h4>
            </div>
            <div class="modal-body">
                {!! Form::label('label', 'Report Label',['class'=>'required']) !!}
                    {!! Form::text('label',null,['class'=>'form-control','id'=>'report_label','required'=>'required']) !!}
                    {!! Form::hidden('type',null,['id'=>'report_type']) !!}
                    {!! Form::hidden('_token',csrf_token()) !!}
            </div>
            <div class="modal-footer">
                {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
@section('endscript')
<script type="text/javascript">
    $(document).ready(function(){
        @if(Session::has('label'))
                $('[name="label"]').val('{{Session::pull("label")}}');
        @endif
        @if(Session::has('type'))
                $('[name="type"]').val('{{Session::pull("type")}}');
        @endif
    });

    //Edit Label Script
    $('.edit-label').on('click',function(){
        label = $(this).data('label');
        id = $(this).data('id');
        type = $(this).data('type');
        url = $(this).data('url');
        $('#report_type').val(type);
        $('#report_label').val(label);
        $('#reportLabel_edit').attr('action',url);

    });

    //Delete Label Script
    $('.delete-label').on('click',function(){
        id = $(this).data('id');
        url = $(this).data('url');
        type = $(this).data('type');
        $('#report-id').val(id);
        $('#report-type').val(type);
        $('#reportLabel-delete').attr('action',url);
    });

    $(document).ready(function(){
        $('.datatable').DataTable({
			paging:false,
		});
        showBalanceSheet();
    });

    function showBalanceSheet () {
        $('#balanceSheet').show();
        $('#showBSBtn').parent().addClass('active');

        $('#incomeStatement').hide();
        $('#showISBtn').parent().removeClass('active');

        $('#profitLoss').hide();
        $('#showPLBtn').parent().removeClass('active');

        $('#principalIndicators').hide();
        $('#showPIBtn').parent().removeClass('active');

        $('#consolidateRevenue').hide();
        $('#showCRBtn').parent().removeClass('active');
    }
    function showIncomeStatement () {
        $('#incomeStatement').show();
        $('#showISBtn').parent().addClass('active');

        $('#balanceSheet').hide();
        $('#showBSBtn').parent().removeClass('active');

        $('#profitLoss').hide();
        $('#showPLBtn').parent().removeClass('active');

        $('#principalIndicators').hide();
        $('#showPIBtn').parent().removeClass('active');

        $('#consolidateRevenue').hide();
        $('#showCRBtn').parent().removeClass('active');
    }
    function showConsolidateRevenue () {
        $('#consolidateRevenue').show();
        $('#showCRBtn').parent().addClass('active');

        $('#balanceSheet').hide();
        $('#showBSBtn').parent().removeClass('active');

        $('#incomeStatement').hide();
        $('#showISBtn').parent().removeClass('active');

        $('#profitLoss').hide();
        $('#showPLBtn').parent().removeClass('active');

        $('#principalIndicators').hide();
        $('#showPIBtn').parent().removeClass('active');
    }
    function showProfitLoss () {
        $('#profitLoss').show();
        $('#showPLBtn').parent().addClass('active');

        $('#balanceSheet').hide();
        $('#showBSBtn').parent().removeClass('active');

        $('#incomeStatement').hide();
        $('#showISBtn').parent().removeClass('active');

        $('#consolidateRevenue').hide();
        $('#showCRBtn').parent().removeClass('active');

        $('#principalIndicators').hide();
        $('#showPIBtn').parent().removeClass('active');
    }
    function showPrincipalIndicators () {
        $('#principalIndicators').show();
        $('#showPIBtn').parent().addClass('active');

        $('#profitLoss').hide();
        $('#showPLBtn').parent().removeClass('active');

        $('#balanceSheet').hide();
        $('#showBSBtn').parent().removeClass('active');

        $('#incomeStatement').hide();
        $('#showISBtn').parent().removeClass('active');

        $('#consolidateRevenue').hide();
        $('#showCRBtn').parent().removeClass('active');
    }
</script>
@endsection