<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//Route::pattern('id', '[0-9]+');

/*Route::get('/', function()
{
	Config::get('app.url');
	return View::make('hello');
});*/


Route::any('filterskill', 'UserController@filterSkills');
Route::get('tag/{name}', 'UserController@byTag');
/*Route::get('about', function(){
	return 'about page';
});

Route::get('user', array('before' => 'old', function()
{
    return 'You are over 200 years old!';
}));
Route::controller('contact', 'ContactController');
//Route::get('test', 'ContactController@getTest');





/************Routes For Authorisation*************/

Route::get('login', ['as' => 'login', 'uses' => 'SessionsController@create']);
Route::get('logout', ['as' => 'logout', 'uses' => 'SessionsController@destroy']);
Route::resource('sessions', 'SessionsController');
/*Route::get('profile', function()
{
	//return View::make('hello');
	return "Welcome. You have entered as Admin! your username is " . Auth::user()->username;
});*/

Route::get('adminpage', 'UsersController@getindex'
/*['as' => 'admin', function()
{
	if (Auth::user()->type == 1) {

		View::composer('sessions.homepage', function($view)
		{
		    $view->with('users', User::all());
		});

		return View::make('sessions.homepage');
	}
	return Redirect::to('login')->with('flash_message', 'You Ain`t No Admin! ;)');
	
}]*/ )->before('auth');


/*Route::get('homepage', ['as' => 'home', function()
{
	View::composer('news.mainpage', function($view)
	{
	    $view->with('news', News::all());
	});
	return View::make('news.mainpage');
}]);*/

/************Routes For NewsController*************/

/*Route::get('getnews/{id}', function($id)
{
    return View::make('news.getnews', array('news' => News::all()));
});*/

Route::get('news/{atr}/{par}', 'NewsController@newsInd');

Route::group(['prefix' => 'admin', 'before' => 'auth'], function()
{
	Route::resource('user', 'UserController');
	Route::resource('skill', 'SkillController');
	Route::resource('course', 'CourseController');
});



/*
/	homepage route
*/
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::group(['before' => 'guest', 'prefix' => '/'], function(){

	/*
	/ CSRF protection group
	*/
	Route::group(['before' => 'csrf'], function(){

		/*
		/ Create account (POST)
		*/
		Route::post('account/create', [
			'as'=> 'account-create-post',
			'uses' => 'AccountController@postCreate'
		]);

		/*
		/ Sing In (POST)
		*/
		Route::post('account/sign-in', [
			'as' => 'account-sign-in-post',
			'uses' => 'AccountController@postSignIn'
		]);
			/*
		/ Forgot password (POST)
		*/
		Route::post('/account/forgot-password', [
			'as' => 'account-forgot-password-post',
			'uses' => 'AccountController@postForgotPassword'
		]);

	
	});
/////////////////////////////////
	Route::post('/account/recover-password', [
		'as' => 'recover-password-post',
		'uses' => 'RemindersController@postRemind'
	]);
/////////////////////////////////
/////////////////////////////

	Route::get('/account/recover-password', [
		'as' => 'recover-password',
		'uses' => 'RemindersController@getRemind'
	]);

/////////////////////////////
/////////////////////////////////
	Route::post('/password/reset', [
		'as' => 'resert-password-post',
		'uses' => 'RemindersController@postReset'
	]);
/////////////////////////////////
/////////////////////////////

	Route::get('/password/reset/{token}', [
		'as' => 'reset-password',
		'uses' => 'RemindersController@getReset'
	]);

/////////////////////////////

	/*
	/ Forgot password (GET)
	*/
	Route::get('/account/forgot-password', [
		'as' => 'account-forgot-password',
		'uses' => 'AccountController@getForgotPassword'
	]);

	/*
	/ Recover password (GET)
	*/
	Route::get('/account/recover/{code}', [
		'as' => 'account-recover',
		'uses' => 'AccountController@getRecover'
	]);

	/*
	/ Sing In (GET)
	*/
	Route::get('/account/sign-in', [
		'as' => 'account-sign-in',
		'uses' => 'AccountController@getSignIn'
	]);

	/*
	/ Create account (GET)
	*/
	Route::get('account/create', [
		'as'=> 'account-create',
		'uses' => 'AccountController@getCreate'
	]);
	/*
	/ Account activatin (GET)
	*/
	Route::get('/account/activate/{code}', [
		'as' => 'account-activate',
		'uses' => 'AccountController@getActivate'
	]);
});

/*
/ Authenticated group
*/
Route::group(['before' => 'auth_home'], function(){
	/*
	/ CSRF protection group
	*/
	Route::group(['before' => 'csrf'], function(){
		/*
		/ Account edit (POST)
		*/
		Route::post('account/edit', [
			'as' => 'edit-post',
			'uses' => 'AccountController@postEdit'
		]);
	});

	/*
	/ Sign out (GET)
	*/
	Route::get('/account/sign-out', [
		'as' => 'account-sign-out',
		'uses' => 'AccountController@getSignOut'
	]);

	Route::get('/project/create', [
	'as' => 'project-create',
	'uses' => 'ProjectController@getCreate'
	]);

	Route::post('project/create', [
	'as'=> 'project-create-post',
	'uses' => 'ProjectController@postCreate'
	]);

	Route::get('project/browse', [
		'as'=> 'project-browse',
		'uses' => 'ProjectController@index'
	]);
	/*
	/ Account edit (GET)
	*/

	Route::get('/account/edit', [
		'as' => 'edit',
		'uses' => 'AccountController@getEdit'
	]);
});

///User Profile

Route::get('/user/{username}', [
	'as' => 'user-profile',
	'uses' => 'ProfileController@user'
]);

