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

			<div class="user_joined_info">
				<span><span class="glyphicon glyphicon-time"></span> Joined {{ $user->created_at->diffForHumans() }}</span>
				<span class="label label-default" style="margin:0 auto; display:inline-block">{{ $user->gender }}</span>
			</div>

			@if(Auth::check())
				@if($user->username == Auth::user()->username)
					<a href="{{ URL::route('edit') }}" class="btn" style="margin:0 auto; display:block;">
						<span class="glyphicon glyphicon-pencil"></span> Edit rofile
					</a>
				@endif
			@endif

			<div class="">
				<h3 class="stud_contact_info_header">ელ. ფოსტა</h3>
				<div class="well well-sm"><span class="glyphicon glyphicon-user"></span> {{ $user->email }}</div>
				<h3 class="stud_contact_info_header">ტელეფონ(ებ)ი</h3>
				<ul class="list-group">
					@foreach($user->phones as $phone)
					<li class="list-group-item"><span class="glyphicon glyphicon-phone-alt"></span> {{ $phone->phone }}</li>
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
	
<h3>Recent Activity</h3>
<div class="pull-right activity_head_wrapper">
	<ul class="nav nav-tabs pull-left">
		 <li role="presentation"><a class="btn btn-xs btn-default active" id="my_projects_btn">Projects</a></li>
		 @if($user->id == Auth::user()->id)
		 	<li role="presentation"><a class="btn btn-xs btn-default" id="my_bids_btn">Bids</a></li>
		 @endif
		 <li role="presentation"><a class="btn btn-xs btn-default" id="my_comments_btn">Comments</a></li>
	</ul>
	@if(Auth::check())
	<span data-toggle="tooltip" data-placement="top" id="rating_wrapper" class="pull-right">
		<input id="rating" type="number" class="rating" data-min="0" data-max="5" data-step="0.1" data-stars=5 
			data-glyphicon="false" data-size="xs" action="{{ URL::route('rating-change') }}" value="{{ round($rating, 1) }}">
	</span>
	@endif
    <div class="clear"></div>
   	 <hr>
</div>


<div class="pull-left user_activity_container">
	<div class="scroll" id="my_projects_wrapper">
		@if($projects->count() < 1)
			<h4 class="center">No Projects</h4>
		@else
			<?php echo $projects->links(); ?>
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
								<p class="violet">Taken</p>
							@endif
						</td>
						<td>
							{{ $project->salary}} {{ $project->currency}}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>
	@if(Auth::check() && $user->id === Auth::user()->id)
		<div class="scroll" id="my_bids_wrapper" style="display:none;">
			@if($bids->count() < 1)
				<h4 class="center">No Bids</h4>
			@else
				@foreach($bids as $bid)
					<?php 
						$pr = Project::find($bid->pivot->project_id);
						$bidder = User::find($bid->pivot->user_id);
						$status = 0; $bordeColor = null;
						if($bid->pivot->status == 1){
							$status = 1; 
							$bordeColor = 'green_border';
						}elseif ($bid->pivot->status == 2) {
							$status = 2; 
							$bordeColor = 'orange_border';
						}
					?>
					<div class="my_bids {{ $bordeColor }}">
						<h4>Bidded <a href="{{ URL::route('project-show', $pr->id) }}">{{ $pr->name }}</a></h4>
						<small><span class="glyphicon glyphicon-time"></span> {{$bid->pivot->created_at->diffForHumans() }}</small>
						<div class="my_bid_price pull-right"><b>My Terms</b>
							 <span>Price: {{$bid->pivot->bid_price }} {{$bid->pivot->bid_currency }}; Timeline: {{$bid->pivot->duration }}</span>
						</div>

						<br>

						<p>
							I Wrote: <span class="my_bid_comment">{{ $bid->pivot->comment }}</span>
						</p>

						<br>
						<a href="{{ URL::route('bid-show', [$bidder->id, $bid->pivot->project_id]) }}" class="pull-left"><span class="glyphicon glyphicon-eye-open"></span> Show Bid</a>
						@if($status == 0)
							<a href="{{ URL::route('project-unbid', $pr->id) }}" class="btn btn-xs btn-warning pull-right unbid edge_btn"><span class="glyphicon glyphicon-remove-sign"></span> Unbid</a>
						@elseif($status == 1)
							<span class="glyphicon glyphicon-star pull-right" style="font-size:24px; color:green;"></span>
							<a href="{{ URL::route('project-unbid', $pr->id) }}" class="btn btn-xs btn-default pull-right decline edge_btn"><span class="glyphicon glyphicon-remove-sign"></span> Decline</a>
						@elseif($status == 2)
							<span class="glyphicon glyphicon-remove-sign pull-right your_bid_declined" style="font-size:24px; color:orange;"></span>
							<a href="{{ URL::route('project-unbid', $pr->id) }}" class="btn btn-xs btn-danger pull-right decline edge_btn"><span class="glyphicon glyphicon-remove-sign"></span> Remove</a>
						@endif
						<div class="clear"></div>
					</div>
				@endforeach
				@if($bids->count() > 15)
					<a href="{{ URL::route('staff-my', 'bids') }}" class="btn btn-block btn-sm btn-default">Show More Bids <span class="glyphicon glyphicon-comment"></span></a>
				@endif
			@endif
		</div>
		@endif

	<div class="scroll" id="my_comments_wrapper" style="display:none;">
		@if($comments->count() < 1)
			<h4 class="center">No Comments</h4>
		@else
			@foreach($comments as $comment)
				<a href="{{ URL::route('project-show', $comment->project_id) }}" class="user_comments_wrapper pull-left">
					<h3>Posted on {{ Project::find($comment->project_id)->name }}</h3>
					<p><span class="glyphicon glyphicon-comment"></span> {{ $comment->body }}</p>
					<br/>
					<div class="clear"></div>
				</a>
			@endforeach
			<div class="clear"></div>
			@if($comments->count() > 15)
				@if(Auth::check() && Auth::user()->id == $user->id)
					<a href="{{ URL::route('staff-my', 'comments') }}" class="btn btn-block btn-sm btn-default">Show More Comments <span class="glyphicon glyphicon-comment"></span></a>
				@endif
			@endif
		@endif
	</div>
