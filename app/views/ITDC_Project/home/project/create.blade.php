@extends('layouts.admin')
@section('ragac')

<div class="input_wrapper_3">
	<h1>Create New Project</h1>
	<hr/>
	{{ Form::open(['route' => ['project-create-post'], 'method' => 'POST', 'files' => true]) }}
	<div class="form-group input-group-lg">
		<?php $projectName =  null ; $error_border_class = null;?>
		@if($errors->has('name'))
			<?php $projectName =  $errors->first('name') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('name', 'Project Name:', ['class'=>'control-label '.$error_border_class]); }} <span class="glyphicon glyphicon-question-sign" id="pr_name"></span>
		{{ Form::input('text', 'name', Input::old('name'), ['class'=>'form-control '.$error_border_class, 'id'=>'Name']) }}
		<div class="error_message_small">
			{{ $projectName }}
		</div>
	</div>
	<hr/>
	<div class="form-group">
		<?php $projectDescription =  null ; $error_border_class = null;?>
		@if($errors->has('description'))
			<?php $projectDescription =  $errors->first('description') ; $error_border_class = 'error_border';?>
		@endif
		{{ Form::label('about_project', 'Describe your project in detail:', ['class'=>'control-label '.$error_border_class]); }} <span class="glyphicon glyphicon-question-sign" id="pr_description"></span>
		{{ Form::textarea('description', Input::old('description'), ['class' => 'field form-control '.$error_border_class, 'size' => '30x5', 'id' => 'about_project_1']) }}
		<div class="error_message_small">
			{{ $projectDescription }}
		</div>
	</div>
	<hr/>
	<div>
		<div class="form-group pull-left">
			<?php $projectSalary =  null ; $error_border_class = null;?>
			@if($errors->has('salary'))
				<?php $projectSalary =  $errors->first('salary') ; $error_border_class = 'error_border';?>
			@endif
			{{ Form::label('salary', 'Salary', ['class'=>'control-label '.$error_border_class]); }} <span class="glyphicon glyphicon-question-sign" id="pr_salary"></span>
			{{ Form::input('number', 'salary', Input::old('salary'), ['class'=>'form-control '.$error_border_class, 'id'=>'Salary']) }}
			<div class="error_message_small">
				{{ $projectSalary }}
			</div>
		</div>
		<div class="form-group pull-left" style="margin-left:3%;">
			{{ Form::label('currency', 'Currency', ['class'=>'control-label']); }}
			{{ Form::select('currency', $currencies, Input::old('currency'), ['class'=>'form-control', 'id'=>'Duration']) }}
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="form-group">
		{{ Form::label('duration', 'Duration', ['class'=>'control-label']); }}
		{{ Form::select('duration', $timespan, Input::old('duration'), ['class'=>'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::label('file', 'Upload Needed Files', ['class'=>'control-label']); }}
		{{ Form::file('file','',array('id'=>'','class'=>'')) }}
	</div>
	<hr/>
	<div>
		<h4>Skills</h4>
		@foreach($skills as $skill)
			<?php $checked = false; $lvl = null;?>
			<div class="col-md-4 select_additional_wrapper_1">
				{{ Form::label($skill->id,$skill->name , ['class'=>'control-label pad_sk']) }}	
				{{ Form::checkbox('skill[]',$skill->id, $checked, ['class' => 'check_1 pad_sk']  ) }}
				<div class="lvl_inp">
					{{ Form::input('text', 'level['.$skill->id.']', $lvl, ['class'=>'form-control', 'placeholder' => 'Skill level'] ) }}
				</div>
			</div>
		@endforeach
	</div>
	<div class="clear"></div>
	<div class="pr_type_container">
		<h2>Project Types <small>(Optional)</small></h2>
		<hr>
		@foreach($project_types as $pt)
		<?php $checked1 = false; $active1 = 'active';?>
		<div class="checkbox btn-group" data-toggle="buttons">
			<label class="btn btn-primary {{ $checked1 == true ? 'active' : '' }} btn-lg outline">
				{{ Form::checkbox('pt_type[]', $pt->id, $checked1, ['class' => 'field']) }}
				<h3>{{ strtoupper($pt->name) }}</h3>
				<p>{{  $pt->description }}</p>
			</label>
		</div>
		@endforeach
	</div>
	
	<div class="clear"></div>

	{{ Form::submit('Create Project', ['class'=>'btn btn-lg btn-success pull-right', 'id' => 'sendEdit', 'data-loading-text' => 'Creating...', 'autocomplete' => 'off'])}}

	{{ Form::close(); }}
	<div class="clear"></div>
</div>


<script type="text/javascript">

	CKEDITOR.replace('about_project_1', {
		uiColor: '#E6E6E6',
		language: 'ka'
	});

	$(document).ready(function(){
		$('#sendEdit').on('click', function () {
		    var $btn = $(this).button('loading');
		});
	});
</script>
@stop