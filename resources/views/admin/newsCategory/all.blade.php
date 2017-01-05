@extends('admin.master')

@section('title')
News Category
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-th-list fa-fw"></i> News Category :List:
        </h3>
        {!! Form::open(['route'=>'admin.newsCategory.store']) !!}
            <div class="input-group clearfix box-header-create">
                {!! Form::text('label',null,['class'=>'form-control','placeholder'=>'Add Category','required'=>'required']) !!}
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-plus"></i> Add
                    </button>
                </span>
            </div>
        {!! Form::close() !!}
    </div><!-- /.box-header -->
    <div class="box-body">
        @include('admin.partials.validation')
        <table class="table">
            <thead>
                <tr>
                    <th style="width:5%;">S.No.</th>
                    <th style="width:80%;">Category</th>
                    <th style="width:15%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter =1; ?>
                @foreach($newsCategory as $category)
                <tr class="edit-row">
                    <td>{{$counter}}</td>
                    <td>{{$category->label}}</td>
                    <td>
                    {!! Form::open(['route'=>['admin.newsCategory.destroy',$category->id],'method'=>'delete']) !!}
                        <button type="button" class="btn btn-primary btn-xs editbtn" data-label="{{$category->label}}" 
                            data-toggle="modal" data-target="#editCategory" 
                            data-url="{{route('admin.newsCategory.update',$category->id)}}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-xs delbtn" data-toggle="modal" 
                            data-target="#deleteNewsCategory">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                    {!! Form::close() !!}
                    </td>               
                </tr>
                <?php $counter++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteNewsCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the selected item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger confirm-delete">
                    <i class="fa fa-trash"></i> Yes
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal-->
<div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'put','id'=>'category_edit']) !!}
                <div class="modal-header">
                    <h4>Edit News Category</h4>
                </div>
                <div class="modal-body">
                    {!! Form::label('label', 'News Category',['class'=>'required']) !!}
                        {!! Form::text('label',old('label'),['class'=>'form-control','id'=>'category_label','required'=>'required']) !!}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-edit"></i> Update
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('endscript')
<script type="text/javascript">
    
    $(document).on('click','.editbtn',function(){
        label = $(this).data('label');
        url = $(this).data('url');
        $('#category_label').attr('value',label);
        $('#category_edit').attr('action',url);
    });
    
    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteNewsCategory');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection