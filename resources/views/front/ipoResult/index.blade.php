@extends('front.main')

@section('title')
IPO Result
@endsection

@section('specificheader')
<style type="text/css">
.search-panel .row {
	margin-bottom:10px;
}
</style>

@endsection

@section('content')
	<section class="col-sm-9 col-xs-12 main-content">
		<div class="search-panel" style="padding-top:10px;">
			<div class="row">
				<div class="col-md-12"> 
		        	{!! Form::select('company_id',$company,$latestResult->company_id,['class'=>'form-control','id'=>'company_id']) !!}
		        </div>
		    </div>
			<div class="row">		       
		        <div class="col-md-12">
					<input type="text" class="form-control" placeholder="First Name" id="first_name">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<input type="text" class="form-control" placeholder="Last Name" id="last_name">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Application #" id="application_no">
						<span class="input-group-btn"><button id="search-btn" class="btn btn-default" type="button"><i class="fa fa-search"></i> Search</button></span>
					</div>
				</div>
			</div>
		</div>
		<table id="datatable" class="table datatable table-condensed table-striped with-border responsive display no-wrap" width="100%">
		    <thead>
		        <tr>
		        	<th>SN</th>
		            <th class="appno">Application Number</th>
		            <th>First Name</th>
		            <th>Last Name</th>
		            <th class="appk">Applied Kitta</th>
		            <th class="allk">Alloted Kitta</th>
		        </tr>
		    </thead>
		    <tbody>

		    </tbody>
		</table>
	</section>
	<aside class="col-sm-3">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- 200by200 home -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:200px;height:200px"
		     data-ad-client="ca-pub-5451183272464388"
		     data-ad-slot="7967997665"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</aside>
@endsection

@section('endscript')

<script type="text/javascript">
	var config = {
        allow_single_deselect:true,
        disable_search_threshold:5,
        no_results_text:'No company found with name '
    };
    $(document).ready(function(){
        $('select[name=company_id]').chosen(config);
    });

	var table;
	$('#first_name, #last_name, #application_no').on('change',function(){
        if(table!==undefined){
        	table.ajax.reload();
        	return;
        }
        table = $('#datatable').DataTable({
	        processing: true,
	        serverSide:true,
	        responsive:false,
	        language: {
	            processing: SPINNER
	        },
	        responsive:false,
	        paging:true,
	        lengthMenu: [[100,200,300,400],[100,200,300,400]],
	        ajax:{
	            url: "{{route('api-search-ipo-result')}}",
	            type: 'POST',
	            data: 
	            	{
	            		first_name:function()
	            		{
	            			return $('#first_name').val();
	            		},
	            		last_name:function()
	            		{
	            			return $('#last_name').val();
	            		},
	            		application_no:function()
	            		{
	            			return $('#application_no').val();
	            		},
	            		company_id:function()
	            		{
	            			return $('#company_id').val();
	            		}	
	            	}
	        },
	        columns: [
	        	{data: 'application_no',name:'application_no',searchable:false},
	            {data: 'application_no',name:'application_no'},
	            {data: 'first_name',name:'first_name'},
	            {data: 'last_name',name:'last_name'},
	            {data: 'applied_kitta',name:'applied_kitta'},
	            {data: 'alloted_kitta',name:'alloted_kitta'},
	        ]
		});
		$('#first_name, #last_name, #application_no, #company_id').on('change',function(){
			table.ajax.reload();
		});
		table.on( 'order.dt search.dt page.dt draw.dt', function () {
	        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
	            cell.innerHTML = i+1;
	        });
	        resizeWindow();
	    }).draw();
	    $(window).bind("resize load", function(){
			resizeWindow();
		});

		function resizeWindow( e )
		{
			var newWindowWidth = $(window).width();
			var mobileVisibleIndex = [1,2,3,4,5,6];
			var desktopVisibleINdex = [0,1,2,3,4,5,6];

			if(newWindowWidth > 992) currentView = desktopVisibleINdex; else currentView = mobileVisibleIndex;
			table.columns().eq(0).each(function(index){
				var isVisible = !($.inArray(index,currentView)==-1);
				table.column(index).visible(isVisible);
			});
		}

		function xycss_text_abbrev(){
			if($(window).width() <= 767) {
				$('.appno').text('A.N.');
				$('.appk').text('AP.K.');
				$('.allk').text('AL.K.');
			} else {
				$('.appno').text('Application Number');
				$('.appk').text('Applied Kitta');
				$('.allk').text('Alloted Kitta');
			}
		}
		$(document).ready(function(){
			xycss_text_abbrev();
		});
		$(window).resize(function() {
			xycss_text_abbrev();
		});
	});
</script>
@endsection