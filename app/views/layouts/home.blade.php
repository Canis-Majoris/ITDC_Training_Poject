<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script> <!-- load angular -->

		<script src="{{ URL::asset('res/js/bootstrap.js') }}"></script>
		<script src="{{ URL::asset('res/js/backtotop.js') }}"></script>
		<script src="{{ URL::asset('res/js/users/addphone.js') }}"></script>
		<script src="{{ URL::asset('res/js/jscroll/jquery.jscroll.min.js') }}"></script>
		<script src="{{ URL::asset('packages/ckeditor/ckeditor.js') }}"></script>
		<link href="{{ URL::asset('res/css/rating/star-rating.min.css') }}" media="all" rel="stylesheet" type="text/css" />
		<script src="{{ URL::asset('res/js/rating/star-rating.min.js') }}" type="text/javascript"></script>
		<link href="{{ URL::asset('res/css/tagbar.css') }}" rel="stylesheet">
		<link href="{{ URL::asset('res/css/bootstrap.css') }}" rel="stylesheet">
		<link href="{{ URL::asset('res/css/bootstrap-theme.css') }}" rel="stylesheet">
		<link href="{{ URL::asset('res/css/test_style.css') }}" rel="stylesheet">

		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"> <!-- load fontawesome -->
		<script src="{{ URL::asset('res/angular/controllers/mainCtrl.js') }}"></script> <!-- load our controller -->
		<script src="{{ URL::asset('res/angular/services/commentService.js') }}"></script> <!-- load our controller -->
		<script src="{{ URL::asset('res/angular/app.js') }}"></script> <!-- load our controller -->

	</head>
	<body data-spy="scroll" data-target="#topnav">
		<nav class="navbar navbar-default navbar-fixed-top main_navbar" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand homebutton" href="{{ URL::route('home') }}">ITDC</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					
					<ul class="nav navbar-nav home_navbar">
					@if(Auth::check())
						<li class="user_prof_link pull-left">
							<a href="{{ URL::route('user-profile', Auth::user()->username) }}">
								@if(Auth::user()->avatar)
									<div class="navbar_avatar_wrap">
										<img src="/uploads/{{ Auth::user()->avatar }}" width="60px" height="60px" />	
									</div>
								@endif
								{{ Auth::user()->username }}
							</a>
						</li>
					@endif
						<li class="pull-left"><a href="{{ URL::route('users-show') }}">Users</a></li>
					@if(Auth::check())
						<li class="pull-left"><a href="{{ URL::route('project-create') }}">Create Project</a></li>
						<li class="pull-left"><a href="{{ URL::route('project-browse') }}">Browse Projects</a></li>
						<li class="dropdown pull-left">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Staff <span class="caret"></span></a>
				          <ul class="dropdown-menu" role="menu">
				            <li><a href="{{ URL::route('staff-my', 'projects') }}">My Projects</a></li>
				            <li><a href="{{ URL::route('staff-my', 'bids') }}">My Bids</a></li>
				            <li><a href="{{ URL::route('staff-my', 'comments') }}">My Comments</a></li>
				            <li><a href="{{ URL::route('staff-my', 'offers') }}">Offers</a></li>
				            <li><a href="{{ URL::route('staff-my', 'suggested') }}">Suggested Projects</a></li>

				          </ul>
				        </li>
						@if(Auth::user()->type == 0)
							<li class="dropdown pull-left">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Organisation <span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="{{ URL::to('admin/user') }}">Administrator Panel</a></li>
					            <li><a href="{{ URL::route('edit') }}">Edit Profile</a></li>
					            <li class="divider"></li>
					            <li><a href="#">Separated link</a></li>
					          </ul>
					        </li>
						@endif
						<li class="pull-left" id="logout" data-toggle="tooltip"><a href="{{ URL::route('account-sign-out') }}">
							<div class="glyphicon glyphicon-log-out"></div></a>
						</li>
						<li class="pull-left">@include('ITDC_Project.home.comments.showmy', ['user' => Auth::user()])</li>


					@endif
						<li class="pull-left"><a href='https://github.com/login/oauth/authorize?client_id=09696cd9626f7270e967' type="button" class="btn btn-success btn-sm  pull-right">
									  Add Github
									</a>
								</li>
								<li class="pull-left">
									<a href="{{ URL::route('github-detach') }}" type="button" class="btn btn-sm btn-danger  pull-right">
									  Remove Github
									</a>
								</li>
					</ul>
					@if(!Auth::check())
					<div class="login_inline_form pull-right">
					
						{{ Form::open(array('route' => 'account-sign-in-post', 'id' => 'inline-loginform', 'class' => 'form-inline', 'role' => 'form')) }}

							  <div class="form-group">

								  	<?php $emailError =  null ; $error_border_class = null;?>
									@if($errors->has('email_login'))
										<?php $emailError =  $errors->first('email_login') ; $error_border_class = 'error_border';?>
									@endif

									<div class="home-error_message_small">
										{{ $emailError }}
									</div>

								    <label class="sr-only" for="exampleInputEmail2">Email address</label>
							    	{{ Form::text('email_login','', array('id' => 'login-email', 'class' => 'form-control input-sm glyphicon '.$error_border_class, 'placeholder' => '&#57352; Username or Email')) }}

							  </div>

							  <div class="form-group">

							  	<?php $passwordError =  null ; $error_border_class = null;?>
								@if($errors->has('password_login'))
									<?php $passwordError =  $errors->first('password_login') ; $error_border_class = 'error_border';?>
								@endif

								<div class="home-error_message_small">
									{{ $passwordError }}
								</div>
								
							    <label class="sr-only" for="exampleInputPassword2">Password</label>

							    {{ Form::password('password_login', array('id' => 'login-password exampleInputPassword2', 'class' => 'form-control input-sm glyphicon '.$error_border_class, 'placeholder' => '&#57395; Password')) }}
								<div class="forgot_password_small">
									<a href="{{ URL::route('recover-password') }}">Forgot password?</a>
								</div>

							  </div>

							  <div class="checkbox">
			                       <label>
			                          {{ Form::checkbox('remember', 0, 0, ['id' => 'login-remember', ]) }} <p class="rememberMe_label">Remember me</p>
			                       </label>
		                      </div>

						<button type="submit" class="btn btn-sm btn-default"><small class="glyphicon glyphicon-log-in"></small> Sign in</button>
						{{Form::close()}} 

						<a href="{{ URL::route('account-create') }}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-certificate"></span> Register</a>
						
					</div>
					@endif
					
				</div><!--/.nav-collapse -->
			</div>
		</nav>


		<div class="container all">
			@yield('ragac')
			@yield('home')
		</div><!-- /.container -->

		<!--////////////////////////////////////////////////////////////////////////////////////// -->

		<section class="contact" id="contact">

		    <div class="container">

		        <div class="row">

		            <div class="col-md-6">

		                <div class="alert alert-success hidden" id="contactSuccess">
		                    <strong>Success!</strong> Your message has been sent to us.
		                </div>

		                <div class="alert alert-error hidden" id="contactError">
		                    <strong>Error!</strong> There was an error sending your message.
		                </div>

		                <h2 class="short"><strong>Contact</strong> Us</h2>

		                <form class="clearfix" accept-charset="utf-8" method="post" action="{{URL::route('contacts-get')}}">
		                    <div class="row">
		                        <div class="col-sm-6 form-group">
		                            <label for="name">Name</label>
		                            <input type="text" placeholder="" value="" name="name" id="name"
		                                   class="form-control input-lg">
		                        </div>

		                        <div class="col-sm-6 form-group">
		                            <label for="email">Email Address</label>
		                            <input type="email" placeholder="" value="" name="email" id="email"
		                                   class="form-control input-lg">
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-sm-12 form-group">
		                            <label for="message">Message</label>
		                            <textarea rows="4" name="message" id="message" class="form-control"></textarea>
		                        </div>
		                    </div>

		                    <button class="btn btn-success btn-xlg" type="submit">Send Message</button>
		                </form>
		            </div>
		            <div class="col-md-offset-1 col-md-5">
		                <br/>
		                <h4 class="pull-top">Get in <strong>touch</strong></h4>

		                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet
		                    varius. In eu ipsum vitae velit congue iaculis vitae at risus.</p>

		                <hr>

		                <h4>The <strong>Office</strong></h4>
		                <ul class="unstyled">
		                    <li><i class="icon-map-marker"></i> <strong>Address:</strong> 1234 Street Name, City Name, United
		                        States
		                    </li>
		                    <li><i class="icon-phone"></i> <strong>Phone:</strong> (123) 456-7890</li>
		                    <li><i class="icon-envelope"></i> <strong>Email:</strong> <a href="mailto:mail@example.com">mail@example.com</a>
		                    </li>
		                </ul>


		            </div>


		        </div>

		    </div>

		</section>

		<footer id="footer">
		    <div class="footer-copyright">
		        <div class="container">
		            <div class="row">
		                <div class="col-md-5">
		                    <p>&copy; Copyright 2015 ITDC Project TOP SECRET CLASSIFIED DO NOT PUBLISH. All Rights Reserved.</p>
		                </div>
		                <div class="col-md-5">
		                    <nav id="footer-menu">
		                        <ul>
		                            <li><a href="#">FAQ's</a></li>
		                            <li><a href="#">Sitemap</a></li>
		                            <li><a href="#">Contact</a></li>
		                        </ul>
		                    </nav>
		                </div>
		            </div>
		        </div>
		    </div>
		</footer>
	</body>

	<script src="{{ URL::asset('res/js/main/layout.js') }}"></script>
</html>
