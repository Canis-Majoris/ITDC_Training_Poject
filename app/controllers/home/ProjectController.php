<?php
use pro\gateways\ProjectGateway;

class ProjectController extends BaseController {
	protected $layout = 'layouts.home';
	private $gateway;

	public function __construct(ProjectGateway $gateway) {
		$this->gateway = $gateway;
	}
	public function index(){
		$projects = $this->gateway->all();
		$this->layout->content = View::make('ITDC_Project.home.project.index')->with(['projects' => $projects]);
	}
	
	public function getCreate(){
		$data = $this->gateway->getCreate();
		$this->layout->content = View::make('ITDC_Project.home.project.create')
			->with(['currencies' => $data['currencies'], 'project_types' => $data['project_types'], 'timespan' => $data['timespan']]);
	}
	public function postCreate(){
		$input = Input::all();
		$this->gateway->create($input);
		 return Redirect::route('home')
			->with('message_type','success')
			->with('message', 'Project Posted');
	}
	public function show($id){
		$data = $this->gateway->show($id);
		$this->layout->content = View::make('ITDC_Project.home.project.show')
		->with(['project' => $data['project'], 'bidders' => $data['bidders'], 'currencies' => $data['currencies'],
				'timespan' => $data['timespan'], 'creator' => $data['creator'], 'currUser' => $data['currUser']]);
	}
	public function bid(){
		$input = Input::all();
		$data = $this->gateway->bid($input);
		return $data;
	}
	public function my_projects(){
		$data = $this->gateway->my();
		$this->layout->content = View::make('ITDC_Project.home.project.my_projects')->with(['projects' => $data['projects'], 'bids' => $data['bids']]);
	}
	public function unbid($id){
		$this->gateway->unbid($id);
		return Redirect::back();
	}
}