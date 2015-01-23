<?php
use pro\gateways\UserGateway;

class ProjectController extends BaseController {

	protected $layout = 'layouts.home';
	private $gateway; 

	public function __construct(UserGateway $gateway) {
		$this->gateway = $gateway;
	}
	public function index(){
		
	}
	

	public function getCreate(){
		$this->layout->content = View::make('ITDC_Project.home.project.create');
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
	
}