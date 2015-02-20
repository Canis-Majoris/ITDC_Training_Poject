
<div class="container">

	<!-- PAGE TITLE -->
	<div class="commen-section-header">
		<h2>Comments</h2>
		<span class="badge">{{ $comments->count() }}</span>
	</div>

	<!-- NEW COMMENT FORM -->
	{{ Form::open(['route' => ['postcomment'], 'method' => 'POST', 'files' => true]) }}
		<!-- AUTHOR -->
		<a class="replay_button write_new_comment"><span class="glyphicon glyphicon-pencil"></span> Post Something...</a>
		<div class="write_comment_wrapper" style="display:block" id="main_comment_input">
			<input type="hidden" name="project_id" placeholder="Name" value="{{ $project->id }}" class="top_fill">
			<input type="hidden" name="user_id" placeholder="Name" value="{{ $user->id }}" class="top_fill">
			<input type="hidden" name="replaying_id" placeholder="Name" value="">

			<!-- COMMENT TEXT -->
			<div class="form-group">
				<input type="text" class="form-control input-lg mycomment subinput pill-left" name="body" placeholder="Say what you have to say">
				<button type="submit" class="btn btn-primary btn-lg commentSubmit pull-right"><span class="glyphicon glyphicon-send send_comment"></span></button>
				<div class="clear"></div>
			</div>
		</div>
		<a class="show_all_comments pull-right"><p>Show Comments</p> <span class="glyphicon glyphicon-comment"></span></a>
		<div class="clear"></div>
		<div class="comments">
			@include('ITDC_Project.home.comments.showall', ['project' => $project])
		</div>
		
	{{ Form::close(); }}

</div>
<div class="clear"></div>
<script type="text/javascript">

	$(document).ready(function () {
		$('.write_comment_wrapper').hide();
		$('.write_comment_wrapper :input').prop("disabled", true);
	    $('a.replay_button').on('click', function (e) {
	        e.preventDefault();
	        var elem = $(this).next('.write_comment_wrapper');
	        $('.write_comment_wrapper').not(elem).hide('slow');
	      //  $('.write_comment_wrapper').not(elem).find(':input').val('');
	        $('.write_comment_wrapper').not(elem).find(':input').prop("disabled", true);
			$('.commentSubmit').attr('disabled', true);

	         $('.mycomment').on('keyup',function() {
			    if($(this).val() != '') {
			        $('.commentSubmit').attr('disabled' , false);
			    }else{
			        $('.commentSubmit').attr('disabled' , true);
			    }
			});

	        //$(':input','.write_comment_wrapper').not(elem).prop("disabled", true)
	        //prop('disabled', true);
	        elem.toggle('write_comment_wrapper');
	        elem.find(':input').not('.commentSubmit').prop('disabled', function(i, v) { return !v; });
	        
	       
	        //$(".write_comment_wrapper :input").prop('disabled', function(i, v) { return !v; });
	    });
	    
	    $('.replays').show();
	    $('a.show_discussion').on('click', function (e) {
	        e.preventDefault();
	        var elem = $(this).next('.replays');
	        elem.toggle('replays');
	        var showBlock = $(this).next('show_discussion')
	        $('.show_discussion').not(showBlock).removeClass('active_whown');
	        if (showBlock.next('.replays').is(':visible')) {
	        	showBlock.addClass('active_whown');
	        }else {
	        	showBlock.removeClass('active_whown');
	        }
	        var allReplays = elem.find('.replays');
	        if(allReplays.is(':visible')){
	        	allReplays.fadeOut(slow);
	        }else{
	        	allReplays.fadeIn(slow);

	        }
	    });

	    $('.show_all_comments').on('click', function(){
	    	if ($('.comments').is(':visible')) {
	    		$('.comments').hide(500);
	    	}else {
	    		$('.comments').show(300);
	    	}
	    });

	});

</script>
