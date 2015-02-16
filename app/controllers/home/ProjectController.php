<?php
use pro\gateways\ProjectGateway;

class ProjectController extends BaseController {
	protected $layout = 'layouts.home';
	private $gateway;

	public function __construct(ProjectGateway $gateway) {
		$this->gateway = $gateway;
	}
	public function index(){
		//$projects = $this->gateway->all();
		$this->layout->content = View::make('ITDC_Project.home.project.index');
	}
	
	public function getCreate(){
		$data = $this->gateway->getCreate();

		$this->layout->content = View::make('ITDC_Project.home.project.create')
			->with(['currencies' => $data['currencies'], 'project_types' => $data['project_types'],
			 'timespan' => $data['timespan'], 'skills' => $data['skills']
		]);
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
		$comments = Comment::where('project_id', '=', $id)->get();
		
		$types = $data['project']->project_type_id;
		$typeArr = explode('|', rtrim($types, '|'));

		$allTypes = Project_type::all();
		$currencyArr = Config::get('projects.currency');
		$this->layout->content = View::make('ITDC_Project.home.project.show')
		->with([
			'project'	 	=> $data['project'],
			'bidders' 		=> $data['bidders'],
			'currencies' 	=> $data['currencies'],
			'timespan' 		=> $data['timespan'], 
			'creator' 		=> $data['creator'], 
			'currUser' 		=> $data['currUser'],
			'types' 		=> $typeArr, 
			'typeDesc' 		=> $allTypes, 
			'currencyArr'	=> $currencyArr, 
			'skills' 		=> $data['skills'],
			'comments' 		=> $comments
		]);
	}
	public function bid(){
		$input = Input::all();
		$data = $this->gateway->bid($input);
		return $data;
	}
	public function my_projects(){
		$user = Auth::user();
		$data = $this->gateway->my($user);
		$this->layout->content = View::make('ITDC_Project.home.project.my_projects')->with(['projects' => $data['projects'], 'bids' => $data['bids']]);
	}
	public function unbid($id){
		$this->gateway->unbid($id);
		return Redirect::back();
	}

	public function showSorted() {
	   if(Request::ajax()) {
	   		
	   }else{
	   		$input = Input::all();
			return $this->gateway->sort($input);
	   }
	}
}