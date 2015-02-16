<?php
use pro\gateways\UserGateway;
use pro\gateways\SkillGateway;
use pro\gateways\AccountGateway;

class HomeController extends BaseController {

	protected $layout = 'layouts.home';
	protected $users_skills = 'ITDC_Project.admin.users.index';
	private $gateway;

	public function __construct(UserGateway $userGateway, SkillGateway $skillGateway, AccountGateway $accountgateway) {
		$this->userGateway = $userGateway;
		$this->skillGateway = $skillGateway;
		$this->accountgateway = $accountgateway;

	}

	public function users() {
		$users = $this->userGateway->all();
		$this->layout->content = View::make('ITDC_Project.home.main.index')->with(['users' => $users->paginate(60)]);
	}
	public function index(){
		$this->layout->content = View::make('ITDC_Project.home.main.firstpage');

	}
}
