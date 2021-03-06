@extends('layouts.admin')
@section('content')

<h1>
	{{ $user->firstname }} {{ $user->lastname }}
	<span class="label label-default">{{ $user->gender }}</span>
</h1>

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

@stop