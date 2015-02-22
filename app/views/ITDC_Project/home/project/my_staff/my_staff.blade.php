@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif

<head>
	<title>My Staff</title>
</head>
<hr/>
<ul id="my_nav_links">
	<a href="{{ URL::route('staff-my', 'projects') }}" class="btn btn-sm btn-default" id="my_projects_btn">My Projects</a>
	<a href="{{ URL::route('staff-my', 'bids') }}" class="btn btn-sm btn-default" id="my_projects_btn">My Bids</a>
	<a href="{{ URL::route('staff-my', 'comments') }}" class="btn btn-sm btn-default" id="my_projects_btn">My Comments</a>
	<a href="{{ URL::route('staff-my', 'offers') }}" class="btn btn-sm btn-default" id="my_projects_btn">Offers</a>
	<a href="{{ URL::route('staff-my', 'suggested') }}" class="btn btn-sm btn-default" id="my_projects_btn">Suggested Projects</a>
</ul>

<div class="my_staff_container">
	@if(isset($projects)) 
		@include('ITDC_Project.home.project.my_staff.my_projects', ['projects' => $projects]);
	@elseif (isset($bids)) 
		@include('ITDC_Project.home.project.my_staff.my_bids', ['bids' => $bids]);
	@elseif (isset($comments)) 
		@include('ITDC_Project.home.project.my_staff.my_comments', ['comments' => $comments]);
	@elseif (isset($offers)) 
		@include('ITDC_Project.home.project.my_staff.my_offers', ['offers' => $offers]);
	@elseif (isset($suggested)) 
		@include('ITDC_Project.home.project.my_staff.my_suggested', ['suggested' => $suggested]);
	@endif
</div>
	

<a href="#" class="scrollToTop"></a>

<script type="text/javascript">

	/////// pagination wrap

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


	$('.project_description').hover(function () {
	    $(this).find('div').toggleClass('hide_1');
	});

	var url = window.location;
	// Will only work if string in href matches with location
	$('ul#my_nav_links a[href="'+ url +'"]').addClass('active');

	// Will also work for relative and absolute hrefs
	$('ul#my_nav_links a').filter(function() {
		var h = this.href;
		var real = url.href.substring(0, h.length);
		console.log(real);
		console.log(h);
		return h == real;
	}).parent().addClass('active');

</script>
@stop
