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

		$user = User::find(Auth::user()->id);
		$this->layout->content = View::make('ITDC_Project.account.edit')->with(['user' => $user]);
	}

	public function postEdit(){
		$input = Input::all();
		$cred = [
			'firstname'        => 'required',
			'lastname'         => 'required',
			'email'            => 'required',
			'old_password'     => 'required',
			'password'         => 'required|min:6',
			'confirm_password' => 'required|same:password'
		];
		$validator = Validator::make($input, $cred);
		if ($validator->fails()) {
			return Redirect::back()
			    ->withErrors($validator)
			 	->withInput();
		}else{
			$user = User::find(Auth::user()->id);
			$old_password = $input['old_password'];
			$password = $input['password'];
			//dd($user->getAuthPassword());
			if (Hash::check($old_password, $user->getAuthPassword())) {
				$user->fill($input);
				$user->password = Hash::make($password);
				///////////////
				$this->updateSkillsPhones($user, $input['phone']);
				///////////////
				if ($user->save()) {
					return Redirect::route('home')
						->with('message_type','success')
						->with('message', 'Your account has been successfully edited!');
				}
			}else{
				return Redirect::back()
					->withInput()
				 	->with('message_type','danger')
					->with('message', 'Yout old password is incorrect.');
			}

		}

		return Redirect::back()
			->withInput()
		 	->with('message_type','danger')
			->with('message', 'Aaghhh... We could not edit yout profile...');

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

	public function managePhones($user, $phones){
			$allPhones = [];
			foreach ($phones as $k => $v) {
				if ($v!=null) {
					$allPhones[] = new Phone(['phone' => $v]);
				}
			}
			$user->phones()->delete();
			$user->phones()->saveMany($allPhones);
	}

	public function manageSkills($user, $skills, $levels){
		$sl = [];
		foreach ($skills as $skill) {
			if (!empty($levels[$skill])) {
				$sl[$skill] = ['level' => $levels[$skill]];
			}
			$user->skills()->sync($sl);
		}
	}

	public function updateSkillsPhones($user, $phones=null, $skills=null, $levels=null){
		if (isset($skills) && isset($levels)) {
			$this->manageSkills($user, $skills, $levels);
		}
		if (isset($phones)) {
			$this->managePhones($user, $phones);
		}
	}
}


?>