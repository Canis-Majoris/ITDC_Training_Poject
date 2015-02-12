<?php

namespace pro\gateways;
use pro\repositories\AccountRepository\AccountRepositoryInterface;
use User;
use Redirect;
use DB;
use Account;
use Validator;
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
	public function signIn($input) {

		$validator = Validator::make($input, [
			'email_login'    => 'required',
			'password_login' => 'required'
		]);

		if ($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		}else{
			return $this->accountRepo->signIn($input);
		}
	}

	public function createOrUpdate($input, $id = null){

		$rules = [
			'firstname'  		=> 'required',
    		'lastname'  		=> 'required',
		];
		$newRules = [];

    	if (is_null($id)){
  			//creating new user
    		$user = new User;
    		$newRules = [
				'username'   => 'required|max:30|min:3|unique:users',
				'password'   => 'required|min:6|confirmed',
				'type' 		 => 'required',
				'email'		 => 'required|max:70|email|unique:users'
			];

    		if ($input['type'] == 3) {
				$newRules['company_name'] = 'required';
			}
    	}else{
    		//updating user
    		$user = $this->byId($id);
    		if(is_null($user)) {
				return Redirect::back();
			}

			$emailRule = 'required|max:70|email';

			if ($input['email'] !== $user->email) {
				$emailRule .= '|unique:users';
			}

			$newRules['email'] = $emailRule;

			//updating passowrd
			if (isset($input['pass_change'])) {
				$newRules['old_password'] = 'required|min:6';
				$newRules['password'] = 'required|min:6|confirmed';
			}
    	}
    	//form validation
		$rules = array_merge($rules, $newRules);
		$validator = Validator::make($input, $rules);
    	if ($validator->fails()) {
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		}

		return $this->accountRepo->createOrUpdate($input, $user, $id);
	}
	public function activate($code){
		return $this->accountRepo->activate($code);
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