<div class="scroll" id="my_bids_wrapper">

	<div class="fixedheader1">
		<h2>My Bids</h2>
		<hr>
	</div>
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
			<div class="my_bid_price pull-right"><b>My Terms</b> <span>Price: {{$bid->pivot->bid_price }} {{$bid->pivot->bid_currency }}; Timeline: {{$bid->pivot->duration }}</span></div>
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
				<a href="{{ URL::route('project-unbid', $pr->id) }}" class="btn btn-xs btn-danger pull-right remove edge_btn"><span class="glyphicon glyphicon-remove-sign"></span> Remove</a>
			@endif
			<div class="clear"></div>
		</div>
	@endforeach

	<?php Paginator::setPageName('page_b'); ?>
	{{ $bids->links(); }}
</div>
<script type="text/javascript">
	$(function () {
	  $('.glyphicon-star').tooltip({'title':'Bid Accepted!', 'placement':'left'})
	});
	$(function () {
	  $('.your_bid_declined').tooltip({'title':'Bid Declined, or Project Removed', 'placement':'left'})
	});
</script>
