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
		if ($data) {
			$this->layout->content = View::make('ITDC_Project.home.project.show')
			->with([
				'project'	 	=> $data['project'],
				'bidders' 		=> $data['bidders'],
				'currencies' 	=> $data['currencies'],
				'timespan' 		=> $data['timespan'], 
				'creator' 		=> $data['creator'], 
				'currUser' 		=> $data['currUser'],
				'types' 		=> $data['typeArr'], 
				'typeDesc' 		=> $data['allTypes'], 
				'currencyArr'	=> $data['currencyArr'], 
				'skills' 		=> $data['skills'],
				'comments' 		=> $data['comments']
			]);
		} else return Redirect::route('home')
			->with('message_type','danger')
			->with('message', 'Oops... Something Went Wrong...');
		
	}
	public function bid(){
		$input = Input::all();
		$data = $this->gateway->bid($input);
		return $data;
	}
	
	public function my_staff($param){
		$user = Auth::user();
		$data = $this->gateway->my($user, $param);
		if ($param == 'projects' || $param == 'bids' || $param == 'comments' || $param == 'offers' || $param == 'suggested') {
			$this->layout->content = View::make('ITDC_Project.home.project.my_staff.my_staff')->with([$param => $data]);
		}else return Redirect::route('staff-my', 'projects');
	}

	public function unbid($id){
		if ($this->gateway->unbid($id)) {
			return Redirect::back()
				->with('message_type','success')
				->with('message', 'Project Unbidded');
		}else 
			return Redirect::back()
				->with('message_type','danger')
				->with('message', 'Oops... Something Went Wrong...');
	}

	public function showSorted() {
	   if(Request::ajax()) {
	   		$input = Input::all();
			return $this->gateway->sort($input);
		}
	}

	public function bidAccept($bidder_id, $project_id){
		$user = User::find($bidder_id);
		$project = Project::find($project_id);
		$otherBids = $project->users()->where('user_id', '!=', $bidder_id)->get();
		foreach ($otherBids as $otherBid) {
			$otherBid->pivot->status = 2;
			$otherBid->pivot->save();
		}
		$bid = $user->projects()->where('project_id', '=', $project_id)->first()->pivot;
		$bid->status = 1;
		$bid->save();

		$project->active = 2;
		$project->save();

		return Redirect::back()
			->with('message_type','success')
			->with('message', 'Bid Accepted!');
	}

	public function deactivate($id){
		if($this->gateway->deactivate($id)){
			return Redirect::back()
				->with('message_type','warning')
				->with('message', 'Project Deactivated');
		}else 
			return Redirect::back()
				->with('message_type','danger')
				->with('message', 'Oops... Something Went Wrong...');
	}
}