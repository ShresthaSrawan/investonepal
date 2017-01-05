@extends('admin.master')

@section('title')
Budget Sub Label
@endsection

@section('specificheader')
<style>
    .deletebtn{
        color: #E66565;
        font-weight: bold;
    }

    .deletebtn:hover,.deletebtn:focus{
        color: #E66565;
        font-weight: bold;
    }

    .deletebtn > span{
        color: rgb(80, 80, 80);
        font-weight: normal;
        font-style: italic;
        display: none;
    }
</style>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h4><strong>{{ucwords($budgetLabel->label)}}</strong>: Sub Label</h4>
        <ul class="nav nav-pills" id="menu">
            <li role="presentation" class="active" onclick="subLabel.showAll()" data-menu="show"><a href="#"><i class="fa fa-eye"></i> Show</a></li>
            <li role="presentation" onclick="subLabel.showCreate()" data-menu="create"><a href="#"><i class="fa fa-plus"></i> Create</a></li>
        </ul>
    </div>
    <div class="box-body">
        <div data-view="show">
            <table class="table datatable">
                <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 85%;">Label</th>
                    <th style="width: 10%;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter = 0; ?>
                @foreach($budgetLabel->subLabel as $subLabel)
                    <tr>
                        <td>{{++$counter}}</td>
                        <td>{{$subLabel->label}}</td>
                        <td>
                            {!! Form::open(['route'=>['admin.budgetLabel.budgetSubLabel.destroy',$subLabel->id]]) !!}
                                <button type="button" class="btn btn-xs btn-primary editbtn" data-toggle="modal" 
                                data-target="#editSubLabel" data-id="{{$subLabel->id}}" data-label="{{$subLabel->label}}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-xs delbtn" 
                                data-toggle="modal" data-target="#deleteBudgetLabel">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div data-view="create">
            {!! Form::open(array('route' => ['admin.budgetLabel.budgetSubLabel.store',$budgetLabel->id],'class'=>'form-horizontal'))!!}
                <div class="form-group">
                    {!! Form::label('label', 'Label',['class'=>'col-lg-2 control-label required']) !!}
                    <div class="col-lg-9">
                        {!! Form::text('label',old('label'),['class'=>'form-control','placeholder'=>'Sub Label','required'=>'']) !!}
                    </div>
                    @if($errors->has('label'))
                        <span class="text-danger col-lg-9 col-lg-offset-2">{{$errors->first('label')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> Create</button></span>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="editSubLabel" tabindex="-1" role="dialog" aria-labelledby="EditSubLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Budget Sub Label</h4>
            </div>
            <form class="form" id="subLabel-update" method="post">
                <div class="modal-body">
                    <input type="text" name="label" id="budget-label" class="form-control" required>
                    <input type="hidden" value="{{csrf_token()}}" name="_token">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="form-submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteBudgetLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the selected item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger confirm-delete">
                    <i class="fa fa-trash"></i> Yes
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('endscript')
<script>
    $(document).ready(function(){
        $('.datatable').DataTable();
        subLabel.showAll();
    });

    $('.editbtn').on('click',function(){
        label = $(this).data('label');
        id = $(this).data('id');
        url = '{{route('admin.budgetLabel.budgetSubLabel.update')}}/'+id;
        $('#budget-label').val(label);
        $('#budget-id').val(id);
        $('#subLabel-update').attr('action',url);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteBudgetLabel');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });

var subLabel = {
    menu : {
        show: $('[data-menu="show"]'),
        create: $('[data-menu="create"]')
    },
    view: {
        show: $('[data-view="show"]'),
        create: $('[data-view="create"]'),
    },
    showAll : function(){
        this.menu.show.addClass('active');
        this.menu.create.removeClass('active');

        this.view.show.removeClass('hide');
        this.view.create.addClass('hide');
    },

    showCreate : function(){
        this.menu.create.addClass('active');
        this.menu.show.removeClass('active');

        this.view.create.removeClass('hide');
        this.view.show.addClass('hide');
    },

    showEdit: function(){
        this.menu.create.removeClass('active');
        this.menu.show.removeClass('active');

        this.view.create.addClass('hide');
        this.view.show.addClass('hide');
    }
}
</script>
@endsection