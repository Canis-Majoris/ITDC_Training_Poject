@extends('layouts.admin')
@section('content')

<h1>
	{{ $skill->name }}
	<span class="label label-default">{{ $skill->users()->count() }} Users</span>
</h1>
@stop