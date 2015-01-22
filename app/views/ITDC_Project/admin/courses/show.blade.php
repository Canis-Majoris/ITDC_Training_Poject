@extends('layouts.admin')
@section('content')
<div class="action_wrapper_1">
	<h1>
		{{ $course->name }}
		<span class="label label-default">{{ $course->users()->count() }} Users</span>
	</h1>
</div>
@stop