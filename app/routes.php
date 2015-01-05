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

Route::get('home', 'HomeController@index');
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

Route::get('login', 'SessionsController@create');
Route::get('logout', 'SessionsController@destroy');
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
Route::get('homepage', 'NewsController@getindex');

/************Routes For NewsController*************/

/*Route::get('getnews/{id}', function($id)
{
    return View::make('news.getnews', array('news' => News::all()));
});*/

Route::get('news/{atr}/{par}', 'NewsController@newsInd');

Route::group(['prefix' => 'admin'/*, 'before'=>'auth.basic'*/], function()
{
	Route::resource('user', 'UserController');
	Route::resource('skill', 'SkillController');
});