<div class="scroll" id="my_projects_wrapper">
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
					?>
					<br/>
					@if($project->active == 1)
						<p class="good">Active</p>
					@elseif($project->active == 0)
						<p class="bad">Expired or Removed</p>
					@elseif($project->active == 2)
						<p class="orange">Taken</p>
					@endif
				</td>
				<td>
					{{ $project->salary}} {{ $project->currency}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<?php Paginator::setPageName('page_a'); ?>
	{{ $projects->links(); }}
</div>