</div>
<div class="clear"></div>

<script type="text/javascript">
	$(function () {
	  $('#rating_wrapper').tooltip(/*{'title':'Rate This User'}*/)
	});
	$(function () {
	  $('.glyphicon-star').tooltip({'title':'Bid Accepted!', 'placement':'left'})
	});
	$(function () {
	  $('.your_bid_declined').tooltip({'title':'Bid Declined, or Project Removed', 'placement':'left'})
	})

	$("#rating").rating({
		starCaptions: {},
    	starCaptionClasses: {},
    });

	@if($permission == 0)
	   	$("#rating").rating("refresh", {disabled: true, showClear: false});
	   	$('#rating_wrapper').tooltip({'title':'You Have Already Rated This User'})
	@endif

	$('.phones').text(function(i, text) {
	    return text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
	});

	/*$( "#ratingForm" ).on('click' ,function( event ) {
 
	  // Stop form from submitting normally
	  event.preventDefault();
	 
	  // Get some values from elements on the page:
	    term = $('this').find( "input[name='s']" ).val(),
	    url = $('this').attr( "action" );
	 
	  // Send the data using post
	  var posting = $.post( url, { s: term } );
	 
	  // Put the results in a div
	  posting.done(function( data ) {
	    var content = $( data ).find( "#content" );
	    $( "#result" ).empty().append( content );
	  });
	});*/
	$('#rating').on('rating.change', function(event, value, caption) {
	    console.log(value);
	    //console.log(caption);
	    url = $('#rating').attr("action");
	    console.log(url);
		var posting = $.post( url, { rating: value, id: '{{ $user->id }}'} );

		posting.done(function( data ) {
		    //var content = $( data ).find( "#content" );
		   // $( "#result" ).empty().append( content );
		   if (data['permission'] == 1) {
		  	 	$('#rating').rating('update', data['rating']);
		   } else {
		   		$("#rating").rating("refresh", {disabled: true, showClear: false});
		   		//$('#rating_wrapper').tooltip({'title':'You Have Just Rated This User'})
		   }
		   console.log(data);
		});
	});

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
		$('#my_comments_wrapper').hide();
		$('#my_projects_btn').addClass('active');
		$('#my_bids_btn').removeClass('active');
		$('#my_comments_btn').removeClass('active');
	});
	$('#my_bids_btn').on('click', function(){
		$('#my_projects_wrapper').hide();
		$('#my_comments_wrapper').hide();
		$('#my_bids_wrapper').show();
		$('#my_projects_btn').removeClass('active');
		$('#my_comments_btn').removeClass('active');
		$('#my_bids_btn').addClass('active');
	});
	$('#my_comments_btn').on('click', function(){
		$('#my_projects_wrapper').hide();
		$('#my_bids_wrapper').hide();
		$('#my_comments_wrapper').show();
		$('#my_projects_btn').removeClass('active');
		$('#my_bids_btn').removeClass('active');
		$('#my_comments_btn').addClass('active');
	});
</script>
@stop