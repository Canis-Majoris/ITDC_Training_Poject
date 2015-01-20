<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">
	<title>Students</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link href="{{ URL::asset('res/css/tagbar.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('res/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('res/css/bootstrap-theme.css') }}" rel="stylesheet">
	<script type="text/javascript" src="{{ URL::asset('res/js/jquery.js') }}"></script>
	<script src="{{ URL::asset('res/js/bootstrap.min.js') }}"></script>
	<script src="{{ URL::asset('res/js/backtotop.js') }}"></script>
	<script src="{{ URL::asset('res/js/users/addphone.js') }}"></script>
	<script src="{{ URL::asset('res/js/jscroll/jquery.jscroll.min.js') }}"></script>
  <script src="{{ URL::asset('packages/ckeditor/ckeditor.js') }}"></script>


  <link rel="stylesheet" href="http://student.itdc.ge/g.xomeriki/ci/CSS/dashboard.css">
</head>
<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
				    <li><a href="{{ URL::route('home') }}">Home</a></li>
				    <li><a href="{{ URL::route('account-sign-out') }}">Log Out</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>


    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="{{ URL::to('admin/user') }}">Users</a></li>
            <li class="active"><a href="{{ URL::to('admin/skill') }}">Skills</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				@yield('content')
        </div>
      </div>
    </div>

	
</body>
</html>
