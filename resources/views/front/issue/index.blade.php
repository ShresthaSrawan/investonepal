@extends('front.main')

@section('title')
Current/Upcoming Issue
@endsection

@section('specificheader')
<style type="text/css">
	.dataTables_wrapper>.row{
		padding-top: 10px;
	}
	.dataTables_filter {
	    display: block;
	}
	.tab-pane{
		padding-top: 10px;
	}
</style>
@endsection

@section('content')
	<section class="main-content col-sm-9 col-xs-12">
		<?php $im=''; $items = collect([]); ?>
		@foreach($issues as $value)
			<?php $im=''; ?>
			@foreach($value as $issue)
				<?php 
					$name=$issue->name;
					$quote=$issue->quote;
					$subLabel=$issue->subLabel;
					$kitta=$issue->kitta;
					$im .= $issue->company.', ';
				?>
			@endforeach
			<?php
				$items->push([
                	'name' => $name,
                	'quote' => $quote,
                	'subLabel' => $subLabel,
                	'kitta' => $kitta,
                	'im' => $im,
                	'issue_date' => $issue->issue_date,
                	'close_date' => $issue->close_date
                ]);
			?>
		@endforeach
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<?php $count = 0; ?>
			@foreach($items->groupBy('subLabel') as $key => $group)
				<?php $count++; ?>
				<li role="presentation" class="{{ $count == 1 ? 'active':'' }}"><a href="#{{ str_slug($key) }}" aria-controls="{{ str_slug($key) }}" role="tab" data-toggle="tab">{{ ucwords($key) }}</a></li>
			@endforeach
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<?php $count = 0; ?>
			@foreach($items->groupBy('subLabel') as $key => $group)
				<?php $count++; ?>
				<div role="tabpanel" class="tab-pane {{ $count == 1 ? 'active' : '' }}" id="{{ str_slug($key) }}">
					<table class="table datatable table-responsive table-striped table-condensed with-border" width="100%">
					<thead>
						<tr>
							<th class="hidden-xs hidden-md">Company</th>
							<th class="hidden-lg">Quote</th>
							<th>Kitta</th>
							<th>Issue Date</th>
							<th>Close Date</th>
							<th class="hidden-xs hidden-md">Issue Manager</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($group as $item)
							<?php
								$today=Carbon\Carbon::today();
								$issue_date=Carbon\Carbon::createFromFormat('Y-m-d', $item['issue_date']);
								$close_date=Carbon\Carbon::createFromFormat('Y-m-d', $item['close_date']);

								$status="";
		                        $class="";
		                        if($today->gt($close_date)){
		                            $status = "Closed";
		                            $class="danger";
		                        }
		                        elseif($today->gt($issue_date) && ($today->lt($close_date) || $today->eq($close_date))){
		                            $status = "Open";
		                            $class="success";
		                        }
		                        elseif($today->lt($issue_date)){
		                            $status = "Coming Soon";
		                            $class="warning";
		                        }
	                        ?>
							<tr>
								<td class="hidden-xs hidden-md"><a href="{{route('quote',$item['quote'])}}" class="link">{{$item['name']}}</a></td>
								<td class="hidden-lg"><a href="{{route('quote',$item['quote'])}}" class="link">{{$item['quote']}}</a></td>
								<td>{{$item['kitta']}}</td>
								<td>{{$issue_date->format('Y-m-d')}}</td>
								<td>{{$close_date->format('Y-m-d')}}</td>
								<td class="hidden-xs hidden-md">{{substr($item['im'],0,-2)}}</td>
								<td class="{{ $class }}">{{ $status }}</td>
							</tr>
						@endforeach
					</tbody>
					</table>
				</div>
			@endforeach
		</div>
	</section>
	<aside class="col-sm-3">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- 120x240, created 3/2/08 -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:280px;height:240px"
		     data-ad-client="ca-pub-5451183272464388"
		     data-ad-slot="2525566102"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>	
	</aside>
@endsection

@section('endscript')
	<script type="text/javascript">
		$(document).ready(function(){
	        $('.datatable').DataTable({
	        	lengthMenu: [[25,50,75,100],[25,50,75,100]],
				order : [[6,'desc']],
	        	dom:'<"#search.pull-left"f><"#lengthWrap.pull-right"l><tr><ip>',
	        });
	    });
	</script>
@endsection