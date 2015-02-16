@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif
<head>
	<title>My Staff</title>
</head>
<div>
	<button class="btn btn-sm btn-default" id="my_projects_btn">My Projects</button>
	<button class="btn btn-sm btn-default active" id="my_bids_btn">My Bids</button>
</div>
<div class="scroll" id="my_projects_wrapper" style="display:none;">
		<div class="fixedheader1">
			<h2>My Projects</h2>
			<hr>
		</div>

		<table class="table table-hover table-stripped table-bordered projects_table" >
			<thead>
				<th width="40%">Project Name</th>
				<th width="5%">Bids</th>
				<th width="25%">Skills</th>
				<th width="15%">Started</th>
				<th width="15%" align="center">Price</th>
			</thead>
			<tbody>
				@foreach($projects as $project)
				<tr id="show_project_inline_{{ $project->id }}" class="project_description">
					<td>
						<a href="{{ URL::route('project-show', $project->id) }}">
							{{ $project->name}}
						</a>
						<div class="hide_1 hover_show_description">
							{{ $project->description}}
						</div>
					</td>

					
					<td>
						{{ $project->bid_count}}
					</td>
					<td>
						
					</td>
					<td>
						{{ $project->created_at->diffForHumans() }}
						<?php
								echo $project->created_at->toFormattedDateString().' ';
						$k = $project->created_at->diffInMinutes().' ';
						?>
					</td>
					<td>
						{{ $project->salary}} {{ $project->currency}}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		
</div>

<div class="scroll" id="my_bids_wrapper">

	<div class="fixedheader1">
		<h2>My Bids</h2>
		<hr>
	</div>
	@foreach($bids as $bid)
		<?php 
			$pr = Project::find($bid->pivot->project_id);
		?>
		<div class="my_bids">
			<h4>Bidded <a href="{{ URL::route('project-show', $pr->id) }}">{{ $pr->name }}</a></h4>
			<div class="my_bid_price pull-right"><b>My Terms</b> <span>Price: {{$bid->pivot->bid_price }} {{$bid->pivot->bid_currency }}; Timeline: {{$bid->pivot->duration }}</span></div>
			<br>
			<p>
				I Wrote: <span class="my_bid_comment">{{ $bid->pivot->comment }}</span>
			</p>
			<br>
			<a href="{{ URL::route('project-unbid', $pr->id) }}" class="btn btn-xs btn-warning pull-right unbid"><span class="glyphicon glyphicon-remove-sign"></span> Unbid</a>
			<div class="clear"></div>
		</div>
	@endforeach

</div>

<a href="#" class="scrollToTop"></a>

<script type="text/javascript">

/////// pagination wrap

$('.unbid').on("click", function(e){
	if(confirm("Do you really want to Unbid?")){

	}else{
		e.preventDefault();
	}	
});

$('.project_description').hover(function () {
    $(this).find('div').toggleClass('hide_1');
});
	
$('#my_projects_btn').on('click', function(){
	$('#my_projects_wrapper').show();
	$('#my_bids_wrapper').hide();
	$('#my_projects_btn').addClass('active');
	$('#my_bids_btn').removeClass('active');


});
$('#my_bids_btn').on('click', function(){
	$('#my_projects_wrapper').hide();
	$('#my_bids_wrapper').show();
	$('#my_projects_btn').removeClass('active');
	$('#my_bids_btn').addClass('active');

});
</script>
@stop
