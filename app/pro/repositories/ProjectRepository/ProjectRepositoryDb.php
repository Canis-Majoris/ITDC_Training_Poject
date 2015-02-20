<?php
namespace pro\repositories\ProjectRepository;

use Moltin\Currency\Currency as Currency;
use Moltin\Currency\Format\Runtime as RuntimeFormat;
use Moltin\Currency\Exchange\Runtime as RuntimeExchange;

use Project;
use Hash;
use Redirect;
use Project_type;
use Validator;
use Auth;
use User;
use Skill;
use Input;
use Response;
use View;
use Config;
use Paginator;
use Comment;
use Carbon\Carbon;

class ProjectRepositoryDb implements ProjectRepositoryInterface {

	protected $exchange;
	protected $timespan;
	protected $currencies;

	public function __construct(){
		$this->timespan = Config::get('projects.timespan');
		$this->currencies =  Config::get('projects.currency_sign');
		$this->currency_spec = Config::get('projects.currency');

	}

	public function all() {
		return Project::orderBy('created_at', 'desc')->with('users')->paginate(10);
	}

	public function byId($id) {
		return Project::find($id);
	}
	public function user($user_id = null) {
		if ($user_id) {
			return User::find($user_id);
		}
		else return Auth::user();
	}
	public function createOrUpdate($input, $project, $id) {
		if ($input) {
			///if there is an input
			if ($id) {
			///update

			########
			
			} else {
				///create
			    $input['user_id'] = $this->user()->id;
			    $input['duration'] = $this->timespan[$input['duration']];
			    if (isset($input['pt_type'])) {
			    	$types = '';
			    	$ptoject_types = $input['pt_type'];
			    	foreach ($ptoject_types as $v) {
			    		$types .= $v.'|';
			    	}
			    $project->project_type_id = $types;

			    }
			    $project->fill($input);
			    $project->active = 1;
				$project->save();
			}

			if (Input::file('file')!=null) {
				$projectAttachmentName = str_random(40).'.'.Input::file('file')->guessClientExtension();
				Input::file('file')->move('./public/uploads/projects',$projectAttachmentName);
				$project->files = $projectAttachmentName;
			}
		}

		$skills = null; $levels_sk = null;
		if (isset($input['skill']) && array_filter($input['level'])) {
			$skills = $input['skill'];
			$levels_sk = $input['level'];
		}

		// All data to update
		$updateData = [
			'skills' => $skills,
			'levels_sk' => $levels_sk
		];
		$this->updateAll($project, $updateData);

		$project->save();


		return $project;
	}

	public function getCreate(){
		$project_types = Project_type::all();
		$skills = Skill::all();
		$data = [
			'project_types' => $project_types,
			'currencies'    => $this->currencies,
			'timespan'      => $this->timespan,
			'skills'        => $skills
		];
		return $data;
	}

	public function show($id) {
		$project = $this->byId($id);
		$data = null;
		if (isset($project)) {
			$creator = User::find($project->user_id);
			$comments = Comment::where('project_id', '=', $id)->get();
			
			$typeData = $this->getTypes($project);

			$currencyArr = $this->currency_spec;
			$currUser = $this->user();

			///get all bidders
			$bidders = User::whereHas('projects', function($q) use($id) {
				$q->where('project_id', '=', $id);
				##############
			})->with('projects')->get();

			$data = [
				'project'   	=> $project,
				'creator'   	=> $creator,
				'bidders'   	=> $bidders,
				'currUser'  	=> $currUser,
				'timespan'  	=> $this->timespan,
				'currencies'	=> $this->currencies,
				'skills'        => $project->skills,
				'currencyArr'	=> $currencyArr,
				'comments'		=> $comments,
				'typeArr'		=> $typeData['typeArr'],
				'allTypes' 		=> $typeData['allTypes']
			];
		}
		return $data;
	}

	public function getTypes($project){
		$types = $project->project_type_id;
		$typeArr = explode('|', rtrim($types, '|'));
		$allTypes = Project_type::all();

		$data = [
			'typeArr'  => $typeArr,
			'allTypes' => $allTypes
		];
		return $data;
	}

