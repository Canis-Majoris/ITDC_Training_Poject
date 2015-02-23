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
		$currUser = Auth::user();
		$user = User::where('username', '=', $username)->with('skills')->with('phones')->with('comments');
		$currencies = Config::get('projects.currency');
		$data = $this->projectGateway->staff($user);
		if ($user->count()) {
			$user = $user->first();
			$permission = 0;
			if ($currUser) {
				if($user->rating()->where('rater_id', '=', $currUser->id)->count() == 0){
					$permission = 1;
				}
			}
			
			$this->layout->content = View::make('ITDC_Project.home.profile.user')
				->with([
					'user' 			=> $user, 
					'currencies'	=> $currencies ,
					'projects' 		=> $data['projects'], 
					'bids' 			=> $data['bids'],
					'comments'		=> $data['comments'],
					'rating'		=> $user->reputation,
					'permission' 	=> $permission,
				]);
		}
		
	}

	public function toGithub(){

		$code = Input::get('code');
		
	    $github = OAuth::consumer('GitHub');
	    if (!empty($code)) {
	    	if($github->requestAccessToken($code)){
		    	$result = json_decode($github->request('user'), true);
		    	if ($result['email'] != null) {
		    		$user = User::where('email', '=', $result['email'])->first(['id']);
				    Auth::login($user);
				    return Redirect::route('home')
				    	->with('message_type','success')
						->with('message', 'Welcome! You Have Logged In With GitHub Account.');
		    	}else return Redirect::route('home')
				    	->with('message_type','danger')
						->with('message', 'Ooops... We Can`t See Your Email Address. Check Your GitHub Settings.' );
		  	}
	    }
	    return Redirect::route('home')
	    	->with('message_type','danger')
			->with('message', 'Ooops... Something Went Wrong...' );

	}

	public function detachGithub(){
		$user = Auth::user();
		$user->github_token = null;
	    $user->save();

	    return Redirect::route('user-profile', $user->username);
	}
	
}