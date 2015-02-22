@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif

<style>
	
</style>
<div class="show-project">
	<div class="jumbotron">
		@if($currUser->id === $creator->id && $project->active != 0)
			<a href="{{ URL::route('project-deactivate', $project->id) }}" class="btn btn-xs btn-default pull-right deactivate">
				<span class="glyphicon glyphicon-remove-sign"></span> Deactivate This Project
			</a>
		@endif
		<h2 class="project_tytle pull-left">{{ $project->name }}</h2>

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
					@if(!empty($types[0]))
						@foreach($types as $type)
							<span class="project_type_wrap" data-toggle="popover" title="Description:" data-content="<p>{{ $typeDesc->find($type)->description }}</p>" id="project_type_wrap_{{ $type }}">
								{{ $typeDesc->find($type)->name }}
							</span>
						@endforeach
					@endif
				</div>
			</div>

			<div class=" pull-right">
				<h5>Skills Required:</h5>
				<div class="project_skill_names_wrap">
				@foreach($skills as $skill)
					<span class="label label-default skill_level_tooltip" data-toggle="tooltip" title="minimum LVL <span>{{ $skill->pivot->level }}</span>">{{ $skill->name }}</span>
				@endforeach
				</div>
			</div>

			<div class="clear"></div>
		</div>
		@if($project->active == 1)
			@if(!isset($project->users()->where('user_id', '=', $currUser->id)->first()->pivot))
				<div>
					<button type="button" class="btn btn-primary btn-lg bid_here round pull-right" data-toggle="modal" data-target="#myModal">
					 	<span class="glyphicon glyphicon-certificate"></span> Bid on This Project
					</button>
				</div>
				<div class="clear"></div>
			@else
			<!--- -> > ^ -->
		</div>
			<hr/>
				<div class="good center">
					<h1 class="">You Have Already Bidded This Project.</h1>	
				</div>
			<hr/>
			@endif
		@elseif($project->active == 2)
		</div>
			<hr/>
				<div class="orange center">
					<h1 class="">Project Already Taken</h1>	
				</div>
			<hr/>
		@elseif($project->active == 0)
		</div>
			<hr/>
				<div class="bad center">
					<h1 class="">Project Expired or Removed</h1>	
				</div>
			<hr/>
		@endif
		

	</div>



	<div class="bidders_list">
		<table class="table table-striped">
			<thead>
				<th width="50%">
					Freelancers Bidding <span class="badge">{{$bidders->count()}}</span>
				</th>
				<th width="30%"> 
					Reputation
				</th>
				<th width="20%"> 
					Bid
				</th>
			</thead>
			<tbody>
				@foreach($bidders as $bidder)
					<?php $currBid = $bidder->projects()->where('project_id', '=', $project->id)->first()->pivot; ?>
					<tr class="bidder_wrap">

						<td>
							<div class="avatar_wrap_2">
								@if($bidder->avatar)
									<img src="/uploads/{{ $bidder->avatar }}" class="img-rounded"/>
								@else
									<img src="http://www.miyokids.com/catalog/view/theme/ULTIMATUM/image/no_avatar.jpg" />
								@endif
							</div>

							<a href="{{ URL::route('user-profile', $bidder->username) }}">
								{{ $bidder->username }}
							</a>
							<small>Bidded {{ $currBid->created_at->diffForHumans() }}</small>
						</td>

						<td>
							<input id="rating" type="number" class="rating" data-min="0" data-max="5" data-step="0.1" data-stars=5 
	    						data-glyphicon="false" data-size="xs" action="{{ URL::route('rating-change') }}" value="{{ round($bidder->reputation, 1) }}">
						</td>

						<td>
	 						{{ $currBid->bid_price }} {{ $currBid->bid_currency }}
	 						<br>
	 						{{ $currBid->duration }}
	 						@if($currUser->id === $bidder->id || $currUser->type == 0)
	 							<br>
								<a href="{{ URL::route('project-unbid', $project->id) }}" class="btn btn-xs btn-warning pull-right unbid"><span class="glyphicon glyphicon-remove-sign"></span> Unbid</a>
	 						@endif
	 						@if($currUser->id === $project->user_id || $currUser->type == 0)
								<a href="{{ URL::route('bid-show', [$bidder->id, $project->id]) }}" class="pull-right show_bid"><span class="glyphicon glyphicon-eye-open"></span> Show Bid</a>
	 						@endif
	 						
	 						
						</td>
						
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<hr>
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Place Your Bid</h4>
      </div>
      <div class="modal-body">
		<br>
		{{ Form::open(['route' => ['project-bid'], 'method' => 'POST', 'files' => true]) }}
			{{ Form::hidden('project_id', $project->id) }}

			{{ Form::label('price', 'Price', ['class'=>'control-label']); }}
			<div class="input-group" id="unified-inputs">
				<?php $priceError =  null ; $error_border_class = null;?>
				@if($errors->has('price'))
					<?php $priceError =  $errors->first('price') ; $error_border_class = 'error_border';?>
				@endif
				{{ Form::input('number', 'price', Input::old('price'), ['class'=>'form-control '.$error_border_class, 'id'=>'price']) }}
				<div class="error_message_small">
					{{ $priceError }}
				</div>
				{{ Form::select('bid_currency', $currencies, Input::old('bid_currency'), ['class'=>'form-control']) }}
				
			</div>
			<div class="form-group">

				{{ Form::label('duration', 'Duration', ['class'=>'control-label']); }}
				{{ Form::select('duration', $timespan, Input::old('duration'), ['class'=>'form-control', 'id'=>'duration']) }}
			</div>
			<div class="form-group">
				<?php $descriptionError =  null ; $error_border_class = null;?>
				@if($errors->has('description'))
					<?php $descriptionError =  $errors->first('description') ; $error_border_class = 'error_border';?>
				@endif
				{{ Form::label('about_project', 'About Project Terms', ['class'=>'control-label']); }}
				{{ Form::textarea('description', Input::old('description'), ['class' => 'field form-control '.$error_border_class, 'size' => '30x15', 'id' => 'about_project_1']) }}
				<div class="error_message_small">
					{{ $descriptionError }}
				</div>
			</div>
			<button type="submit" id="sendBid" data-loading-text="Sending..." class="btn btn-primary pull-right" autocomplete="off">
			  Send
			</button>

		{{ Form::close(); }}

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!-- /////////////////////////////////////////// Comments ///////////////////////////////////////////////// -->
@if($project->active == 1)
	@include('ITDC_Project.home.comments.index', ['comments' => $comments, 'user' => $currUser, 'project' => $project])
