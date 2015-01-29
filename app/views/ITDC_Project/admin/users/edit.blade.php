@extends('layouts.admin')
@section('content')

<div class="action_wrapper_1">
	<h1>Edit User</h1>
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


	{{ Form::open(['route' => array('admin.user.update', $user->id), 'method' => 'PUT', 'files' => true]) }}

	<div class="form-group">
		{{ Form::label('username', 'Username', ['class'=>'control-label']); }}
		{{ Form::input('text', 'username', $user->username, ['class'=>'form-control', 'id'=>'firstname']) }}
	</div>

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
		{{ Form::input('email', 'email', $user->email, ['class'=>'form-control', 'id'=>'email']) }}
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

	<div class="form-group">
		{{ Form::label('type', 'Type', ['class'=>'control-label']); }}

		<div class="type_wrap_1">
			<label class="radio-inline">
				 {{ Form::radio('type', '0', $user->type=='0') }} ადმინისტრატორი
			</label>
			<label class="radio-inline">
				 {{ Form::radio('type', '1', $user->type=='1') }} სტუდენტი
			</label>
			<label class="radio-inline">
				 {{ Form::radio('type', '2', $user->type=='2') }} ფიზიკური პირი
			</label>
			<label class="radio-inline">
				 {{ Form::radio('type', '3', $user->type=='3') }} ორგანიზაცია
			</label>
		</div>
	</div>
	<div class="form-group" id="company_name_input" style="display:none">
		{{ Form::label('company came', 'Company Name', ['class'=>'control-label']); }}

		{{ Form::input('text', 'company_name', Input::old('company_name'), ['class'=>'form-control', 'id'=>'comp_name_1']); }}
	</div>
	<div class="form-group">
		{{ Form::label('file', 'Choose Avatar', ['class'=>'control-label']); }}
		{{ Form::file('file','',['id'=>'','class'=>'']) }}
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
			{{ Form::label('about_youtself', 'About Yourself', ['class'=>'control-label']); }}
			{{ Form::textarea('description', $user->description, ['class' => 'field form-control', 'size' => '30x5', 'id' => 'about_youtself_1']) }}
	</div>

	<div class="form-group">
		{{ Form::label('status', 'Status', ['class'=>'control-label']); }}
		<div class="type_wrap_1">
			<label class="radio-inline">
				 {{ Form::radio('status', '1', $user->status=='1') }} აქტიური
			</label>
			<label class="radio-inline">
				 {{ Form::radio('status', '0', $user->status=='0') }} დაბლოკილი
			</label>
		</div>
	</div>

	<div class="form-group">

		<h4>Skills</h4>
		@foreach($skills as $skill)
			<?php $checked = false; $lvl = null;?>
			@foreach($user->skills as $user_skill)
				@if($skill->id==$user_skill->id)
					<?php $checked = true; $lvl = $user_skill->pivot->level; ?> 
				@endif
			@endforeach
			<div class="col-md-4 select_additional_wrapper_1">
				{{ Form::label($skill->id,$skill->name , ['class'=>'control-label pad_sk']) }}	
				{{ Form::checkbox('skill[]',$skill->id, $checked, ['class' => 'check_1 pad_sk']  ) }}
				<div class="lvl_inp">
					{{ Form::input('text', 'level['.$skill->id.']', $lvl, ['class'=>'form-control', 'placeholder' => 'Skill level'] ) }}
				</div>
			
			</div>
		@endforeach

		<div class="clear"></div>
		<h4>Courses</h4>
		@foreach($courses as $course)
			<?php $checked = false; $lvl = null;?>
			@foreach($user->courses as $user_course)
				@if($course->id==$user_course->id)
					<?php $checked = true; $lvl = $user_course->pivot->mark; ?> 
				@endif
			@endforeach
			<div class="col-md-4 select_additional_wrapper_1">
				{{ Form::label($course->id,$course->name , ['class'=>'control-label pad_sk']) }}	
				{{ Form::checkbox('course[]',$course->id, $checked, ['class' => 'check_1 pad_sk']  ) }}
				<div class="lvl_inp">
					{{ Form::input('text', 'level_cr['.$course->id.']', $lvl, ['class'=>'form-control nerrow_inp_1', 'placeholder' => 'Course level'] ) }}
				</div>
			
			</div>
		@endforeach
	</div>

	<div class="clear"></div>

	{{ Form::submit('Save', ['class'=>'btn btn-primary pull-right'])}}
	<div class="clear"></div>
	{{ Form::close(); }}
</div>
<script type="text/javascript">

	CKEDITOR.replace('about_youtself_1', {
		uiColor: '#E6E6E6',
		language: 'ka'
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