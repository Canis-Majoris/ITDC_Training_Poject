@extends('layouts.home')
@section('ragac')

@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif
	
	<h1>
	{{ $user->firstname }} {{ $user->lastname }}

	<span class="label label-default">{{ $user->gender }}</span>
	</h1>
	@if($user->username == Auth::user()->username)
		<a href="{{ URL::route('edit') }}" class="btn btn-primary btn-info"><span class="glyphicon glyphicon-pencil"></span> Edit rofile</a>
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

@stop