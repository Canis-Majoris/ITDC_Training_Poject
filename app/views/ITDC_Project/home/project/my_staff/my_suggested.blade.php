
<?php
	$projects = $suggested['projects'];
	$currencyArr = $suggested['currencyArr'];
	$types = $suggested['types'];
	$skills = $suggested['skills'];
?>

<div class="scroll" id="my_comments_wrapper">
	<div>
		<h2>Suggested Projects</h2>
		<hr>
	</div>
	@foreach($projects as $project)
	<div class="show-project">
		<div class="jumbotron">
			<h2 class="project_tytle pull-left"><a href="{{ URL::route('project-show', $project->id) }}" >{{ $project->name }}</a></h2>
			<?php $creator = User::find($project->user_id); ?>
			<small class="pull-right project_author_ref"> 
				Created {{ $project->created_at->diffForHumans() }} by 
				<a href="{{ URL::route('user-profile', $creator->username) }}">{{ $creator->username }}</a>
			</small>

			<div class="clear"></div>
			<hr/>

			<div>
				{{ $project->description }}
			</div>

			@if($project->files)
				<div class="project_attach_wrap">
					<img src="/uploads/projects/{{ $project->files }}" width="60px" height="60px" />	
				</div>
			@endif

			<div class="project_sub_info_wrap">
				<div class="project_baseinfo_wrap pull-left">
					<span>Duration:</span> <span class="salay_wrap">{{ $project->duration }}</span>
					<br/>
					<span>Average Price:</span> <span class="salay_wrap">{{ $currencyArr[$project->currency] }}{{ $project->avg_price }}</span>
					<br/>
					<span>Salary:</span> <span class="salay_wrap">{{ $currencyArr[$project->currency] }}{{ $project->salary }}</span>
					<div class="project_types">
						@if(!empty($types[$project->id]['typeArr'][0]))
							@foreach($types[$project->id]['typeArr'] as $type)
								<span class="project_type_wrap" data-toggle="popover" title="Description:" data-toggle="popover" title="Description:" data-content="<p>{{ $types[$project->id]['allTypes']->find($type)->description }}</p>" id="project_type_wrap_{{ $type }}">
									{{ $types[$project->id]['allTypes']->find($type)->name }}
								</span>
							@endforeach
						@endif
					</div>
				</div>

				<div class=" pull-right">
				<?php //print_r($skills[$project->id]); ?> 
					<h5>Skills Required:</h5>
					<div class="project_skill_names_wrap">
					@foreach($skills[$project->id] as $skill)
						<span class="label label-default skill_level_tooltip" data-toggle="tooltip" title="minimum LVL <span>{{ $skill->pivot->level }}</span>">{{ $skill->name }}</span>
					@endforeach
					</div>
				</div>


				<div class="clear"></div>
			</div>
			<!--- -> > ^ -->
		</div>
	</div>
	@endforeach
	<?php Paginator::setPageName('page_d'); ?>
	{{ $projects->links(); }}
</div>
<script type="text/javascript">

	$(function () {
	  $('.skill_level_tooltip').tooltip({placement: 'bottom', html: true, trigger: 'hover focus'})
	});
	$(function () {
	  $('.project_type_wrap').popover({placement: 'bottom', html: true, trigger: 'click'})
	});

</script>
