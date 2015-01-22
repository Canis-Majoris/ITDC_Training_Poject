@extends('ITDC_Project.admin.users.index')
@section('usr_skl')

<div class="">
	{{$users->appends(Input::all())->links()}}
</div>

<div class="clear"></div>

<div class="fixedheader1">
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<th class="FLname">Firstname/Lastname</th>
			<th class="skillshow">Skills</th>
			<th class="skillshow">Courses</th>
			<th colspan=2 class="action1">Action</th>
		</thead>
	</table>
</div>

<div class="scroll">
	<table class="table table-bordered table-hover table-striped">
		<tbody>
			@foreach($users as $user)
			<tr>
				<td class="FLname">
					<a href="{{ URL::to('admin/user/'.$user->id) }}">
						{{ $user->username}}
					</a>
				</td>
				<td class="skillshow">
					@foreach($user->skills as $skill)
						<?php $lvl = null; $seletced_skill = 'default'; $color_shade = null;  $s = null;?>
						@if(in_array($skill->name, $tagname))
						<?php 
							$lvl = $skill->pivot->level; $seletced_skill = 'info'; $s = ', LVL:';
							$color_shade = 'style="background-color:hsl(120,40%,'.(100-$lvl).'%)"';
						?>
						@endif
						<a href="{{ URL::to('tag/'.$skill->name) }}" class="label label-{{ $seletced_skill }} bordered_1" {{ $color_shade }}>{{ $skill->name.$s.$lvl }}</a>
					@endforeach
				</td>
				<td class="skillshow">
				
					@foreach($user->courses as $course)
						<?php $lvl = null; $seletced_course = 'default'; $color_shade = null;  $s = null;?>
						@if(in_array($course->name, $courseTagname))
						<?php 
							$lvl = $course->pivot->mark; $seletced_course = 'info'; $s = ', LVL:';
							$color_shade = 'style="background-color:hsl(120,40%,'.(100-$lvl).'%)"';
						?>
						@endif
						<a href="{{ URL::to('#') }}" class="label label-{{ $seletced_course }} bordered_1" {{ $color_shade }}>{{ $course->name.$s.$lvl }}</a>
					@endforeach
				</td>
				<td class="edit1">
					<a href="{{ URL::to('admin/user/'.$user->id.'/edit') }}" class="btn btn-primary btn-xs">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>
				</td>
				<td class="delete1">
					{{ Form::open(array('route' => array('admin.user.destroy', $user->id), 'method' => 'delete', 'class' => 'delete_user')) }}
			    		<button type="submit" class="btn btn-default btn-xs">
			    			<i class="glyphicon glyphicon-remove text-danger"></i>
			    		</button>
					{{ Form::close() }}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="">
	{{$users->appends(Input::all())->links()}}
</div>

	<!--<ul>
	    @foreach($users as $m)
	        <li>{{$m->username}}</li>
	    @endforeach


</div> -->

<script type="text/javascript">

	
	/*var counter = <?php echo $users->count(); ?>;
	if (counter>=30) {
		$(function() {
		    $('.scroll').jscroll({
		        autoTrigger: true,
		        nextSelector: '.pagination li.active + li a', 
		        contentSelector: 'div.scroll',
		        loadingHtml: '<div class="loadimagediv"><img class="loadimage" src="http://i.imgur.com/vj7hM7b.gif"/></div>',
		        callback: function() {
		            $('ul.pagination:visible:first').hide();
		       }
		    });
		});
	};*/

	
	
</script>
@stop