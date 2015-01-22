@extends('layouts.admin')
@section('content')
<div class="action_wrapper_1">
	<h1>
		{{ $skill->name }}
		<span class="label label-default">{{ $skill->users()->count() }} Users</span>
	</h1>
</div>
@stop