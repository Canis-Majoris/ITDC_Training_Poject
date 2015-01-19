<?php
use pro\gateways\UserGateway;

class ProfileController extends BaseController {

	protected $layout = 'layouts.home';
	private $gateway;

	public function __construct(UserGateway $gateway) {
		$this->gateway = $gateway;
	}
	public function user($username){
		$user = User::where('username', '=', $username)->with('skills')->with('phones');
		if ($user->count()) {
			$user = $user->first();
			$this->layout->content = View::make('ITDC_Project.home.profile.user')->with(['user' => $user]);
		}
		
	}
	
}