<div class="scroll" id="my_comments_wrapper">
	<div class="fixedheader1">
		<h2>My Comments</h2>
		<hr>
	</div>
	@foreach($comments as $comment)
		<a href="{{ URL::route('project-show', $comment->project_id) }}" class="user_comments_wrapper pull-left">
			<h4 class="title">Posted on <span>{{ Project::find($comment->project_id)->name }}</span></h4>
			<p><span class="glyphicon glyphicon-comment"></span> {{ $comment->body }}</p>
			<br/>
			<div class="clear"></div>
		</a>
	@endforeach
	<div class="clear"></div>
	<hr/>
	<?php Paginator::setPageName('page_c'); ?>
	{{ $comments->links(); }}
</div>