<?php
use pro\gateways\UserGateway;
use pro\gateways\ProjectGateway;
use OAuth\OAuth2\Service\GitHub;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;

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
		$storage = new Session();



		$credentials = new Credentials(
		    '09696cd9626f7270e967',
		    'a9d620646378642962aa13b5392cbae083745fff',
		    URL::route('github-add')
		);

		$serviceFactory = new \OAuth\ServiceFactory();
		// Instantiate the GitHub service using the credentials, 
		//         http client and storage mechanism for the token
		/** @var $gitHub GitHub */
		$gitHub = $serviceFactory->createService('GitHub', $credentials, $storage, array('user'));
		

		

		$code = Input::get('code');

		if (!empty($code)) {
		    // This was a callback request from github, get the token
		    $gitHub->requestAccessToken($_GET['code']);


		    $result = json_decode($gitHub->request('user'), true);
		    //echo 'The first email on your github account is ' . $result[0];

echo "<pre>";
	    print_r($result);
		die;		    

		} elseif (!empty($_GET['go']) && $_GET['go'] === 'go') {
		    $url = $gitHub->getAuthorizationUri();
		    header('Location: ' . $url);
		} else {
		    $url = $currentUri->getRelativeUri() . '?go=go';
		    echo "<a href='$url'>Login with Github!</a>";
		}

/*
		$code = Input::get('code');
		
	    $github = OAuth::consumer('GitHub');
	   
	    $result = json_decode($github->request('user/emails'), true);
	    
    	echo 'The first email on your github account is ' . $result[0];


	    if (!empty($code)) {

	        if($token = $github->requestAccessToken($code)->getAccessToken()){
	        	$user = Auth::user();
	        	$user->github_token = $token;
	        	$user->save();
	        	return Redirect::route('user-profile', $user->username);
	        }
	    }

        $url = $github->getAuthorizationUri();
        return Redirect::to((string)$url);
   */

	}

	public function detachGithub(){
		$user = Auth::user();
		$user->github_token = null;
	    $user->save();

	    return Redirect::route('user-profile', $user->username);
	}
	
}