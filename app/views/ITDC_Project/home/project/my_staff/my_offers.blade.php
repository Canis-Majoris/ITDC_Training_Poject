
<div class="scroll" id="my_bids_wrapper">

	<div class="fixedheader1">
		<h2>Offers</h2>
		<hr>
	</div>
	@foreach($offers as $bid)
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
			<h4>Offered on <a href="{{ URL::route('project-show', $pr->id) }}">{{ $pr->name }}</a></h4>
			<small><span class="glyphicon glyphicon-time"></span> {{$bid->pivot->created_at->diffForHumans() }}</small>
			<div class="my_bid_price pull-right"><b>{{ $bidder->username }}'s Terms</b> <span>Price: {{$bid->pivot->bid_price }} {{$bid->pivot->bid_currency }}; Timeline: {{$bid->pivot->duration }}</span></div>
			<br>
			<p>
				<a href="{{ URL::route('user-profile', $bidder->username) }}">{{ $bidder->username }}</a> Wrote: <span class="my_bid_comment">{{ $bid->pivot->comment }}</span>
			</p>
			<br>
			<a href="{{ URL::route('bid-show', [$bidder->id, $bid->pivot->project_id]) }}" class="pull-left"><span class="glyphicon glyphicon-eye-open"></span> Show Offer</a>
			@if($status == 0)
				<a href="{{ URL::route('bid-accept',[$bidder->id, $pr->id]) }}" class="btn btn-xs btn-success pull-right accept"><span class="glyphicon glyphicon-ok-sign"></span> Accept</a>
			@elseif($status == 1)
				<span class="glyphicon glyphicon-ok-sign pull-right" style="font-size:24px; color:green;"></span>
			@elseif($status == 2)
				<span class="glyphicon glyphicon-remove-sign pull-right" style="font-size:24px; color:orange;"></span>
			@endif
			<div class="clear"></div>
		</div>
	@endforeach

	<?php Paginator::setPageName('page_e'); ?>
	{{ $offers->links(); }}

</div>