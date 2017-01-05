@extends('admin.master')

@section('title')
Budget
@endsection

<?php $budgetID = []; ?>
@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-file"></i> Budget Expense :Edit:
        </h3>
        <h3 class="box-title pull-right">
            <i class="fa fa-calendar"></i> Fiscal Year: {{$fiscalYear->label}}
        </h3>
    </div>
    <div class="box-body">
        <div class="form-group">
            <label class="sr-only">Budget Label</label>
            <div class="input-group col-lg-10 col-lg-offset-1">
                {!! Form::select('budgetLabel',$budgetLabel,null,['class'=>'form-control budgetLabel'])!!}
                <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="showSubLabel"><i class="fa fa-plus"></i> Add</button>
            </span>
            </div>
        </div>
        {!! Form::open(['route'=>['admin.fiscalYear.budget.update',$fiscalYear->id,$type],'class'=>'form form-horizontal','method'=>'put']) !!}
        <div class="col-md-12">
            <div class="subLabelPlaceHolder">
                @if($fiscalYear->hasType($type))
                    @foreach($fiscalYear->budget as $i => $budget)
                        @if(!$budget->budgetLabel->subLabel->isEmpty() && $budget->budgetLabel->type == $type)
                            <?php
                            $budgetID[] = $budget->label_id;
                            $subValueCount = count($budget->budgetLabel->subLabel->toArray());
                            ?>
                            @foreach($budget->budgetLabel->subLabel as $i=>$subLabel)
                                @if($i == 0)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">{{$budget->budgetLabel->label}}
                                            <button class="btn btn-xs pull-right total-budget" type="button" data-class="budget{{$budget->id}}">
                                                Total: NRS.<code>{{$budget->value}}</code>
                                            </button>
                                        </div>
                                        <div class="panel-body">
                                @endif
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="subLabel[{{$subLabel->id}}]">{{$subLabel->label}}</label>
                                                <div class="input-group col-lg-7">
                                                    <?php
                                                    $subLabelVal = $subLabel->getSubValue($budget->id);
                                                    $subLabelVal = is_null($subLabelVal) ? NULL : $subLabelVal->value;
                                                    ?>
                                                    <input type="number" class="form-control budget{{$budget->id}}" name="value[{{$budget->id}}][{{$subLabel->id}}]" step="any" data-id="{{$budget->id}}" value="{{$subLabelVal}}" {{is_null($subLabelVal) ? 'disabled' : ''}}>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default removeSubLabel" type="button" id="showSubLabel"><i class="fa {{is_null($subLabelVal) ? 'fa-plus' : 'fa-remove'}}"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                @if($i == $subValueCount-1)
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="budgetLabelPlaceHolder">
                @if($fiscalYear->hasType($type))
                    <?php
                    $expenseCount = count($fiscalYear->budget->toArray()) - 1;
                    $counter = 0;
                    ?>
                    @foreach($fiscalYear->budget as $i => $budget)
                        @if($budget->subValue->isEmpty() && $budget->budgetLabel->type == $type)
                            <?php $budgetID[] = $budget->label_id; ?>
                            @if($counter == 0)
                                <div class="panel panel-default">
                                    <div class="panel-heading">Budget Label without Sub Labels</div>
                                    <div class="panel-body" id="budgetLabelPanel">
                                        @endif
                                        <div class="form-group" id="budget{{$budget->id}}">
                                            <label class="control-label col-lg-3">{{$budget->budgetLabel->label}}</label>
                                            <div class="input-group col-lg-8">
                                                <input type="number" class="form-control" name="budgetTotal[{{$budget->budgetLabel->id}}]" step="any" value="{{$budget->value}}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default removeSubLabel" type="button" id="showSubLabel"><i class="fa fa-remove"></i></button>
                                        </span>
                                            </div>
                                        </div>
                                        @if($counter == $expenseCount-1)
                                    </div></div>
                            @endif
                            <?php $counter++; ?>
                        @else
                            <?php $expenseCount--; ?>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="budgetSubmitPlaceHolder">
                <div class="form-group">
                    <div class="input-group col-lg-10 col-lg-offset-1">
                        <button type="submit" id="updateBudget" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Update</button>
                    </div>
                </div>
            </div>
            {!! Form::close () !!}
        </div>
    </div>
</div>

@endsection
<?php
foreach($budgetID as $i=>$v){
    $budgetID[$i] = "{$v}";
}
?>

@section('endscript')
    <script>
        var budgetLabelSearchUrl = "{{route('admin.api-search-budgetLabel')}}";
        var budgetID = {!! json_encode($budgetID) !!};
    </script>
    {!! HTML::script('/assets/nsm/admin/js/budget.js') !!}
@endsection