<?php

namespace pro\gateways;
use pro\repositories\ProjectRepository\ProjectRepositoryInterface;
use Project;
use Redirect;
use Validator;
use DB;
class ProjectGateway {

	private $projectRepo;

	public function __construct(ProjectRepositoryInterface $projectRepo) {
		$this->projectRepo = $projectRepo;
	}
	public function all(){
		return $this->projectRepo->all();
	}
	public function create($input){
		$newrules = [
			'name'       		=> 'required|max:255',
			'description'    	=> 'required',
			'duration'  		=> 'required',
    		'salary'  			=> 'required'
		];
		$project = new Project;
    	$project->extendRules($newrules);
		return $this->projectRepo->createOrUpdate($input, $project, null);
	}
	public function getCreate() {
		return $this->projectRepo->getCreate();
	}
	public function update($input, $id){
		return $this->projectRepo->createOrUpdate($input, $id);
	}
	public function delete($id){
		return $this->projectRepo->delete($id);
	}
	public function show($id){
		return $this->projectRepo->show($id);
	}
	public function bid($input){
		$rules = [
			'price'   		 => 'required|numeric',
			'bid_currency' 	 => 'required|max:4',
			'description' 	 => 'required'
		];

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {
			return $this->projectRepo->bid($input);
		}
	}
	public function sort($input){
		return $this->projectRepo->sort($input);
	}
	public function my($user){
		return $this->projectRepo->my($user);
	}
	public function unbid($id){
		return $this->projectRepo->unbid($id);
	}
}