	public function showBid($user_id, $id){
		$currUser = Auth::user();
		$user = $this->user($user_id);
		$project = $this->byId($id);
		//dd($currUser->id.' '.$project->user_id);
		$bid = null;
		if (isset($user) && isset($project)){
			$tempBid = $user->projects()->where('project_id', '=', $id)->first()->pivot;
			if($currUser->id == $project->user_id || $currUser->id == $tempBid->user_id || $currUser->type == 0) {
				$bid = $tempBid;
			}
		}
		return $bid;
	}

	public function deactivate($id) {
		$project = $this->byId($id);
		if(is_null($project)) {
			return false;
		}
		//$project->delete();
		$otherBids = $project->users;
		foreach ($otherBids as $otherBid) {
			if ($otherBid->pivot->status != 1) {
				$otherBid->pivot->status = 2;
				$otherBid->pivot->save();
			}
		}
		$project->active = 0;
		$project->save();
		return true;
	}

	public function bid($input) {

		$user_id = $this->user()->id;
		$user = User::find($user_id);

		$id = $input['project_id'];
		$project = $this->byId($id);
		if (!isset($user->projects()->where('project_id', '=', $project->id)->first()->pivot)) {

			$this->exchange = new RuntimeExchange;

			$this->exchange->add('GEL', 2.05);
			$this->exchange->add('USD', 1.0);
			$this->exchange->add('EUR', 0.89);
			$this->exchange->add('AUD', 1.28);
			$this->exchange->add('GBP', 0.66);
			$this->exchange->add('CAD', 1.25);

			$currency = new Currency($this->exchange, new RuntimeFormat);
			$convertedPrice = $currency->convert($input['price'])->from($input['bid_currency'])->to($project->currency)->fifty()->value();
			$project_bid_count = $project->bid_count;
			$project_avg_price = $project->avg_price;

			$project->avg_price = ($project_avg_price * $project_bid_count + $convertedPrice)/($project_bid_count + 1);
			$project->bid_count = ++$project_bid_count;

			$project->save();
			$creator = User::find($project->user_id);
			$sth = [
				'user_id' 		=> $this->user()->id,
				'project_id' 	=> $id,
				'creator_id'    => $creator->id,
				'bid_price'		=> $input['price'], 
				'comment'		=> $input['description'], 
				'duration'		=> $this->timespan[$input['duration']],
				'bid_currency'	=> $this->currencies[$input['bid_currency']]
			];

			$project->users()->attach($id, $sth);

			return Redirect::back()
				->with('message_type','success')
				->with('message', 'You Have Bidded!');
		} else {
			return Redirect::back()
				->with('message_type','danger')
				->with('message', 'You Have Already Bidded This Project!');
		}	

		return Redirect::back()
			->with('message_type','danger')
			->with('message', 'Ooops.... Something went wrong...');
	}
	
	public function my($user, $param){
		if ($param == 'projects') {
			Paginator::setPageName('page_a');
			$data = Project::where('user_id', '=', $user->id)->orderBy('created_at', 'DESC')->paginate(25);
		}elseif ($param == 'bids') {
			Paginator::setPageName('page_b');
			$data = $user->projects()->orderBy('created_at', 'DESC')->paginate(15);
		}elseif ($param == 'comments') {
			Paginator::setPageName('page_c');
			$data = $user->comments()->orderBy('created_at', 'DESC')->paginate(25);
		}elseif($param == 'suggested'){
			Paginator::setPageName('page_d');
			$data = $this->getSuggestedProjects($user);
		}elseif ($param == 'offers') {
			//Paginator::setPageName('page_d');
			//$data = $user->offers()->paginate(3);
			/*foreach ($skillArr as $skl) {
				$data->whereHas('skills', function($q) use($skl)
				{
					$q->where('skill_id', $skl);
				});
			}*/
			Paginator::setPageName('page_e');
			$data = $user->offers()->orderBy('created_at', 'DESC')->paginate(10);
		}else{
			$data = null;
		}
		return $data;
	}

	public function staff($user){
		$user = $user->first();
		$projects = Project::where('user_id', '=', $user->id)->orderBy('created_at', 'DESC')->paginate(10);
		$bids = $user->projects()->orderBy('created_at', 'DESC')->take(7)->get();
		$comments = $user->comments()->orderBy('created_at', 'DESC')->take(10)->get();

		$data = [
			'projects' => $projects,
			'bids' => $bids,
			'comments' => $comments
		];
		return $data;
	}

