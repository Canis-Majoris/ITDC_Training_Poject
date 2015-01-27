<?php
use pro\gateways\UserGateway;
class ProjectController extends BaseController {
	protected $layout = 'layouts.home';
	private $gateway; 
	public function __construct(UserGateway $gateway) {
		$this->gateway = $gateway;
	}
	public function index(){
		//$projects = Project::get();
		$currencies = Currency::all();
		$projects = Project::with('users');
				print_r($projects);
				die;
		foreach ($projects as $item) {

		}
		$this->layout->content = View::make('ITDC_Project.home.project.index')->with(['projects' => Project::with('users')->paginate(30), 'currencies' => $currencies, ]);
	}
	
	public function getCreate(){
		$currencies = [
			'USD' => 'USD',
			'GEL' => 'GEL',
			'AUD' => 'AUD',
			'CAD' => 'CAD',
			'EUR' => 'EUR',
			'GBP' =>'GBP'
		];
		$project_types = Project_type::all();
		$this->layout->content = View::make('ITDC_Project.home.project.create')->with(['currencies' => $currencies, 'project_types' => $project_types]);
	}
	public function postCreate(){
		$input = Input::all();
		$rules = [
			'name'       		=> 'required|max:255',
			'description'    	=> 'required',
			'duration'  		=> 'required',
    		'salary'  			=> 'required'
		];
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			return Redirect::route('project-create')
			->withErrors($validator)
			->withInput();
		}else{
		    $project = new Project;
		    $input['user_id'] = Auth::user()->id;
		    $project->fill($input);
		    $project->active = 1;
			if($project->save()){
				return Redirect::route('home')
				->with('message_type','success')
				->with('message', 'Project Posted');
			}
		}
	}

	public function show($id){
		$project = Project::find($id);
		$this->layout->content = View::make('ITDC_Project.home.project.show')->with(['project' => $project]);
	}

	public function bid(){
		$user = User::find(Auth::user()->id);
		$input = Input::all();
		
		$id=$input['project_id'];
		$project = Project::find($id);
		
		$project_bid_count = $project->bid_count;
		$project_avg_price = $project->avg_price;

		$project_avg_price = ($project_avg_price * $project_bid_count + $input['price'])*($project_bid_count+1);
		$project_bid_count++;
		$project->save();
		$sth = array('user_id'=>Auth::user()->id,'project_id'=>$id, 'bid_price'=>$input['price'], 'comment'=>$input['description'], 'duration'=>$input['duration']);
		$project->users()->attach($id, $sth);


	}


	
}
