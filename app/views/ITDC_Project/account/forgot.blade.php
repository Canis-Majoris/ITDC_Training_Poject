@extends('layouts.home')
@section('ragac')

@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif

	<h1>Forgot Password</h1>
	{{ Form::open(array('route' => array('account-forgot-password-post'), 'method' => 'POST')) }}

	<div class="form-group">
		<?php $emailError =  null ; $error_border_class = null;?>
		@if($errors->has('email'))
			<?php $emailError =  $errors->first('email') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('email', 'E-mail', ['class'=>'control-label']); }}
		{{ Form::input('text', 'email', '', ['class'=>'form-control '.$error_border_class, 'id'=>'email']) }}
		<div class="error_message_small">
			{{ $emailError }}
		</div>
	</div>

	{{ Form::submit('Recover', ['class'=>'btn btn-primary pull-right'])}}
	{{ Form::close(); }}
@stop