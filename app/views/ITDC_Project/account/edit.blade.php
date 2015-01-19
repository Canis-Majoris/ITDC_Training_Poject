@extends('layouts.home')
@section('ragac')

@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif

<h1>Edit Profile</h1>
<hr/>
{{ Form::open(array('route' => array('edit-post'), 'method' => 'POST')) }}


<div class="form-group">
	<?php $firstnameError =  null ; $error_border_class = null;?>
	@if($errors->has('firstname'))
		<?php $firstnameError =  $errors->first('firstname') ; $error_border_class = 'error_border';?>
	@endif
	{{ Form::label('firstname', 'Firstname', ['class'=>'control-label']); }}
	{{ Form::input('text', 'firstname', $user->firstname, ['class'=>'form-control '.$error_border_class, 'id'=>'firstname']) }}
	<div class="error_message_small">
		{{ $firstnameError }}
	</div>
</div>

<div class="form-group">
	<?php $lastnameError =  null ; $error_border_class = null;?>
	@if($errors->has('lastname'))
		<?php $lastnameError =  $errors->first('lastname') ; $error_border_class = 'error_border';?>
	@endif
	{{ Form::label('lastname', 'Lastname', ['class'=>'control-label']); }}
	{{ Form::input('text', 'lastname', $user->lastname, ['class'=>'form-control '.$error_border_class, 'id'=>'lastname']) }}
	<div class="error_message_small">
		{{ $lastnameError }}
	</div>
</div>

<div class="form-group">
	<?php $emailError =  null ; $error_border_class = null;?>
	@if($errors->has('email'))
		<?php $emailError =  $errors->first('email') ; $error_border_class = 'error_border';?>
	@endif
	{{ Form::label('email', 'E-mail', ['class'=>'control-label']); }}
	{{ Form::input('text', 'email', $user->email, ['class'=>'form-control '.$error_border_class, 'id'=>'email']) }}
	<div class="error_message_small">
		{{ $emailError }}
	</div>
</div>

<?php
	 $checked1 = null;
	if (Input::old('pass_change')) {
		$checked1 = 'checked';
	}
?>
<div id="ck-button">
   <label>
		<input type="checkbox" id="checkbox1" value="1" name="pass_change" {{ $checked1 }}/><span>Change Password</span>
	</label>
</div>

<div class="change_password" style="display:none;">
	<div class="form-group">
		<?php $oldPasswordError =  null ; $error_border_class = null;?>
		@if($errors->has('old_password'))
			<?php $oldPasswordError =  $errors->first('old_password') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('password', 'Old Password', ['class'=>'control-label']); }}
		{{ Form::input('password', 'old_password', '', ['class'=>'form-control disp_pas_change '.$error_border_class, 'id'=>'password', 'placeholder' => 'Enter current password']) }}
		<div class="error_message_small">
			{{ $oldPasswordError }}
		</div>
	</div>

	<div class="form-group">
		<?php $passwordError =  null ; $error_border_class = null;?>
		@if($errors->has('password'))
			<?php $passwordError =  $errors->first('password') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('password', 'New Password', ['class'=>'control-label']); }}
		{{ Form::input('password', 'password', '', ['class'=>'form-control disp_pas_change '.$error_border_class, 'id'=>'password', 'placeholder' => 'Enter new password']) }}
		<div class="error_message_small">
			{{ $passwordError }}
		</div>
	</div>

	<div class="form-group">
		<?php $confirm_passwordError =  null ; $error_border_class = null;?>
		@if($errors->has('confirm_password'))
			<?php $confirm_passwordError =  $errors->first('confirm_password') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('password', 'Confirm Password', ['class'=>'control-label']); }}
		{{ Form::input('password', 'confirm_password', '', ['class'=>'form-control disp_pas_change '.$error_border_class, 'id'=>'password', 'placeholder' => 'Confirm new password']) }}
		<div class="error_message_small"> 
			{{ $confirm_passwordError }}
		</div>
	</div>
</div>


<div class="form-group">
	{{ Form::label('gender', 'Gender', ['class'=>'control-label']) }}
	<div class="gend_wrap_1">
		<label class="radio-inline">
			 {{ Form::radio('gender', '1', $user->gender=='male') }} Male
		</label>
		<label class="radio-inline">
			 {{ Form::radio('gender', '0', $user->gender=='female') }} Female
		</label>
	</div>
</div>

<div class="phone_container" id="phonewrapper">
	<?php  
		$oldPhones = Input::old('phone'); 
		$currPhones = $user->phones;
	?>
	<div class="form-group">
		{{ Form::label('phone', 'Phone', ['class'=>'control-label']); }}
		@if(sizeof($currPhones)!=0)
			@foreach($currPhones as $pId => $v)
				@if($v->phone!=null)
				<div class="input-group phone_wrap_1">
				  	<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-phone-alt"></span></span>
					<input class="form-control phoneinput" id="phone" name="phone[]" type="text" value="<?=$v->phone ?>" aria-describedby="basic-addon1">
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
<div class="form-group">


{{ Form::submit('Save', ['class'=>'btn btn-primary pull-right'])}}

{{ Form::close(); }}
<script type="text/javascript">
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


	//Password Change Click Function //////////////////////////
	$('#buttonShowPassChange').on('click', function(e){
		
		$(".change_password").toggle();
	    $(this).toggleClass('class1');

 		if ($('.change_password').css('display') == 'none') {
       		$('.disp_pas_change').prop('disabled', true);
	    }
	    if ($('.change_password').css('display') == 'block') {
	        $('.disp_pas_change').removeAttr('disabled');
	    }   
	});

	if ($('.change_password').css('display') == 'none') {
       		$('.disp_pas_change').prop('disabled', true);
	    }
	    if ($('.change_password').css('display') == 'block') {
	        $('.disp_pas_change').removeAttr('disabled');
	    }   


    /*if( $('.change_password').is(':visible') ) {
	    $(".disp_pas_change").prop('disabled', false);
	}else{
		 $(".disp_pas_change").prop('disabled', treu);
	}*/
	$(document).ready(function () {
    	$('#checkbox1').change(function () {
	        if (!this.checked){
	        	$(".change_password").css("display", "none");
	           	$('.disp_pas_change').prop('disabled', true);
	        }
	        else{
	        	$(".change_password").css("display", "block");
	            $('.disp_pas_change').removeAttr('disabled');
	        }
	    });
	});

	if (!$('#checkbox1').is(':checked')){
    	$(".change_password").css("display", "none");
       	$('.disp_pas_change').prop('disabled', true);
    }
    else{
    	$(".change_password").css("display", "block");
        $('.disp_pas_change').removeAttr('disabled');
    }

	///////////////////////////////////////////////////////////
	
</script>



@stop
