<?php

namespace pro\gateways;
use pro\repositories\UserRepository\UserRepositoryInterface;
class UserGateway {

	private $userRepo;
	public function __construct(UserRepositoryInterface $userRepo) {
		$this->userRepo = $userRepo;
	}

	public function all() {
		return $this->userRepo->all();
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