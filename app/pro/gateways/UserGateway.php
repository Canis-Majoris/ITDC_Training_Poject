<?php

namespace pro\gateways;
use pro\repositories\UserRepository\UserRepositoryInterface;
use User;
use Redirect;
use DB;
class UserGateway {

	private $userRepo;

	public function __construct(UserRepositoryInterface $userRepo) {
		$this->userRepo = $userRepo;
	}
	public function all() {
		return $this->userRepo->all();
	}
	public function allStudents(){
		return $this->userRepo->allStudents();
	}
	public function byId($id) {
		return $this->userRepo->byId($id);
	}
	public function create($input) {
		return $this->userRepo->create($input);
	}
	public function byIdWSkills($id) {
		return $this->userRepo->byIdWSkills($id);
	}
	public function update($id, $input) {
		return $this->userRepo->update($id, $input);
	}
	public function delete($id) {
		return $this->userRepo->delete($id);
	}
	public function createOrUpdate($input, $id = null){

		$newRules = [
	        'username'   => 'required|min:3|max:60|unique:users',
	        'firstname'  => 'required',
	        'lastname'   => 'required',
	        'email'      => 'required|email|unique:users',
	        'type'       => 'required'
    	];

    	if (is_null($id)){
    		$user = new User;
    		$newRules['password'] = 'required|min:6';
    		if (isset($input['type'])&&$input['type'] == 3) {
		    	$newRules['company_name'] = 'required';
		    }
    	}else{
    		$user = $this->byId($id);
    		if(is_null($user)) {
				return Redirect::back();
			}
    	}
    	$user->extendRules($newRules);
		return $this->userRepo->createOrUpdate($input, $user, $id);
	}
	public function bySkillTags($input, $skills, $courses){
		return $this->userRepo->bySkillTags($input, $skills, $courses);
	}
	public function whereHasSkinMulti($table, $arg, $val){
		return $this->userRepo->whereHasSkinMulti($table, $arg, $val);
	}
	public function whereHasSkin($table, $arg, $val){
		return $this->userRepo->whereHasSkin($table, $arg, $val);
	}
	public function bySkill($tag, $skills){
		return $this->userRepo->bySkill($tag, $skills);
	}
}