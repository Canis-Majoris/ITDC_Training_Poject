@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif
<table class="table table-bordered table-hover table-striped">
		<tbody>
			@foreach($users as $user)
			<tr>
				<td class="FLname">
					<a href="{{ URL::to('admin/user/'.$user->id) }}">
						{{ $user->username}}
					</a>
				</td>
				<td class="gend1">{{ $user->gender }}</td>
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