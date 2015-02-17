@extends('layouts.home')
@section('ragac')

<div class="input_wrapper_3">
	<h1>User Registration</h1>
	<hr>

	{{ Form::open(['route' => ['account-create-post'], 'method' => 'POST', 'files' => true]) }}
	<div class="form-group">
		<?php $usernameError =  null ; $error_border_class = null;?>
		@if($errors->has('username'))
			<?php $usernameError =  $errors->first('username') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('username', 'Username *', ['class'=>'control-label']); }}
		{{ Form::input('text', 'username', '', ['class'=>'form-control '.$error_border_class, 'id'=>'username']) }}
		<div class="error_message_small">
			{{ $usernameError }}
		</div>
	</div>
	<div class="form-group">
		<?php $firstnameError =  null ; $error_border_class = null;?>
		@if($errors->has('firstname'))
			<?php $firstnameError =  $errors->first('firstname') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('firstname', 'Firstname *', ['class'=>'control-label']); }}
		{{ Form::input('text', 'firstname', '', ['class'=>'form-control '.$error_border_class, 'id'=>'firstname']) }}
		<div class="error_message_small">
			{{ $firstnameError }}
		</div>
	</div>

	<div class="form-group">
		<?php $lastnameError =  null ; $error_border_class = null;?>
		@if($errors->has('lastname'))
			<?php $lastnameError =  $errors->first('lastname') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('lastname', 'Lastname *', ['class'=>'control-label']); }}
		{{ Form::input('text', 'lastname', '', ['class'=>'form-control '.$error_border_class, 'id'=>'lastname']) }}
		<div class="error_message_small">
			{{ $lastnameError }}
		</div>
	</div>

	<div class="form-group">
		<?php $emailError =  null ; $error_border_class = null;?>
		@if($errors->has('email'))
			<?php $emailError =  $errors->first('email') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('email', 'E-mail *', ['class'=>'control-label']); }}
		{{ Form::input('text', 'email', '', ['class'=>'form-control '.$error_border_class, 'id'=>'email']) }}
		<div class="error_message_small">
			{{ $emailError }}
		</div>
	</div>

	<div class="form-group">
		<?php $passwordError =  null ; $error_border_class = null;?>
		@if($errors->has('password'))
			<?php $passwordError =  $errors->first('password') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('password', 'Password *', ['class'=>'control-label']); }}
		{{ Form::input('password', 'password', '', ['class'=>'form-control '.$error_border_class, 'id'=>'password']) }}
		<div class="error_message_small">
			{{ $passwordError }}
		</div>
	</div>

	<div class="form-group">
		<?php $confirm_passwordError =  null ; $error_border_class = null;?>
		@if($errors->has('password_confirmation'))
			<?php $confirm_passwordError =  $errors->first('password_confirmation') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('password_confirmation', 'Confirm Password *', ['class'=>'control-label']); }}
		{{ Form::input('password', 'password_confirmation', '', ['class'=>'form-control '.$error_border_class, 'id'=>'password_confirmation']) }}
		<div class="error_message_small"> 
			{{ $confirm_passwordError }}
		</div>
	</div>

	<div class="form-group">
		<?php $genderError =  null ; $error_border_class = null;?>
		@if($errors->has('gender'))
			<?php $genderError =  $errors->first('gender') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('gender', 'Gender', ['class'=>'control-label']) }}
		<div class="gend_wrap_1">
			<label class="radio-inline">
				 {{ Form::radio('gender', '1', '') }} Male
			</label>
			<label class="radio-inline">
				 {{ Form::radio('gender', '0', '') }} Female
			</label>
		</div>
		<div class="error_message_small"> 
			{{ $genderError }}
		</div>
	</div>
	<div class="form-group">
		<?php $typeError =  null ; $error_border_class = null;?>
		@if($errors->has('type'))
			<?php $typeError =  $errors->first('type') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('type', 'Type', ['class'=>'control-label']); }}

		<div class="type_wrap_1">
			<label class="radio-inline">
				 {{ Form::radio('type', '2', Input::old('type')|2) }} ფიზიკური პირი
			</label>
			<label class="radio-inline">
				 {{ Form::radio('type', '3', Input::old('type')) }} ორგანიზაცია
			</label>
		</div>
		<div class="error_message_small"> 
			{{ $typeError }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('file', 'Choose Avatar', ['class'=>'control-label']); }}
		{{ Form::file('file','',['id'=>'','class'=>'']) }}
	</div>
	<div class="form-group" id="company_name_input" style="display:none">
		<?php $company_nameError =  null ; $error_border_class = null;?>
		@if($errors->has('company_name'))
			<?php $company_nameError =  $errors->first('company_name') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('company came', 'Company Name *', ['class'=>'control-label']); }}
		{{ Form::input('text', 'company_name', Input::old('company_name'), ['class'=>'form-control '.$error_border_class, 'id'=>'comp_name_1', 'data-inputmask' => '"mask": "(999) 999-9999"', 'data-mask']); }}
		<div class="error_message_small"> 
			{{ $company_nameError }}
		</div>
	</div>
	<div>

	<div class="phone_container" id="phonewrapper">
		<?php  $oldPhones = Input::old('phone'); ?>
		<div class="form-group">
			{{ Form::label('phone', 'Phone', ['class'=>'control-label']); }}
			@if($oldPhones[0]!=null)
				@foreach($oldPhones as $pId => $v)
					@if($v!=null)
					<div class="input-group phone_wrap_1">
					  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-phone-alt"></span></span>
						<input class="form-control phoneinput" id="phone" name="phone[]" type="text" value="<?=$v ?>" aria-describedby="basic-addon1">
					</div>
						
					@endif
				@endforeach
			@else
			<div class="input-group">
				 <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-phone-alt"></span></span>
				<input class="form-control phoneinput" id="phone" name="phone[]" type="text" value="" aria-describedby="basic-addon1">
			</div>
			@endif
			
		</div>
		<span id="fooBar"> </span>
		
	</div>
		<input type="button" value="ტელეფონის დამატება" id="phoneadd" class="btn btn-default">
	</div>

	<div class="form-group">
		{{ Form::label('about_youtself', 'About Yourself', ['class'=>'control-label']); }}
		{{ Form::textarea('description', '', ['class' => 'field form-control', 'size' => '30x5', 'id' => 'about_youtself_1']) }}
	</div>
	{{ Form::Button('Save', ['class'=>'btn btn-primary pull-right', 'id' => 'sendCreate', 'data-loading-text' => 'Saving...', 'autocomplete' => 'off', 'type' => 'submit'])}}
	{{ Form::close(); }}
	<div class="clear"></div>