@endif

<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<hr/>

<script>

	$(".rating").rating("refresh", {disabled: true, showClear: false});

	@if($errors->has())
		$('#myModal').modal('show');
	@endif

	CKEDITOR.replace('about_project_1', {
		uiColor: '#E6E6E6',
		language: 'ka'
	});
	$(document).ready(function(){
		$('#sendBid').on('click', function () {
		    var $btn = $(this).button('loading');
		});
	});
	$(function () {
	  $('.skill_level_tooltip').tooltip({placement: 'bottom', html: true, trigger: 'hover focus'})
	});
	$(function () {
	  $('.deactivate').tooltip({placement: 'bottom', html: true, trigger: 'hover focus',
	  	 title: '<span class="bad">Deactivate This Project <br><span class="glyphicon glyphicon-exclamation-sign"></span> <p>You Will Not Be Able To Reactivate After This Action</p></span>'})
	});
	$(function () {
	  $('.delete_comment').tooltip({placement: 'bottom', html: true, trigger: 'hover focus'})
	});
	$(function () {
	  $('.project_type_wrap').popover({placement: 'bottom', html: true, trigger: 'click'})
	});

	$('.unbid').on("click", function(e){
		if(confirm("Do you really want to Unbid?")){

		}else{
			e.preventDefault();
		}	
	});
	$('.deactivate').on("click", function(e){
		if(confirm("Are You Sure You Want To Deactivate This Project? Remember, There Is No Going Back!")){

		}else{
			e.preventDefault();
		}	
	});

</script>

@stop
