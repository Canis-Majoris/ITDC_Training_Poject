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
	{{ Form::open(['route' => ['project-create-post'], 'method' => 'POST', 'files' => true]) }}
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
		{{ Form::label('currency', 'Currency', ['class'=>'control-label']); }}
		{{ Form::select('currency', $currencies, Input::old('currency'), ['class'=>'form-control', 'id'=>'Duration']) }}
	</div>
	<div class="form-group">
		{{ Form::label('duration', 'Duration', ['class'=>'control-label']); }}
		{{ Form::select('duration', $timespan, Input::old('duration'), ['class'=>'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::label('file', 'Upload Needed Files', ['class'=>'control-label']); }}
		{{ Form::file('file','',array('id'=>'','class'=>'')) }}
	</div>
	<div class="pr_type_container">
		@foreach($project_types as $pt)
		<div class="checkbox">
			<label>
				{{ Form::checkbox('pt_type[]', $pt->id, '', ['class' => 'field']) }}
				<h3>{{ strtoupper($pt->name) }}</h3>
				{{  $pt->description }}
			</label>
		</div>
		@endforeach
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