@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif

<style>
	.jemaliko{
		position: relative;
		z-index:100;
	}
	.layer{
		position:absolute;
		width:100%;
		height:1000px;
		z-index:10;
		top:0;
		left:0;
	}
	#show-bid-form{
		position: relative;
		top:100px;
	}
	label{
		color:#fff;
	}
</style>
<div class="jemaliko">
	<h3>{{ $project->name }}</h3>
	<p>{{ User::find($project->user_id)->username }}</p>
	<p>
		{{ $project->description }}
	</p>
	<div>
		<span>Bid Count:</span> <span>{{ $project->bid_count }}</span>
	</div>
	<div>
		<span>Duration:</span> <span>{{ $project->duration }}</span>
	</div>
	<div>
		<span>Average Price:</span> <span>{{ $project->avg_price }}</span>
	</div>
	<div>
		<span>Salary:</span> <span>{{ $project->salary }}$ USD</span>
	</div>
	<div>
		@if 
		<button class="btn btn-success bid_here">Bid here bro</button>
		
	</div>
	<hr>
</div>
<div class="layer">	
<div id="show-bid-form" style="display:none;" class="container">
{{ Form::open(['route' => ['project-bid'], 'method' => 'POST', 'files' => true]) }}
	{{ Form::hidden('project_id', $project->id) }}
<div class="form-group">
	{{ Form::label('price', 'Pice', ['class'=>'control-label']); }}
	{{ Form::input('number', 'price', Input::old('price'), ['class'=>'form-control', 'id'=>'Pice']) }}
</div>
<div class="form-group">
	{{ Form::label('duration', 'Duration', ['class'=>'control-label']); }}
	{{ Form::input('text', 'duration', Input::old('duration'), ['class'=>'form-control', 'id'=>'Duration']) }}
</div>
	<div class="form-group">
		{{ Form::label('about_project', 'About Project Terms', ['class'=>'control-label']); }}
		{{ Form::textarea('description', Input::old('description'), ['class' => 'field form-control', 'size' => '30x5', 'id' => 'about_project_1']) }}
</div>
{{ Form::submit('Save', ['class'=>'btn btn-primary pull-right'])}}

{{ Form::close(); }}
</div>
</div>
<script>
	$('.bid_here').on('click',function(){
		$('#show-bid-form').show();
		$('.layer').css({'z-index':'1000','background':'rgba(0,0,0,.4)'});
	});
</script>
@stop
