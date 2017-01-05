@extends('admin.master')

@section('title')
Brokerage Firm
@endsection

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-building fa-fw"></i> Brokerage Firm :List:</h3>
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.brokerageFirm.create')}}">
            <i class="fa fa-plus fa-fw"></i> Add Brokerage Firm
        </a>
    </div>
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th class='col-sm-1'>S.No.</th>
                    <th class='col-sm-2'>Code</th>
                    <th class='col-sm-4'>Firm Name</th>
                    <th class='col-sm-4'>Director Name</th>
                    <th class='col-sm-1'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter =1; ?>
                @foreach($brokerageFirms as $brokerageFirm)
                    <tr class="edit-row">
                        <td>{{$counter}}</td>
                        <td>{{ucwords($brokerageFirm->code)}}</td>
                        <td>{{ucwords($brokerageFirm->firm_name)}}</td>
                        <td>{{ucwords($brokerageFirm->director_name)}}</td>
                        <td>
                            {!! Form::open(['route'=>['admin.brokerageFirm.destroy',$brokerageFirm->id],'method'=>'delete']) !!}
                                <button type="button" class="btn btn-primary btn-xs detailsbtn"
                                   data-firmname="{{ucwords($brokerageFirm->firm_name)}}"
                                   data-directorname="{{ucwords($brokerageFirm->director_name)}}"
                                   data-address="{{ucwords($brokerageFirm->address)}}"
                                   data-phone="{{$brokerageFirm->phone}}" 
                                   data-mobile="{{$brokerageFirm->mobile}}"
                                   data-photo="{{$brokerageFirm->getImage()}}"
                                   data-url="{{route('admin.brokerageFirm.edit',$brokerageFirm->id)}}"
                                   data-code="{{$brokerageFirm->code}}" data-toggle="modal" data-target="#viewBrokerageFirm">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-xs delbtn" 
                                    data-toggle="modal" data-target="#deleteBrokerageFirm">
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
    <div class="box-footer clearfix">
        <a class="btn btn-primary btn-sm btn-flat pull-right" href="{{route('admin.brokerageFirm.create')}}">
            <i class="fa fa-plus fa-fw"></i> Add Brokerage Firm
        </a>
    </div>
</div>

<!-- View Modal-->
<div class="modal fade" id="viewBrokerageFirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Brokerage Firm Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <img src="" id="brokerageFirm_photo" class="img-responsive"></br>
        
                        <table class="table table-condensed table-hover">
                           <thead>
                               <tr>
                                   <th>Field</th>
                                   <th>Value</th>
                               </tr>
                           </thead>
                            <tbody>
                                <tr>
                                    <td>Code</td>
                                    <td id="brokerageFirm_code"></td>
                                </tr>
                                <tr>
                                    <td>Firm Name</td>
                                    <td id="brokerageFirm_firmName"></td>
                                </tr>
                                <tr>
                                    <td>Director Name</td>
                                    <td id="brokerageFirm_directorName"></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td id="brokerageFirm_address"></td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td id="brokerageFirm_phone"></td>
                                </tr>
                                <tr>
                                    <td>Mobile</td>
                                    <td id="brokerageFirm_mobile"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>

            <div class="modal-footer">
                <a href="#" class="btn btn-primary editLink"><i class="fa fa-pencil-square-o"></i> Edit</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteBrokerageFirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

    $(document).on('click','.detailsbtn',function(){
        var firmName = $(this).data('firmname');
        var directorName = $(this).data('directorname');
        var address = $(this).data('address');
        var phone = $(this).data('phone');
        var code = $(this).data('code');
        var mobile = $(this).data('mobile');
        var photo = $(this).data('photo');
        var url = $(this).data('url');

        $('#brokerageFirm_firmName').html(firmName);
        $('#brokerageFirm_directorName').html(directorName ? directorName : 'NA');
        $('#brokerageFirm_address').html(address ? address : 'NA');
        $('#brokerageFirm_phone').html(phone ? phone : 'NA');
        $('#brokerageFirm_mobile').html(mobile ? mobile : 'NA');
        $('#brokerageFirm_code').html(code);
        $('#brokerageFirm_photo').prop('src',photo ? photo : '');
        $('.editLink').prop('href',url);
    });

    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteBrokerageFirm');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection