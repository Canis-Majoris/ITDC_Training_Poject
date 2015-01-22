@extends('layouts.admin')
@section('content')
<div class="action_wrapper_1">
	{{ Form::open(array('route' => ['admin.skill.store'], 'method' => 'POST')) }}
	<h1>Create New Skill</h1>
	<hr>
	<div class="form-group">
		{{ Form::label('name', 'Name', ['class'=>'control-label']); }}
		{{ Form::input('text', 'name', '', ['class'=>'form-control', 'id'=>'name']) }}
	</div>
	{{ Form::submit('Save', ['class'=>'btn btn-primary pull-right'])}}

	{{ Form::close(); }}
</div>
@stop