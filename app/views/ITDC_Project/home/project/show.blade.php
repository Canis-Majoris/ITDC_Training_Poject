@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible" style="z-index:2000; position:relative;">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif

<style>
	
</style>
<div class="jemaliko">
	<div class="jumbotron">
		<h2>{{ $project->name }}</h2>
		
		<hr/>
		<small class="pull-right"> created {{ $project->created_at->diffForHumans() }} by <a href="{{ URL::route('user-profile', $creator->username) }}">{{ $creator->username }}</a></small>
		<p>
			{{ $project->description }}
		</p>
		<div>
			<span>Duration:</span> <span>{{ $project->duration }}</span>
		</div>
		<div>
			<span>Average Price:</span> <span>{{ $project->avg_price }} {{ $project->currency }}</span>
		</div>
		<div>
			<span>Salary:</span> <span>{{ $project->salary }} {{ $project->currency }}</span>
		</div>
		<div>
			<span>Project Types:</span> <span>{{ $project->project_type_id }}</span>
		</div>
		<br>
		@if(!isset($project->users()->where('user_id', '=', $currUser->id)->first()->pivot))
		<div>
			<button class="btn btn-lg btn-primary bid_here"><span class="glyphicon glyphicon-certificate"></span> Bid on This Project</button>
		</div>
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
					Freelancers Bidding <span>({{$bidders->count()}})</span>
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
								<img src="/uploads/{{ $bidder->avatar }}" />
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
					</td>
					
					
				</tr>
			@endforeach
		</table>
	</div>
	<hr>
</div>

<div class="layer">
	<?php $show_bid_fill = 'none';?>
	@if($errors->has())
		<?php $show_bid_fill = 'block';?>
	@endif
	<div id="show-bid-form" style="display:{{ $show_bid_fill }};" class="container">
		<button id="closeBid" title="Close" class="btn btn-xs btn-danger">
			<span class="glyphicon glyphicon-remove"></span>
		</button>
		<br>
		{{ Form::open(['route' => ['project-bid'], 'method' => 'POST', 'files' => true]) }}
			{{ Form::hidden('project_id', $project->id) }}
			<div class="form-group">
				{{ Form::label('price', 'Pice', ['class'=>'control-label']); }}
				{{ Form::input('number', 'price', Input::old('price'), ['class'=>'form-control', 'id'=>'Pice']) }}
				{{ Form::select('bid_currency', $currencies, Input::old('bid_currency'), ['class'=>'form-control']) }}
			</div>
			<div class="form-group">
				{{ Form::label('duration', 'Duration', ['class'=>'control-label']); }}
				{{ Form::select('duration', $timespan, Input::old('duration'), ['class'=>'form-control']) }}
			</div>
				<div class="form-group">
					{{ Form::label('about_project', 'About Project Terms', ['class'=>'control-label']); }}
					{{ Form::textarea('description', Input::old('description'), ['class' => 'field form-control', 'size' => '30x10', 'id' => 'about_project_1']) }}
			</div>
			{{ Form::submit('Send', ['class'=>'btn btn-primary pull-right'])}}

		{{ Form::close(); }}
	</div>
</div>
<script>

	

	$('.bid_here').on('click',function(){
		$('#show-bid-form').show();
		$('.layer').css({'z-index':'1000','background':'rgba(0,0,0,.4)'});
	});

	$('#closeBid').click(function(){
		//event.preventDefault();
		$('#show-bid-form').hide();
		$('.layer').css({'z-index':'10','background':'#fff'});
	});
	if($('#show-bid-form').is(':visible')){
		$('.layer').css({'z-index':'1000','background':'rgba(0,0,0,.4)'});
	}

	CKEDITOR.replace('about_youtself_1', {
		uiColor: '#E6E6E6',
		language: 'ka'
	});
</script>
@stop
