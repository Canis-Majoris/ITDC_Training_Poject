
@foreach($projects as $project)
	<?php
		$creatinInMinutes = $project->created_at->diffInMinutes();
		if ($creatinInMinutes > 87658) {
			$r = 100;
		}else{
			$r = (100*$creatinInMinutes)/87658;
		}
		$g = 100 - $r;
	?>
	<tr id="show_project_inline_{{ $project->id }}" class="project_description" >
		<td style="border-left: 8px solid rgba({{ $r }}%,{{ $g }}%,0%, 0.4) !important;">
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


