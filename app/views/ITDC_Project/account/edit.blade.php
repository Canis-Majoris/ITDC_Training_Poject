@extends('layouts.home')
@section('ragac')
<script type="text/javascript">
	$("input.question").click(function(){
	 $(this).next(".answer").toggle();
	}); 
	
</script>
{{ Form::open(array('route' => array('admin.user.update', $user->id), 'method' => 'PUT')) }}


<div class="form-group">
	{{ Form::label('firstname', 'Firstname', ['class'=>'control-label']); }}
	{{ Form::input('text', 'firstname', $user->firstname, ['class'=>'form-control', 'id'=>'firstname']) }}
</div>

<div class="form-group">
	{{ Form::label('lastname', 'Lastname', ['class'=>'control-label']); }}
	{{ Form::input('text', 'lastname', $user->lastname, ['class'=>'form-control', 'id'=>'lastname']) }}
</div>

<div class="form-group">
	{{ Form::label('email', 'E-mail', ['class'=>'control-label']); }}
	{{ Form::input('text', 'email', $user->email, ['class'=>'form-control', 'id'=>'email']) }}
</div>

<div class="form-group">
	{{ Form::label('password', 'Old Password', ['class'=>'control-label']); }}
	{{ Form::input('password', 'old_password', '', ['class'=>'form-control', 'id'=>'password', 'placeholder' => 'Enter new password']) }}
</div>

<div class="form-group">
	{{ Form::label('password', 'Password', ['class'=>'control-label']); }}
	{{ Form::input('password', 'password', '', ['class'=>'form-control', 'id'=>'password', 'placeholder' => 'Enter new password']) }}
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
	<?php  $oldPhones = $user->phones; 
	?>
	<div class="form-group">
		{{ Form::label('phone', 'Phone', ['class'=>'control-label']); }}

		@if(sizeof($oldPhones)!=0)
			@foreach($oldPhones as $pId => $v)
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
	
</div>
<input type="button" value="ტელეფონის დამატება" id="phoneadd" class="btn btn-default">
<div class="form-group">

<h4>Skills</h4>
@foreach($skills as $skill)
	<?php $checked = false; $lvl = null;?>
	@foreach($user->skills as $user_skill)
		@if($skill->id==$user_skill->id)
			<?php $checked = true; $lvl = $user_skill->pivot->level; ?> 
		@endif
	@endforeach
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
	
</script>



@stop
