@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif
@if($bid!==null && $bid!==1)
	<?php 
		$pr = Project::find($bid->project_id);
	?>
	<?php 
		$pr = Project::find($bid->project_id);
		$bidder = User::find($bid->user_id);
		$status = 0; $bordeColor = null;
		if($bid->status == 1){
			$status = 1; 
			$bordeColor = 'green_border';
		}elseif ($bid->status == 2) {
			$status = 2; 
			$bordeColor = 'orange_border';
		}
	?>
	@if(Auth::user()->id !== $bidder->id)
		<h1 class="title">Offer By <span><a href="{{ URL::route('user-profile', $bidder->username) }}">{{ $bidder->username }}</a></span></h1>
	@endif
	<div class="bid_show_wraper {{ $bordeColor }}">
		<h2>Bidded <a href="{{ URL::route('project-show', $pr->id) }}">{{ $pr->name }}</a></h2>
		<small><span class="glyphicon glyphicon-time"></span> {{$bid->created_at->diffForHumans() }}</small>
		<hr/>
		<p>
			<span class="my_bid_comment">{{ $bid->comment }}</span>
		</p>
		<hr/>
		<div class="my_bid_price"><b>Terms</b> <span>Price: {{$bid->bid_price }} {{$bid->bid_currency }}; Timeline: {{$bid->duration }}</span></div>
		<br>
		@if(Auth::user()->id === $bidder->id)
			@if($status == 0)
				<a href="{{ URL::route('project-unbid', $pr->id) }}" class="btn btn-sm btn-warning pull-right unbid edge_btn"><span class="glyphicon glyphicon-remove-sign"></span> Unbid</a>
			@elseif($status == 1)
				<p class="good pull-right bid_condition_indicator_text">This Bid Has Been Accepted</p>
				<span class="glyphicon glyphicon-star pull-right" style="font-size:24px; color:green;"></span>
				<a href="{{ URL::route('project-unbid', $pr->id) }}" class="btn btn-sm btn-default pull-right decline edge_btn"><span class="glyphicon glyphicon-remove-sign"></span> Decline</a>
			@elseif($status == 2)
				<p class="orange pull-right bid_condition_indicator_text">This Bid Has Been Declined</p>
				<span class="glyphicon glyphicon-remove-sign pull-right your_bid_declined" style="font-size:24px; color:orange;"></span>
				<a href="{{ URL::route('project-unbid', $pr->id) }}" class="btn btn-sm btn-danger pull-right remove edge_btn"><span class="glyphicon glyphicon-remove-sign"></span> Remove</a>
			@endif
		@else
			@if($status == 0)
				<a href="{{ URL::route('bid-accept',[$bidder->id, $pr->id]) }}" class="btn btn-sm btn-success pull-right accept"><span class="glyphicon glyphicon-ok-sign"></span> Accept</a>
			@elseif($status == 1)
				<span class="glyphicon glyphicon-ok-sign pull-right" style="font-size:24px; color:green;"></span>
				<p class="good pull-right edge_btn">This Offer Has Been Accepted</p>
			@elseif($status == 2)
				<span class="glyphicon glyphicon-remove-sign pull-right" style="font-size:24px; color:orange;"></span>
				<p class="orange pull-right edge_btn">This Offer Has Been Declined</p>
			@endif
		@endif
	@else
		<h2 class="center"><i>This Bid Has Been Removed</i></h2>
	@endif
	<div class="clear"></div>
</div>
<script type="text/javascript">
	$('.unbid').on("click", function(e){
		if(confirm("Do you really want to Unbid?")){

		}else{
			e.preventDefault();
		}	
	});
	$('.accept').on("click", function(e){
		if(confirm("Do you really want to Accept?")){

		}else{
			e.preventDefault();
		}	
	});
	$('.decline').on("click", function(e){
		if(confirm("Do you really want to decline this offer?")){

		}else{
			e.preventDefault();
		}	
	});

	$('.remove').on("click", function(e){
		if(confirm("Remove Bid?")){

		}else{
			e.preventDefault();
		}	
	});

</script>
@stop