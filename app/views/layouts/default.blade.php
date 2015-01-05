
<div class="flash">
@if(Session::get('flash_message'))
	<div class="alert alert-warning alert-dismissible" role="alert" style="margin-bottom:50px;">
	  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	  <strong>{{ Session::get('flash_message') }}</strong>
	</div>
@endif
</div>
