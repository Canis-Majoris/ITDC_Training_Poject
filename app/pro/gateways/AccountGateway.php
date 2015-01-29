<?php

namespace pro\gateways;
use pro\repositories\AccountRepository\AccountRepositoryInterface;
use User;
use Redirect;
use DB;
use Account;
class AccountGateway {

	private $accountRepo;

	public function __construct(AccountRepositoryInterface $accountRepo) {
		$this->accountRepo = $accountRepo;
	}
	public function all() {
		return $this->userRepo->all();
	}
	public function allStudents(){
		return $this->accountRepo->allStudents();
	}
	public function byId($id) {
		return $this->accountRepo->byId($id);
	}
	public function create($input) {
		return $this->accountRepo->create($input);
	}
	public function byIdWSkills($id) {
		return $this->accountRepo->byIdWSkills($id);
	}
	public function update($id, $input) {
		return $this->accountRepo->update($id, $input);
	}
	public function delete($id) {
		return $this->accountRepo->delete($id);
	}
	public function createOrUpdate($input, $id = null){

		$newrules = [
	        'username'   => 'required|min:3|max:60|unique:users',
	        'firstname'  => 'required',
	        'lastname'   => 'required',
	        'email'      => 'required|email|unique:users',
	        'type'       => 'required'
    	];

    	if (is_null($id)){
    		$user = new User;
    		$newrules['password'] = 'required|min:6';
    		if (isset($input['type'])&&$input['type'] == 3) {
		    	$newrules['company_name'] = 'required';
		    }
    	}else{
    		$user = $this->byId($id);
    		if(is_null($user)) {
				return Redirect::back();
			}
    	}
    	$user->extendRules($newrules);
		return $this->accountRepo->createOrUpdate($input, $user, $id);
	}
	public function bySkillTags($input, $skills, $courses){
		return $this->accountRepo->bySkillTags($input, $skills, $courses);
	}
	public function whereHasSkinMulti($table, $arg, $val){
		return $this->accountRepo->whereHasSkinMulti($table, $arg, $val);
	}
	public function whereHasSkin($table, $arg, $val){
		return $this->accountRepo->whereHasSkin($table, $arg, $val);
	}
	public function bySkill($tag, $skills){
		return $this->accountRepo->bySkill($tag, $skills);
	}
}