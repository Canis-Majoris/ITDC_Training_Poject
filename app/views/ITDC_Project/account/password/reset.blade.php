@extends('layouts.home')
@section('ragac')

@if(Session::has('error'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('error') }}
    </div>
@endif

{{ Form::open(array('route' => array('resert-password-post'), 'method' => 'POST')) }}

{{ Form::input('hidden', 'token', $token, ['class'=>'form-control']) }}
<div class="form-group">
	{{ Form::label('email', 'E-mail', ['class'=>'control-label']); }}
	{{ Form::input('email', 'email', '', ['class'=>'form-control', 'id'=>'email', 'placeholder' => 'Your Email']) }}
</div>
<div class="form-group">
	{{ Form::label('password', 'Password', ['class'=>'control-label']); }}
	{{ Form::input('password', 'password', '', ['class'=>'form-control', 'id'=>'password', 'placeholder' => 'Enter new password']) }}
</div>
<div class="form-group">
	{{ Form::label('password', 'Password', ['class'=>'control-label']); }}
	{{ Form::input('password', 'password_confirmation', '', ['class'=>'form-control', 'id'=>'password', 'placeholder' => 'Confirm new password']) }}
</div>

{{ Form::submit('Reset Password', ['class'=>'btn btn-primary pull-right'])}}
{{ Form::close(); }}

@stop