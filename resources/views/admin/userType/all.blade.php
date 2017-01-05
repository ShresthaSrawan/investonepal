@extends('admin.master')

@section('title')
User Type
@endsection

@section('content')
@include('admin.partials.errors')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-th-list fa-fw"></i> User Types :List:</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm btn-flat" 
                data-toggle="modal" data-target="#createUserType">
                <i class="fa fa-plus"></i> Add
            </button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th rowspan="2">Name</th>
                    <th colspan="5">Rights</th>
                </tr>
                <tr>
                    <th>News</th>
                    <th>Portfolio</th>
                    <th>Data</th>
                    <th>User</th>
                    <th>Crawl</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userTypes as $userType)
                <tr>
                    <td>{{$userType->label}}</td>
                    <td>{{$userType->news_rights}}</td>
                    <td>{{$userType->portfolio_rights}}</td>
                    <td>{{$userType->data_rights}}</td>
                    <td>{{$userType->user_rights}}</td>
                    <td>{{$userType->crawl_rights}}</td>
                    <td>
                        {!! Form::open(['route'=>['admin.userType.destroy',$userType->id],'method'=>'delete']) !!}
                            <button type="button" class="btn btn-danger btn-xs delbtn" 
                                data-toggle="modal" data-target="#deleteUserType">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button> 
							<button type="button" class="btn btn-primary btn-xs editbtn"  data-label="{{$userType->label}}" data-news="{{$userType->news_rights}}"
								data-portfolio="{{$userType->portfolio_rights}}" data-user="{{$userType->user_rights}}" data-crawl="{{$userType->crawl_rights}}"
								data-url="{{route('admin.userType.update',$userType->id)}}"
                                data-toggle="modal" data-target="#editUserType">
                                <i class="glyphicon glyphicon-edit"></i>
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteUserType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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


<!-- Create Modal -->
<div class="modal fade" id="createUserType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'admin.userType.store']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Add User Type</h4>
                </div>
                <div class="modal-body">
                    {!! Form::label('type', 'User Type',['class'=>'required']) !!}
                    {!! Form::text('type','reporter',['class'=>'form-control','required'=>'required']) !!}
                    <h5>Rights</h5>
                    <table class="table">
                        <tr>
                            <th rowspan="2">Categories</th>
                            <th colspan="4">Rights</th>
                        </tr>
                        <tr>
                            <th>Create</th>
                            <th>Read</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                        <tr>
                            <td>News</td>
                            <td>{!! Form::select('news[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('news[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('news[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('news[]',['0','1'],0) !!}</td>
                        </tr>
                        <tr>
                            <td>Portfolio</td>
                            <td>{!! Form::select('portfolio[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('portfolio[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('portfolio[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('portfolio[]',['0','1'],0) !!}</td>
                        </tr>
                        <tr>
                            <td>Data</td>
                            <td>{!! Form::select('dataservice[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('dataservice[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('dataservice[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('dataservice[]',['0','1'],0) !!}</td>
                        </tr>
                        <tr>
                            <td>User</td>
                            <td>{!! Form::select('user[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('user[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('user[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('user[]',['0','1'],0) !!}</td>
                        </tr>
                        <tr>
                            <td>Crawl</td>
                            <td>{!! Form::select('crawl[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('crawl[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('crawl[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('crawl[]',['0','1'],0) !!}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {!! Form::submit('Create',['class'=>'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editUserType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'put','id'=>'userType_edit']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Edit User Type</h4>
                </div>
                <div class="modal-body">
                    {!! Form::label('type', 'User Type',['class'=>'required']) !!}
                    {!! Form::text('type','',['class'=>'form-control','required'=>'required','id'=>'userType_label']) !!}
                    <h5>Rights</h5>
                    <table class="table">
                        <tr>
                            <th rowspan="2">Categories</th>
                            <th colspan="4">Rights</th>
                        </tr>
                        <tr>
                            <th>Create</th>
                            <th>Read</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                        <tr>
                            <td>News</td>
                            <td>{!! Form::select('news[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('news[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('news[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('news[]',['0','1'],0) !!}</td>
                        </tr>
                        <tr>
                            <td>Portfolio</td>
                            <td>{!! Form::select('portfolio[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('portfolio[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('portfolio[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('portfolio[]',['0','1'],0) !!}</td>
                        </tr>
                        <tr>
                            <td>Data</td>
                            <td>{!! Form::select('dataservice[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('dataservice[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('dataservice[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('dataservice[]',['0','1'],0) !!}</td>
                        </tr>
                        <tr>
                            <td>User</td>
                            <td>{!! Form::select('user[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('user[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('user[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('user[]',['0','1'],0) !!}</td>
                        </tr>
                        <tr>
                            <td>Crawl</td>
                            <td>{!! Form::select('crawl[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('crawl[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('crawl[]',['0','1'],0) !!}</td>
                            <td>{!! Form::select('crawl[]',['0','1'],0) !!}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('endscript')
<script type="text/javascript">
    $(document).ready(function(){
        $('.datatable').DataTable();
    });
	
	$(document).on('click','.editbtn',function(){
        label = $(this).data('label');
        url = $(this).data('url');
		newsRights = $(this).data('news');
		console.log(newsRights);
        $('#userType_label').attr('value',label);
        $('#userType_edit').attr('action',url);
    });
    
    $(document).on('click','.delbtn',function(e){
        $form=$(this).closest('form');
        e.preventDefault();
        $modal=$('#deleteUserType');
        $modal.modal();
        $('.confirm-delete').click(function(){
            $form.submit();
        });
    });
</script>
@endsection