</div>


<script type="text/javascript">

	CKEDITOR.replace('about_youtself_1', {
		uiColor: '#E6E6E6',
		language: 'ka'
	});

	$(document).ready(function(){
		$('#sendCreate').on('click', function () {
		    var $btn = $(this).button('loading');
		});
	});

	var counter = 2;
	//var appendform = '';

	//if (localStorage.getItem("countPhones") != '') {
		//if (refreshKeep) {
			//appendform = localStorage.getItem("countPhones");
		//}
	//}
	
	$('#phoneadd').on('click', function() {
		var form = 
		'<div class="input-group phone_wrap_1">\
		<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-phone-alt"></span></span>\
		<input class="form-control phoneinput" id="phone" name="phone[]" type="text" value="" aria-describedby="basic-addon1">\
		</div>'
		//appendform+=form;
		//localStorage.setItem("countPhones", appendform);
		$('#phonewrapper').append(form);
		counter++;
	});
	//$('#phonewrapper').append(localStorage.getItem("countPhones"));

	$('#ragac').on('click', function(){
		console.log(localStorage.getItem("countPhones"));
	})
	
	$(".type_wrap_1 input[name='type']").click(function(){
	    if($('input:radio[name=type]:checked').val() == "3"){
	        $('#company_name_input').show();
	    }else $('#company_name_input').hide();
	});

	if($('input:radio[name=type]:checked').val() == "3"){
	        $('#company_name_input').show();
	}else $('#company_name_input').hide();
</script>

@stop