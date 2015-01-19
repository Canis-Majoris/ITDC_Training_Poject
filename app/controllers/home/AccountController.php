<?php
use pro\gateways\UserGateway;

class AccountController extends BaseController {

	protected $layout = 'layouts.home';
	private $gateway; 

	public function __construct(UserGateway $gateway) {
		$this->gateway = $gateway;
	}

	public function getSignIn(){

	}

	public function getSignOut(){
		Auth::logout();
		return Redirect::route('home');
	}

	public function postSignIn(){
		$input = Input::All();
		$validator = Validator::make($input, [
			'email_login'    => 'required|email',
			'password_login' => 'required'
		]);

		if ($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		}else{

			$remember = (Input::has('remember')) ? true : false;

			$cred = [
				'email' => $input['email_login'],
				'password' => $input['password_login'],
				'active' => 1
			];

			$auth = Auth::attempt($cred, $remember);

			if ($auth) {
				return Redirect::back();
			}
		}

		return Redirect::back()
			->with('message_type','danger')
			->with('message', 'Oops... your Email/Password is wrong, or you have not activated your account yet.')
			->withInput();
	}

	public function getCreate(){
		$this->layout->content = View::make('ITDC_Project.account.create');
	}
	public function postCreate(){
		$input = Input::all();
		$rules = [
			'email'       		=> 'required|max:70|email|unique:users',
			'username'    		=> 'required|max:30|min:3|unique:users',
			'firstname'  		=> 'required',
    		'lastname'  		=> 'required',
    		'type'       		=> 'required',
			'password'    		=> 'required|min:6',
			'confirm_password'  => 'required|same:password'
		];

		if ($input['type'] == 3) {
			$rules['company_name'] = 'required';
		}

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			return Redirect::route('account-create')
			->withErrors($validator)
			->withInput();
		}else{
			if (isset($input['password'])) {
	    		$input['password'] = Hash::make($input['password']);
		    }
		    $user = new User;
		    $user->fill($input);

		    $code = str_random(60);
		    $user->code = $code;
		    $user->active = 0;
		    
			if($user->save()){

			Mail::send('emails.auth.activate', ['link' => URL::route('account-activate', $code), 'username' => $input['username'], 'name' => 'Gigi'], function($message) use($user) {
				$message->to($user->email, $user->username)->subject('ITDC Project Account Activation');
			});

				return Redirect::route('home')
				->with('message_type','success')
				->with('message', 'User added successfully, check yout Email to confirm registration.');
			}
		}
	}
	public function getActivate($code){
		$user = User::where('code', '=', $code)->where('active', '=', 0);
		if ($user->count()) {
			$user = $user->first();
			$user->active = 1;
			$user->code = '';

			if($user->save()){
				return Redirect::route('home')
					->with('message_type','success')
					->with('message', 'Activated! you can now sign in.');

			}
		}

		return Redirect::route('home')
			->with('message_type','danger')
			->with('message', 'Oops... We could not activate your account. Please try again later.');
	}
	

	public function getEdit(){
		$this->layout->content = View::make('ITDC_Project.account.edit')->with(['user' => Auth::user()]);
	}

	public function postEdit(){
		$this->layout->content = View::make('ITDC_Project.account.edit');
	}
}


?>