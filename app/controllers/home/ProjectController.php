<?php
use pro\gateways\UserGateway;

class ProfileController extends BaseController {

	protected $layout = 'layouts.home';
	private $gateway;

	public function __construct(UserGateway $gateway) {
		$this->gateway = $gateway;
	}
	
	public function create(){
		
	}
	
}