@extends('layouts.admin')
@section('content')
<div class="action_wrapper_1">
	{{ Form::open(array('route' => array('admin.course.update', $course->id), 'method' => 'PUT')) }}
	<h1>Edit Course</h1>
	<hr>
	<div class="form-group">
		{{ Form::label('name', 'Name', ['class'=>'control-label']); }}
		{{ Form::input('text', 'name', $course->name, ['class'=>'form-control', 'id'=>'course_name']) }}
	</div>
	{{ Form::submit('Save', ['class'=>'btn btn-primary pull-right'])}}

	{{ Form::close(); }}
</div>
@stop