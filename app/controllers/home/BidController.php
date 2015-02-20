<?php
use pro\gateways\ProjectGateway;

class BidController extends BaseController {
	protected $layout = 'layouts.home';
	private $gateway;

	public function __construct(ProjectGateway $gateway) {
		$this->gateway = $gateway;
	}

	public function show($user_id, $id){
		$bid = $this->gateway->showBid($user_id, $id);
		if ($bid) {
			$this->layout->content = View::make('ITDC_Project.home.bids.show')->with(['bid' => $bid]);
		}else return Redirect::route('home')
			->with('message_type','danger')
			->with('message', 'Oops... Something Went Wrong...');
	}

}