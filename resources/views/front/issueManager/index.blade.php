@extends('front.main')

@section('title')
Issue Manager
@endsection

@section('specificheader')
{!! HTML::style('vendors/dataTables/Responsive-1.0.7/css/responsive.bootstrap.css') !!}
<style type="text/css">
	.issue-manager-selector{
		display: none;
	}
	.issue-manager-row, .manager-info{
		padding-top: 7px;
	}
</style>
@endsection

@section('content')
<section class="main-content col-md-9 col-xs-12">
	<div class="row issue-manager-selector">
		<div class="col-sm-9">
            <div class="form-group">
                <div class='input-group' id="issue-manager">
                	<span class="input-group-addon">Issue Manager</span>
                    {!! Form::select('issue_manager_id',$issueManager,old('issue_manager_id'),['class'=>'form-control issueManager']) !!}
                </div>
            </div>
        </div>
	</div>
	<div class="row no-margin issue-manager-row">
		<div class="col-md-12">
			<table id="datatable" class="table datatable table-condensed table-striped table-responsive with-border" width="100%">
				<thead>
					<tr>
						<th>Company</th>
						<th>Quote</th>
						<th>Address</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Web</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</section>
@endsection

@section('endscript')
<script>
	var issueManagerURL = "{{route('front.issueManager')}}";
	var issueManagerTable;
</script>
{!! HTML::script('vendors/dataTables/Responsive-1.0.7/js/dataTables.responsive.min.js') !!}
{!! HTML::script('assets/nsm/front/js/issuemanager.js') !!}
<script type="text/javascript">
	function getURLParameter(name) {
	  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
	}
	$(document).ready(function(){
		var id = getURLParameter('id');
		if(id != null)
		{
			$('.issueManager').val(id);
			$('.issueManager').trigger('change');
		}
	})
</script>
@endsection