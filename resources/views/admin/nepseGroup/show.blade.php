@extends('admin.master')

@section('title')
Nepse Group
@endsection

@section('content')
{!! Form::open(['route' =>'nepseGroup.db']) !!}
<div class="box box-info">
    <div class="box-header with-border">
        <h4 style="font-size: 25px; font-weight: 400">
            <i class="fa fa-file"></i> Nepse Group :Excel:
        </h4>
        @include ('admin.partials.validation')
        <div class="form-group">
            <div class="col-lg-12">
                {!! Form::label('fiscal_year_id', 'Fiscal Year',['class'=>'control-label required']) !!}
                {!! Form::select('fiscal_year_id',$fiscalYear,old('fiscal_year_id'),['class'=>'form-control ']) !!}
            </div>
        </div>
        <div class="box-tools pull-right">
            {!! Form::submit('Add to DB',['class'=>'btn btn-primary pull-right disabled addtodb','disabled'=>true]) !!}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th style="width:75%">Company</th>
                    <th style="width:20%">Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter=0; ?>
                @foreach($data['matched'] as $id=>$grade)
                    <tr>
                        <td>{{++$counter}}</td>
                        <td>{!! Form::select('company['.$id.']',$company,$id, ['class'=>'form-control','required'=>'required']) !!}</td>
                        <td>{!! Form::input('text','grade['.$id.']',$grade,['class'=>'form-control','required'=>'','style'=>'text-transform:uppercase;']) !!}</td>
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
                <a type="button" class="btn btn-default " onclick="window.location.reload(true);">
                    <i class="fa fa-refresh"></i> Refresh
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('endscript')
    <script type="text/javascript">
        var companys = {!! json_encode($data['unknown']) !!};

        $(document).ready(function(){
            if(companys.length>0){
                showAddLabels(companys);
            } else {
                $('.addtodb').removeClass('disabled').prop('disabled',false);
            }
        });

        function showAddLabels(companys)
        {
            htmlTag = "";
            htmlTag += "<div class='row'><div class='col-sm-12'><h4>The following report labels do not exist in the database. Add the following labels before adding balancesheet.</h4></div></div>";
            htmlTag += "<div class='row'><div class='col-sm-12'>";
            for(i=0;i<companys.length;i++)
            {
                htmlTag += "<a href='{{route('company.create')}}/"+companys[i]+"' target='_blank' class='btn btn-primary'>"+companys[i]+"</a>";
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