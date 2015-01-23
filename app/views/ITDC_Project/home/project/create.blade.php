@extends('layouts.admin')
@section('ragac')

<div class="action_wrapper_1">
	<h1>Create New Project</h1>
	<hr>

	@if($errors->any())
	<script type="text/javascript">
		var refreshKeep = true;
	</script>
	<ul>
		@foreach($errors->all() as $error)
		 	<li><h4>{{ $error }}</h4></li>
		@endforeach
	</ul>
	@endif
	{{ Form::open(array('route' => ['project-create-post'], 'method' => 'POST')) }}
	<div class="form-group">
		{{ Form::label('name', 'Name', ['class'=>'control-label']); }}
		{{ Form::input('text', 'name', Input::old('name'), ['class'=>'form-control', 'id'=>'Name']) }}
	</div>
		<div class="form-group">
			{{ Form::label('about_project', 'About Project', ['class'=>'control-label']); }}
			{{ Form::textarea('description', Input::old('description'), ['class' => 'field form-control', 'size' => '30x5', 'id' => 'about_project_1']) }}
	</div>
	<div class="form-group">
		{{ Form::label('salary', 'Salary', ['class'=>'control-label']); }}
		{{ Form::input('number', 'salary', Input::old('salary'), ['class'=>'form-control', 'id'=>'Salary']) }}
	</div>
	<div class="form-group">
		{{ Form::label('duration', 'Duration', ['class'=>'control-label']); }}
		{{ Form::input('text', 'duration', Input::old('duration'), ['class'=>'form-control', 'id'=>'Duration']) }}
	</div>

	<div class="clear"></div>

	{{ Form::submit('Save', ['class'=>'btn btn-primary pull-right'])}}

	{{ Form::close(); }}
</div>


<script type="text/javascript">

	CKEDITOR.replace('about_project_1', {
		uiColor: '#E6E6E6',
		language: 'ka'
	});
</script>
@stop