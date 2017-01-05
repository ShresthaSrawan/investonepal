@extends('admin.master')

@section('title')
Base Price
@endsection

@section('content')
@include('admin.partials.errors')

<div class="box box-info">
    <div class="box-header with-border">
        <h4><strong>{{$company->name}}</strong>: Base Price :List:</h4>
    </div>
    <div class="box-body">
        <div class="row">
            {!! Form::open(['route' => ['admin.company.basePrice.store', $company->id]]) !!}
            <div class="col-md-12">
                <div class="input-group">
                    <div class="row">
                        <div class="col-md-4">
                            {!! Form::text('price',old('basePrice'),['class'=>'form-control','placeholder'=>'Base Price','required'=>'required']) !!}
                        </div>
                        <div class="col-md-3">
                            <?php $date = (is_null(old('date'))) ? date('Y-m-d') : old('date'); ?>
                            {!! Form::input('date','date',$date,['class'=>'form-control','required'=>'required']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::select('fiscalYear_id',$fiscalYear,old('fiscalYear_id'),['class'=>'form-control','required'=>'required']) !!}
                        </div>
                        <div class="col-md-2">
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-plus"></i> Create</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div></br>
        <table class="table datatable">
            <thead>
                <tr>
                    <th class='col-sm-1'>S.No.</th>
                    <th class='col-sm-2'>Date</th>
                    <th class='col-sm-3'>Fiscal Year</th>
                    <th class='col-sm-4'>Base Price</th>
                    <th class='col-sm-2'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter =1; ?>
                @if(isset($company->basePrice))
                @foreach($company->basePrice as $basePrice)
                <tr>
                    <td>{{$counter}}</td>
                    <td>{{$basePrice->date}}</td>
                    <td>{{$basePrice->fiscalYear->label}}</td>
                    <td>{{$basePrice->price}}</td>
                    <td>
                        {!! Form::open(['route'=>['admin.company.basePrice.destroy','cid'=>$basePrice->company->id,'bid'=>$basePrice->id],'method'=>'delete']) !!}
                            <button type="button" class="btn btn-primary btn-xs editbtn" data-toggle="modal" data-target="#editBasePrice"
                            data-url="{{route('admin.company.basePrice.update',['cid'=>$basePrice->company->id,'bid'=>$basePrice->id])}}"
                            data-date="{{$basePrice->date}}" data-price="{{$basePrice->price}}">
                                <i class="glyphicon glyphicon-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-xs delbtn" data-toggle="modal" data-target="#deleteBasePrice">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                <?php $counter++; ?>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Update Modal-->
<div class="modal fade" id="editBasePrice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'put','id'=>'basePrice_edit']) !!}
            <div class="modal-header">
                <h4>Edit Base Price</h4>
            </div>
            <div class="modal-body">
                @if(isset($company->basePrice))
                    {!! Form::label('price', 'Base Price',['class'=>'required']) !!}
                    {!! Form::input('number','price',null,['step'=>'any','class'=>'form-control','id'=>'base_price','required'=>'required']) !!}
                @endif

            </div>
            <div class="modal-footer">
                {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteBasePrice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
    
    $(document).ready(function(){
        $(document).on('click','.editbtn',function(){
            var price = $(this).data('price');
            var date = $(this).data('date');
            var url = $(this).data('url');

            $('#base_price').val(price);
            $('#base_date').val(date);
            $('#basePrice_edit').attr('action',url)
        });
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteBasePrice');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection
