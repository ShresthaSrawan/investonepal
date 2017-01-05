@extends('admin.master')

@section('title')
    Floorsheet
@endsection

@section('content')
@include('admin.partials.alerts')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-file-text"></i> Floorsheet :Show:</h3>
        <div class="box-tools">
            <div class="form-group">
                <div class="input-group col-sm-2 pull-right">
                    <input type="date" class="form-control mydate">
                    <div class="input-group-btn">
                        <a href="{{route('admin.floorsheet',date('Y/m/d'))}}" class="form-control btn btn-primary go" value="GO">GO</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="box box-deafult">
            <div class="box-body">
                @if(count($floorsheetData->toArray())>0)
                    <div class="col-sm-6 col-sm-offset-3">
                        <h4 class="pull-left"><i class="fa fa-bookmark-o"></i> Summary of Floorsheet</h4>
						<span class="pull-right">
							{!! Form::open(['route'=>['admin.deleteFloorsheet',$date],'class'=>'form-horizontal'])!!}
								<button type="button" class="form-control btn btn-danger btn-sm delbtn"
									data-toggle="modal" data-target="#deleteFloorsheet">
									<i class="glyphicon glyphicon-trash"></i> Delete
								</button>
							{!! Form::close() !!}
						</span>
                        <table class="table table-condensed">
                            <thead>
                                <th class="col-sm-8">Attributes</th>
                                <th class="col-sm-3">Value</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Total Number of Transactions</th>
                                    <td>{{count($transposedFloorsheetData['id'])}}</td>
                                </tr>
                                <tr>
                                    <th>Total Quantity</th>
                                    <td>{{array_sum($transposedFloorsheetData['quantity'])}}</td>
                                </tr>
                                <tr>
                                    <th>Total Number of Companies</th>
                                    <td>{{count(array_unique($transposedFloorsheetData['company_id']))}}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <td>{{array_sum($transposedFloorsheetData['amount'])}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr/>
                    </div>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Transaction No.</th>
                                <th>Quote</th>
                                <th>Buyer Broker</th>
                                <th>Seller Broker</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sn=0; ?>
                            @foreach($floorsheetData as $row)
                                <tr>
                                    <td>{{++$sn}}</td>
                                    <td>{{$row->transaction_no}}</td>
                                    <td>{{$companys[$row->company_id]}}</td>
                                    <td>{{$row->buyer_broker}}</td>
                                    <td>{{$row->seller_broker}}</td>
                                    <td>{{$row->quantity}}</td>
                                    <td>{{$row->rate}}</td>
                                    <td>{{$row->amount}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info" role="alert" style="margin-top:10px;">
                        <h4>No floorsheet data available</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteFloorsheet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                This action cannot be rolled back. This will delete all the record associated with the floorsheet.Are you sure you want to delete whole floorsheet of this date?
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
        $('.datatable').DataTable({
            'lengthMenu': [[100,150,200,250],[100,150,200,250]]
        });
    });

    $('.mydate').on('blur',function(){
        newDate = $(this).val().replace(/-/g,'/');
        address = "{{route('admin.floorsheet')}}";
        $('a.go').attr('href',address+'/'+newDate);
    });
	
	$(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteFloorsheet');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection