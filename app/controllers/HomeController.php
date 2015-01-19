<?php
use pro\gateways\UserGateway;

class HomeController extends BaseController {

	protected $layout = 'layouts.home';
	protected $users_skills = 'ITDC_Project.admin.users.index';
	private $gateway;

	public function __construct(UserGateway $gateway) {
		$this->gateway = $gateway;
	}

	public function index() {
		$users = $this->gateway->all();
		/*Mail::send('emails.auth.test', ['name' => 'Gigi'], function($message){
			$message -> to('gigi.khomeriki@gmail.com', 'Gigi')->subject('Test email');
		});*/
		$this->layout->content = View::make('ITDC_Project.home.main.index')->with(['users' => $users->paginate(60)]);
	}
}
