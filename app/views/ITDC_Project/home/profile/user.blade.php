@extends('layouts.home')
@section('ragac')

@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif
	
	<h1 class="user_profile_header_1">
	@if($user->avatar)
		<div class="avatar_wrap">
			<img src="/uploads/{{ $user->avatar }}" width="60px" height="60px" />	
		</div>
	@endif
	{{ $user->firstname }} {{ $user->lastname }}

	<span class="label label-default">{{ $user->gender }}</span>
	</h1>
	@if(Auth::check())
		@if($user->username == Auth::user()->username)
			<a href="{{ URL::route('edit') }}" class="btn btn-primary btn-info pull-right"><span class="glyphicon glyphicon-pencil"></span> Edit rofile</a>
		@endif
	@endif
	<div class="stud_contact_info">
		<h2 class="stud_contact_info_header">საკონტაქტო ინფორმაცია</h2>
		<h3 class="stud_contact_info_header">ელ. ფოსტა</h3>
		<div class="well well-sm">{{ $user->email }}</div>
		<h3 class="stud_contact_info_header">ტელეფონ(ებ)ი</h3>
		<ul class="list-group">
			@foreach($user->phones as $phone)
			<li class="list-group-item">{{ $phone->phone }}</li>
			@endforeach
		</ul>
	</div>

	@if($user->type == 0 || $user->type == 1)
	<h3>Skills</h3>
	<div class="list_user_skills_1">
		@foreach($user->skills as $skill)
			<?php $lvl = null; $seletced_skill = 'default'; $color_shade = null;  $s = null;
				$lvl = $skill->pivot->level; $seletced_skill = 'info'; $s = ', LVL:';
				$color_shade = 'style="background-color:hsl(120,40%,'.(100-$lvl).'%)"';
			?>
			<a href="{{ URL::to('#') }}" class="label label-{{ $seletced_skill }} bordered_1" {{ $color_shade }}>{{ $skill->name.$s.$lvl }}</a>
		@endforeach
	</div>
	@endif

@stop