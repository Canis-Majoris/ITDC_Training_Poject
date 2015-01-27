@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif
@if(Session::has('status'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('status') }}
    </div>
@endif
<h2>Users</h2>
<hr>

<div class="">
	{{$users->appends(Input::all())->links()}}
</div>

<div class="fixedheader1">
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<th class="FLname">Firstname/Lastname</th>
			<th class="skillshow">Skills</th>
			<th class="skillshow">Courses</th>
			@if(Auth::check()&&Auth::user()->type==0)
				<th class="action1">Action</th>
			@endif
		</thead>
	</table>
</div>

<div class="scroll">
	<table class="table table-bordered table-hover table-striped">
		<tbody>
			@foreach($users as $user)
			<tr>
				<td class="FLname">
					<a href="{{ URL::route('user-profile', $user->username) }}">
						{{ $user->username}}
					</a>
				</td>
				<td class="skillshow">
					@foreach($user->skills as $skill)
						<?php $lvl = null; $seletced_skill = 'default'; $color_shade = null;  $s = null;
							$lvl = $skill->pivot->level; $seletced_skill = 'info'; $s = ', LVL:';
							$color_shade = 'style="background-color:hsl(120,40%,'.(100-$lvl).'%)"';
						?>

						<a href="{{ URL::to('#') }}" class="label label-{{ $seletced_skill }} bordered_1" {{ $color_shade }}>{{ $skill->name.$s.$lvl }}</a>
					@endforeach
				</td>
				<td class="skillshow">
				
					@foreach($user->courses as $course)
						<?php $lvl = null; $seletced_course = 'default'; $color_shade = null;  $s = null;
							$lvl = $course->pivot->mark; $seletced_course = 'info'; $s = ', LVL:';
							$color_shade = 'style="background-color:hsl(120,40%,'.(100-$lvl).'%)"';
						?>

						<a href="{{ URL::to('#') }}" class="label label-{{ $seletced_course }} bordered_1" {{ $color_shade }}>{{ $course->name.$s.$lvl }}</a>
					@endforeach
				</td>
				@if(Auth::check()&&Auth::user()->type==0)
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
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="">
	{{$users->appends(Input::all())->links()}}
</div>

<a href="#" class="scrollToTop"></a>

<script type="text/javascript">

/////// pagination wrap


	
</script>
@stop

<!-- ////////////////////////////////////////////////////// -->


@section('inline_login')
<form class="form-inline">
  <div class="form-group">
    <label class="sr-only" for="exampleInputEmail2">Email address</label>
    <input type="email" class="form-control input-sm" id="exampleInputEmail2" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label class="sr-only" for="exampleInputPassword2">Password</label>
    <input type="password" class="form-control input-sm" id="exampleInputPassword2" placeholder="Password">
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Remember me
    </label>
  </div>
  <button type="submit" class="btn btn-sm">Sign in</button>
</form>
@stop