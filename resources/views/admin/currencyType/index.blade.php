
@extends('admin.master')

@section('title')
Currency Type
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-th-list fa-fw"></i> Currency Type :Add:
        </h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.currencyType.create')}}">
            <i class="fa fa-plus fa-fw"></i> Add 
        </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th class='col-sm-1'>S.No.</th>
                    <th class='col-sm-3'>Country Name</th>
                    <th class='col-sm-3'>name</th>
                    <th class='col-sm-2'>Unit</th>
                    <th class='col-sm-2'>Flag</th>
                    <th class='col-sm-3'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter =1; ?>
                @foreach($currencyTypes as $currencyType)
               
                <tr>
                    <td>{{$counter}}</td>
                    @if($currencyType->country_name!=null)
                    	<td>{{$currencyType->country_name}}</td>
					@else
						<td>Not Available</td>
					@endif
                    
                    <td>{{$currencyType->name}}</td>
                    <td>{{$currencyType->unit}}</td>
                    @if($currencyType->country_flag!=null)
                    	<td><div class="thumbnail"><img src="{{$currencyType->getImage()}}"></div></td>
					@else
						<td>Not Available</td>
					@endif
					
                    <td>
                        {!! Form::open(['route'=>['admin.currencyType.destroy',$currencyType->id],'method'=>'delete']) !!}
                        	<a href="{{route('admin.currencyType.edit',$currencyType->id)}}" class="btn btn-primary btn-xs editbtn">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                            
                            <button type="button" class="btn btn-danger btn-xs delbtn" 
                            data-toggle="modal" data-target="#deleteCurrencyType">
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
<div class="modal fade" id="deleteCurrencyType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
<script type="text/javascript">
    $(document).ready(function(){
        $('.datatable').DataTable();
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteCurrencyType');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
