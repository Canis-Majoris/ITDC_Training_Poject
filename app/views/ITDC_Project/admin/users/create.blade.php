@extends('layouts.admin')
@section('content')
<h1>Create New User</h1>
<hr>

@if($errors->any())
<script type="text/javascript">
	var refreshKeep = true;
</script>
<ul>
	@foreach($errors->all() as $error)
	 	<li><h4>{{ $error }}</h4></li>
	@endforeach
</ul>
@endif
{{ Form::open(array('route' => ['admin.user.store'], 'method' => 'POST')) }}
<div class="form-group">
	{{ Form::label('username', 'Username', ['class'=>'control-label']); }}
	{{ Form::input('text', 'username', Input::old('username'), ['class'=>'form-control', 'id'=>'username']) }}
</div>
<div class="form-group">
	{{ Form::label('firstname', 'Firstname', ['class'=>'control-label']); }}
	{{ Form::input('text', 'firstname', Input::old('firstname'), ['class'=>'form-control', 'id'=>'firstname']) }}
</div>

<div class="form-group">
	{{ Form::label('lastname', 'Lastname', ['class'=>'control-label']); }}
	{{ Form::input('text', 'lastname', Input::old('lastname'), ['class'=>'form-control', 'id'=>'lastname']) }}
</div>

<div class="form-group">
	{{ Form::label('email', 'E-mail', ['class'=>'control-label']); }}
	{{ Form::input('text', 'email', Input::old('email'), ['class'=>'form-control', 'id'=>'email']) }}
</div>

<div class="form-group">
	{{ Form::label('password', 'Password', ['class'=>'control-label']); }}
	{{ Form::input('password', 'password', '', ['class'=>'form-control', 'id'=>'password']) }}
</div>
<div class="form-group">
	{{ Form::label('gender', 'Gender', ['class'=>'control-label']) }}
	<div class="gend_wrap_1">
		<label class="radio-inline">
			 {{ Form::radio('gender', '1', Input::old('gender')) }} Male
		</label>
		<label class="radio-inline">
			 {{ Form::radio('gender', '0', Input::old('gender')) }} Female
		</label>
	</div>

</div>
<div class="form-group">
	{{ Form::label('type', 'Type', ['class'=>'control-label']); }}

	<div class="type_wrap_1">
		<label class="radio-inline">
			 {{ Form::radio('type', '2', Input::old('type')) }} ფიზიკური პირი
		</label>
		<label class="radio-inline">
			 {{ Form::radio('type', '3', Input::old('type')) }} ორგანიზაცია
		</label>
	</div>
</div>
<div class="form-group" id="company_name_input" style="display:none">
	{{ Form::label('company came', 'Company Name', ['class'=>'control-label']); }}

	{{ Form::input('text', 'company_name', Input::old('company_name'), ['class'=>'form-control', 'id'=>'comp_name_1']); }}
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
<h4>skills</h4>
@foreach($skills as $skill)
	<?php $checked = false; $lvl = null;?>

	<div class="col-md-4">
		{{ Form::label($skill->id,$skill->name , ['class'=>'control-label pad_sk']) }}	
		{{ Form::checkbox('skill[]',$skill->id, $checked, ['class' => 'check_1 pad_sk']  ) }}
		<div class="lvl_inp">
			{{ Form::input('text', 'level['.$skill->id.']', $lvl, ['class'=>'form-control', 'placeholder' => 'Skill level'] ) }}
		</div>
	
	</div>
@endforeach
</div>

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

	$(document).ready(function () {
	    $('#checkbox1').change(function () {
	      $('#autoUpdate').fadeToggle();
	    });
	});
</script>
@stop