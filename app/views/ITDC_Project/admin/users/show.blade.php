@extends('layouts.admin')
@section('content')

<div class="col-md-4">
	<h1>
	@if($user->avatar)
		<div class="avatar_wrap">
			<img src="/uploads/{{ $user->avatar }}" width="60px" height="60px" />	
		</div>
	@endif
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
			<li class="list-group-item"><p class="phones">{{ $phone->phone }}</p></li>
			@endforeach
		</ul>
	</div>
</div>

<script type="text/javascript">
	$('.phones').text(function(i, text) {
	    $('.phones').text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
	});
</script>
@stop