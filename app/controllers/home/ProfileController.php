<?php
use pro\gateways\UserGateway;
use pro\gateways\ProjectGateway;

class ProfileController extends BaseController {

	protected $layout = 'layouts.home';
	private $gateway, $projectGateway;

	public function __construct(UserGateway $gateway, ProjectGateway $projectGateway) {
		$this->gateway = $gateway;
		$this->projectGateway = $projectGateway;
	}
	public function user($username){
		$user = User::where('username', '=', $username)->with('skills')->with('phones')->with('comments');
		$currencies = Config::get('projects.currency');
		$data = $this->projectGateway->my($user);
		if ($user->count()) {
			$user = $user->first();
			$this->layout->content = View::make('ITDC_Project.home.profile.user')
				->with([
						'user' => $user, 
						'currencies' => $currencies ,
						'projects' => $data['projects'], 
						'bids' => $data['bids']]
				);
		}
		
	}
	
}