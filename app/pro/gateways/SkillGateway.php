<?php

namespace pro\gateways;
use pro\repositories\SkillRepository\SkillRepositoryInterface;
class SkillGateway {

	private $skillRepo;
	public function __construct(SkillRepositoryInterface $skillRepo) {
		$this->skillRepo = $skillRepo;
	}
	public function all(){
		return $this->skillRepo->all();
	}
	public function withUser($id){
		return $this->skillRepo->withUser($id);
	}
	public function create($input){
		return $this->skillRepo->create($input);
	}
	public function byId($id){
		return $this->skillRepo->byId($id);
	}
	public function update($id, $input){
		return $this->skillRepo->update($id, $input);
	}
	public function delete($id){
		return $this->skillRepo->delete($id);
	}
}