@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif


<div class="fixedheader1">
	<h3>Projects</h3>
	<hr>
</div>
<div class="scroll">

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
						{{ $project->created_at->diffForHumans() }}; {{ $project->created_at->toFormattedDateString() }}
					</td>
					<td>
						{{ $project->salary}} {{ $project->currency}}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
</div>
<a href="#" class="scrollToTop"></a>

<script type="text/javascript">

/////// pagination wrap

$('.project_description').hover(function () {
    $(this).find('div').toggleClass('hide_1');
});
	
</script>
@stop
