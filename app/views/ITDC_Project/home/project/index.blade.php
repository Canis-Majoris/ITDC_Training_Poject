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
<div class="">
	{{$projects->appends(Input::all())->links()}}
</div>
<div class="scroll">

		<table class="table table-hover table-stripped table-bordered" >
			<thead>
				<th width="40%">Project Name</th>
				<th width="5%">Bids</th>
				<th width="25%">Skills</th>
				<th width="15%">Started</th>
				<th width="15%" align="center">Price</th>
			</thead>
			<tbody>
				@foreach($projects as $project)
				<tr>
					<td>
						<a href="{{ URL::route('project-show', $project->id) }}">
							{{ $project->name}}
						</a>
						<p>
							{{ $project->description}}
						</p>
					</td>
					<td>
						s
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
					<td align="center">
						<div>
							{{ $project->salary}}
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
</div>

<div class="">
	{{$projects->appends(Input::all())->links()}}
</div>

<a href="#" class="scrollToTop"></a>

<script type="text/javascript">

/////// pagination wrap


	
</script>
@stop
