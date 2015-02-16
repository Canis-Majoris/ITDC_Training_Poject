@extends('layouts.home')
@section('ragac')

@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif
	<div class="col-xs-4">
		
		<div class="clear"></div>
		<div class="stud_contact_info">


		@if($user->avatar)
			<div class="col-md-12">
				<img src="/uploads/{{ $user->avatar }}" width="120px" height="120px" style="margin:0 auto; display:block;" />	
			</div>
		@endif
		<h1 class="" style="text-align:center;">
			{{ $user->firstname }} {{ $user->lastname }}
		</h1>
			<span class="label label-default" style="margin:0 auto; display:inline-block">{{ $user->gender }}</span>

			@if(Auth::check())
				@if($user->username == Auth::user()->username)
					<a href="{{ URL::route('edit') }}" class="btn" style="margin:0 auto; display:block;"><span class="glyphicon glyphicon-pencil"></span> Edit rofile</a>
				@endif
			@endif
			<div class="">
				<h2 class="stud_contact_info_header">საკონტაქტო ინფორმაცია</h2>
				<h3 class="stud_contact_info_header">ელ. ფოსტა</h3>
				<div class="well well-sm">{{ $user->email }}</div>
				<h3 class="stud_contact_info_header">ტელეფონ(ებ)ი</h3>
				<ul class="list-group">
					@foreach($user->phones as $phone)
					<li class="list-group-item phones">{{ $phone->phone }}</li>
					@endforeach
				</ul>
			</div>
			
			@if($user->type == 0 || $user->type == 1)
				<h3>Skills</h3>
				<div class="list_user_skills_1">
					@foreach($user->skills as $skill)
						<?php $lvl = null; $seletced_skill = 'default'; $color_shade = null;  $s = null;
							$lvl = $skill->pivot->level; $seletced_skill = 'info'; $s = ', LVL:';
							$color_shade = 'style="background-color:hsl(120,40%,'.(100-$lvl).'%)"';
						?>
						<a href="{{ URL::to('#') }}" class="label label-{{ $seletced_skill }} bordered_1" {{ $color_shade }}>{{ $skill->name.$s.$lvl }}</a>
					@endforeach
				</div>
				<h3>Courses</h3>
				<div class="list_user_skills_1">
					@foreach($user->courses as $skill)
						<?php $lvl = null; $seletced_skill = 'default'; $color_shade = null;  $s = null;
							$lvl = $skill->pivot->level; $seletced_skill = 'info'; $s = ', LVL:';
						?>
						<a href="{{ URL::to('#') }}" class="label label-{{ $seletced_skill }} bordered_1" style="font-size:9px;">{{ $skill->name.$s.$lvl }}</a>
					@endforeach
				</div>
			@endif
		</div>
	</div>
	
		<h4>Recent Activity</h4>
		<div class="col-xs-6">
		@foreach($user->projects as $project)
			<a href="{{ URL::route('project-show', $project->id) }}" class="activity_project_wrapper">
				<h4>{{ $project->name }}</h4>
				<p>{{ $project->description }}</p>
				<br/>
				<span class="price pull-right">{{ $project->avg_price }}{{ $currencies[$project->currency] }}</span>
				<div class="clear"></div>
			</a>
			<hr>
		@endforeach
	</div>
	<div class="clear"></div>



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
	
	<script type="text/javascript">
	$('.phones').text(function(i, text) {
	    return text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
	});
</script>
@stop