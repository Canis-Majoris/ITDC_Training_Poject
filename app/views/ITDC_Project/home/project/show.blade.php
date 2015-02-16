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
		<h2 class="project_tytle pull-left">{{ $project->name }}</h2>
		<small class="pull-right project_author_ref"> Created {{ $project->created_at->diffForHumans() }} by <a href="{{ URL::route('user-profile', $creator->username) }}">{{ $creator->username }}</a></small>
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
		
		@if(!isset($project->users()->where('user_id', '=', $currUser->id)->first()->pivot))
			<div>
			<button type="button" class="btn btn-primary btn-lg bid_here round pull-right" data-toggle="modal" data-target="#myModal">
			 	<span class="glyphicon glyphicon-certificate"></span> Bid on This Project
			</button>
			</div>
			<div class="clear"></div>
		@else
		</div>
		<hr/>
			<div class="already_bidded">
				<h1 class="">You Have Already Bidded This Project.</h1>	
			</div>
		<hr/>
		@endif
	</div>

	

	<div class="bidders_list">
		<table class="table table-striped">
			<thead>
				<th width="70%">
					Freelancers Bidding <span class="badge">{{$bidders->count()}}</span>
				</th>
				<th width="15%"> 
					Reputation
				</th>
				<th width="15%"> 
					Bid
				</th>
			</thead>
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
						
					</td>
					<td>
 						{{ $currBid->bid_price }} {{ $currBid->bid_currency }}
 						<br>
 						{{ $currBid->duration }}
 						@if($currUser->id === $bidder->id)
 							<br><br>
							<a href="{{ URL::route('project-unbid', $project->id) }}" class="btn btn-xs btn-warning pull-right unbid"><span class="glyphicon glyphicon-remove-sign"></span> Unbid</a>
 						@endif
					</td>
					
				</tr>
			@endforeach
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
        <h4 class="modal-title" id="myModalLabel">Bid</h4>
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

@include('ITDC_Project.home.comments.index', ['comments' => $comments, 'user' => $currUser, 'project' => $project])

<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<script>

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

	function getDocHeight() {
          var doc = document;
          return Math.max(
              Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight),
              Math.max(doc.body.offsetHeight, doc.documentElement.offsetHeight),
              Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
          );
     }
</script>
@stop
