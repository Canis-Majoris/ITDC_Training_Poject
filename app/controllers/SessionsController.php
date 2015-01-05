<?php
	class SessionsController extends Controller {

		
		protected $grp = NULL;
		public function create(){
			//return 'contact';
			return View::make('sessions.create');
		}
		public function store(){
			$input = Input::all();
			//dd($input);
			$message = '';
			$r = false;
			if (isset($input['remember'])) {
				$r = true;
			}
			$attempt = Auth::attempt([
				'username' => $input['username'],
				'password' => $input['password']
			], $r);
			//$ps= Hash::make('1234567890');
			//dd($ps);

			if ($attempt) {
				$this->grp = Auth::user()->type;
				if (Auth::user()->status != 2) {
					if ($this->grp == 1) {
						return Redirect::intended('adminpage')->with('flash_message', 'You have been logged in!');
					}
					else return Redirect::intended('homepage')->with('flash_message', 'You have been logged in!')->withInput();
				}
			}
			return Redirect::back()->with('flash_message', 'Invalid credentials!')->withInput();
		}
		public function destroy(){
			$this->grp = Auth::user()->type;
			Auth::logout();

			if ($this->grp == 1) {
				return Redirect::to('login')->with('flash_message', 'You have been logged out!');
			}else return Redirect::to('homepage')->with('flash_message', 'You have been logged out!');
		}
	}
?>