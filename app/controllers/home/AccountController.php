<?php
use pro\gateways\UserGateway;
use pro\gateways\AccountGateway;

class AccountController extends BaseController {

	protected $layout = 'layouts.home';
	private $gateway; 

	public function __construct(AccountGateway $gateway) {
		$this->gateway = $gateway;
	}

	public function getSignIn(){
		#############
	}

	public function getSignOut(){
		Auth::user()->online = 0;
		Auth::user()->save();
		Auth::logout();
		return Redirect::back();
	}

	public function postSignIn(){
		$input = Input::All();
		return $this->gateway->signIn($input);
	}
	public function getCreate(){
		$this->layout->content = View::make('ITDC_Project.account.create');
	}

	public function postCreate(){
		$input = Input::all();
		return $this->gateway->createOrUpdate($input);
	}
	public function getActivate($code){
		return $this->gateway->activate($code);
	}

	public function getEdit(){

		$user = User::find(Auth::user()->id);
		$this->layout->content = View::make('ITDC_Project.account.edit')->with(['user' => $user]);
	}

	public function postEdit(){
		$input = Input::all();
		$id = Auth::user()->id;
		return $this->gateway->createOrUpdate($input, $id);
	}
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 /*
	 / Custom Password Recovery
	 */

	 /*public function getForgotPassword(){
	 	$this->layout->content = View::make('ITDC_Project.account.forgot');
	 }

	 public function postForgotPassword(){
	 	$cred = [
	 		'email' => 'required|email'
	 	];

	 	$validator = Validator::make(Input::all(), $cred);
	 	if ($validator->fails()) {
	 		return Redirect::back()
			    ->withErrors($validator)
			 	->withInput();
	 	}else{
	 		$user = User::where('email', '=', Input::get('email'));
	 		if ($user->count()) {
	 			$user = $user->first();
	 			$code = str_random(60);
	 			$password = str_random(10);
	 			$user->code = $code;
	 			$user->password_temp = Hash::make($password);
	 			if ($user->save()) {
	 				Mail::send('emails.auth.forgot', ['link' => URL::route('account-recover', $code), 'username' => $user->username, 'password' => $password, 'name' => 'Gigi'], function($message) use($user) {
						$message->to($user->email, $user->username)->subject('ITDC Project Password Reset');
					});

					return Redirect::route('home')
						->with('message_type','success')
						->with('message', 'We have sent you a new password by Email');
	 			}
	 		}
	 	}

	 	return Redirect::back()
			->withInput()
		 	->with('message_type','danger')
			->with('message', 'Could not request new password...');
	 }

	 public function getRecover($code){
	 	$user = User::where('code', '=', $code)->where('password_temp', '!=', '');
	 	if ($user->count()) {
	 		$user = $user->first();
	 		$user->password = $user->password_temp;
	 		$user->password_temp = '';
	 		$user->code = '';
	 		if ($user->save()) {
	 			return Redirect::route('home')
	 				->with('message_type','success')
					->with('message', 'Your password has been reovered.');
	 		}

	 		return Redirect::route('home')
	 			->with('message_type','danger')
				->with('message', 'Could not recover your password');
	 	}
	 }
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////

///////////////////////////////

}