	public function unbid($id){

		$this->exchange = new RuntimeExchange;

		$this->exchange->add('USD', 1.0);
		$this->exchange->add('EUR', 0.89);
		$this->exchange->add('GEL', 2.05);
		$this->exchange->add('AUD', 1.28);
		$this->exchange->add('GBP', 0.66);
		$this->exchange->add('CAD', 1.25);

		$user = $this->user();
		$project = $this->byId($id);
		if (isset($project)) {
			if (isset($user->projects()->where('project_id', '=', $id)->first()->pivot)) {
				$bid = $user->projects()->where('project_id', '=', $id)->first()->pivot;
			}else return false;
			
		}else return false;

		$currency = new Currency($this->exchange, new RuntimeFormat);
		$convertedPrice = $currency->convert($bid->bid_price)->from($bid->bid_currency)->to($project->currency)->fifty()->value();

		$project_bid_count = $project->bid_count;
		
		if ($project_bid_count == 1) {
			$project->avg_price = 0;
		}else{
			$project->avg_price = ($project->avg_price * $project_bid_count - $convertedPrice)/($project_bid_count - 1);
		}
		if ($bid->status == 1) {
			$otherBids = $project->users;
			foreach ($otherBids as $otherBid) {
				$otherBid->pivot->status = 0;
				$otherBid->pivot->save();
			}
			$project->active = 1;
		}
		$project->bid_count = --$project_bid_count;
		$project->save();
		if ($user->projects()->detach($id)) {
			return true;
		}
		return false;
	}
	public function sort($input){
		$sorter = null;
		$projects = Project::orderBy('created_at', 'DESC')->paginate(20);
		if ($input['sorter'] != null) {
			$sorter = $input['sorter'];
			$arr = explode('.', $sorter);
			if ($arr[0] == 's') {
				$projects = Project::where('duration', '=', $arr[1])->orderBy('created_at', 'DESC')->paginate(20);
			}elseif($arr[0] == 'btn'){
				$projects = Project::orderBy($arr[1], $arr[2])->paginate(20);
			}
		}
		$skills = [];
		foreach ($projects as $project) {
			if ($this->isExpired($project->id)) {
				$project->active = 0;
				$project->save();
			}
			$skills[$project->id] = $project->skills;
		}
		return Response::json([
			'status'   => 'success',
			'projects' => $projects->toJson(),
			'sorter'   => $sorter,
			'skills'   => $skills,
			'timespan' => $this->timespan
		]);
	}

	public function updateAll($project, $updateData){
		if (isset($updateData['skills']) && isset($updateData['levels_sk'])) {
			$this->manageSkills($project, $updateData['skills'], $updateData['levels_sk']);
		}
	}

	public function manageSkills($project, $skills, $levels){
		$sl = [];
		foreach ($skills as $skill) {
			if (!empty($levels[$skill])) {
				$sl[$skill] = ['level' => $levels[$skill]];
			}
			$project->skills()->sync($sl);
		}
	}

	public function getSuggestedProjects($user, $optimal = null){
		$projects = null;
		$skills = $user->skills()->get();
		$langArr = [];
		foreach ($skills as $skill) {
			$langArr[] = $skill->name;
		}
		$projects = Project::/*has('skills', '<', 1)->or*/whereHas('skills', function($q) use($langArr)
		{
			$q->whereIn('name', $langArr);
		})->orderBy('created_at', 'DESC')->paginate(9);

		$types = [];
		$skills = [];
		foreach ($projects as $project) {
			$types[$project->id] = $this->getTypes($project);
			$skills[$project->id] = $project->skills;
		}

		$data = [
			'projects'  	=> $projects,
			'types' 		=> $types,
			'skills'		=> $skills,
			'currencyArr' 	=> $this->currency_spec
		];
		return $data;
	}

	public function isExpired($id){
		$project = Project::find($id);
		$created = new Carbon($project->created_at);
		$now = Carbon::now();
		$expired = ($created->diff($now)->days > 60) ? true : false;
		return $expired;
	}

	//////////////////////////////////////
}