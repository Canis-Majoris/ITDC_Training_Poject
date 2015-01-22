@extends('layouts.admin')
@section('content')
<div class="action_wrapper_1">
	@if(Session::has('message'))
	    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
	    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
	        {{ Session::get('message') }}
	    </div>
	@endif
	<h1>Courses</h1>
	<hr>
	<p class="text-right pull-right">
		<a href="{{ URL::to('admin/course/create') }}" class="btn btn-success">
			<i class="glyphicon glyphicon-plus"></i> Create Skill
		</a>
	</p>
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<th>Name</th>
			
			<th colspan="2" class="col-xs-1">Action</th>
		</thead>
		<tbody>
		@foreach($courses as $course)
		<tr>
			<td>
				<a href="{{ URL::to('admin/course/'.$course->id) }}">
					{{ $course->name }}
				</a>
			</td>
			
			<td>
				<a href="{{ URL::to('admin/course/'.$course->id.'/edit') }}" class="btn btn-primary btn-xs">
					<i class="glyphicon glyphicon-pencil"></i>
				</a>
			</td>
			<td>
				{{ Form::open(array('route' => array('admin.course.destroy', $course->id), 'method' => 'delete' , 'class' => 'delete_form')) }}
		    		<button type="submit" class="delete btn btn-default btn-xs">
		    			<i class="glyphicon glyphicon-remove text-danger"></i>
		    		</button>
				{{ Form::close() }}
			</td>
		</tr>
		@endforeach
		</tbody>
		
	</table>
</div>
<script type="text/javascript">
	$('form.delete_form').submit(function(e){
		if(confirm("Do you really want to delete course?")){

		}else{
			e.preventDefault();
		}	
	});
</script>
@stop

