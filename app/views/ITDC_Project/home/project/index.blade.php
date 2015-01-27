@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif


<div class="fixedheader1">
	<h3>Projects</h3>
	<hr>
</div>
<div class="">
	{{$projects->appends(Input::all())->links()}}
</div>
<div class="scroll">
	@foreach($projects as $project)
		<div class="project_wrapper">
			<a href="{{ URL::to('#') }}">
				{{ $project->name}}
			</a>
			<p>
				{{ $project->description}}
			</p>
			<div>
				{{ $project->currency}}
			</div>
			<div>
				{{ $project->user_id}}
			</div>
		</div>
	@endforeach
</div>

<div class="">
	{{$projects->appends(Input::all())->links()}}
</div>

<a href="#" class="scrollToTop"></a>

<script type="text/javascript">

/////// pagination wrap


	
</script>
@stop
