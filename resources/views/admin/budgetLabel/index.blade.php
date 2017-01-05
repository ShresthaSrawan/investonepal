@extends('admin.master')

@section('title')
Budget Label
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-tags fa-fw"></i> Budget Labels :List:
        </h3>
        {!! Form::open(['route' => 'admin.budgetLabel.store']) !!}
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th colspan="2"><h3><i class="fa fa-plus-square"></i> Budget Label :Create:</h3></th>
                    </tr>
                    @include('admin.partials.validation')
                    <tr>
                        <th style="width:60%;">Label</th>
                        <th style="width:30%;">Type</th>
                        <th style="width:10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {!! Form::text('label',old('label'),['class'=>'form-control','placeholder'=>'Budget Label','required'=>'required']) !!}
                        </td>
                        <td>
                            {!! Form::select('type',['0'=>'Source','1'=>'Expense'],null, ['class'=>'form-control','required'=>'required']) !!}
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
                <a href="#" onclick="showBudgetSource()" id="showBSBtn">Source Labels</a>
            </li>
            <li role="presentation">
                <a href="#" onclick="showBudgetExpense()" id="showBEBtn">Expense Labels</a>
            </li>
        </ul>
        </br>
        <div id='budgetSource'>
            <table class="table datatable">
                <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 75%;">Label</th>
                    <th style="width: 10%;">Action</th>
                    <th style="width: 10%;">Sub Type</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter=0; ?>
                @foreach($budgetLabel::whereType('0')->get() as $label)
                <tr>
                    <td>{{++$counter}}</td>
                    <td>{{$label->label}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-primary edit-label" data-toggle="modal" 
                        data-target="#editBudgetLabel" data-id="{{$label->id}}" data-label="{{$label->label}}"
                        data-type="{{$label->type}}" data-url="{{route('admin.budgetLabel.update',$label->id)}}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger delete-label" data-toggle="modal" 
                        data-target="#deleteBudgetLabel" data-id="{{$label->id}}" data-url="{{route('admin.budgetLabel.destroy',$label->id)}}">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                    <td>
                        <a href="{{route('admin.budgetLabel.budgetSubLabel.index',$label->id)}}" class="btn btn-default btn-xs">
                            <i class="fa fa-plus-square"></i> Add
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id='budgetExpense'>
            <table class="table datatable">
                <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 75%;">Label</th>
                    <th style="width: 10%;">Action</th>
                    <th style="width: 10%;">Sub Type</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter=0; ?>
                @foreach($budgetLabel::whereType('1')->get() as $label)
                <tr>
                    <td>{{++$counter}}</td>
                    <td>{{$label->label}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-primary edit-label" data-toggle="modal" 
                        data-target="#editBudgetLabel" data-id="{{$label->id}}" data-label="{{$label->label}}"
                        data-type="{{$label->type}}" data-url="{{route('admin.budgetLabel.update',$label->id)}}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger delete-label" data-toggle="modal" 
                        data-target="#deleteBudgetLabel" data-id="{{$label->id}}" data-url="{{route('admin.budgetLabel.destroy',$label->id)}}">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                    <td>
                        <a href="{{route('admin.budgetLabel.budgetSubLabel.index',$label->id)}}" class="btn btn-default btn-xs">
                            <i class="fa fa-plus-square"></i> Add
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="col-md-4">
    <div class="modal fade" id="deleteBudgetLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                <form class="form" id="budgetLabel-delete" method="post">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" value="{{csrf_token()}}" name="_token">
                        <input type="hidden" name="id" id="budget-id">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="form-submit">
                        <i class="fa fa-trash-o"></i> Delete
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editBudgetLabel" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Budget Label</h4>
            </div>
            <form class="form" id="budgetLabel-update" method="post">
                <div class="modal-body">
                    <input type="hidden" name="_method" value="put">
                    <input type="text" name="label" id="budget-label" class="form-control">
                    <input type="hidden" value="{{csrf_token()}}" name="_token">
                    <input type="hidden" name="type" id="budget-type">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="form-submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('endscript')
<script type="text/javascript">
    //Edit Label Script
    $('.edit-label').on('click',function(){
        label = $(this).data('label');
        id = $(this).data('id');
        type = $(this).data('type');
        url = $(this).data('url');
        $('#budget-type').val(type);
        $('#budget-label').val(label);
        $('#budgetLabel-update').attr('action',url);
    });

    //Delete Label Script
    $('.delete-label').on('click',function(){
        id = $(this).data('id');
        url = $(this).data('url');
        $('#budget-id').val(id);
        $('#budgetLabel-delete').attr('action',url);
    });

    $(document).ready(function(){
        $('.datatable').DataTable();
        showBudgetSource();
    });

function showBudgetSource () {
    $('#budgetSource').show();
    $('#showBSBtn').parent().addClass('active');

    $('#budgetExpense').hide();
    $('#showBEBtn').parent().removeClass('active');
}
function showBudgetExpense () {
    $('#budgetExpense').show();
    $('#showBEBtn').parent().addClass('active');

    $('#budgetSource').hide();
    $('#showBSBtn').parent().removeClass('active');
}
</script>
@endsection