<?php

namespace pro\gateways;
use pro\repositories\CourseRepository\CourseRepositoryInterface;
class CourseGateway {

	private $courseRepo;
	public function __construct(CourseRepositoryInterface $courseRepo) {
		$this->courseRepo = $courseRepo;
	}
	public function all(){
		return $this->courseRepo->all();
	}
	public function withUser($id){
		return $this->courseRepo->withUser($id);
	}
	public function create($input){
		return $this->courseRepo->create($input);
	}
	public function byId($id){
		return $this->courseRepo->byId($id);
	}
	public function update($id, $input){
		return $this->courseRepo->update($id, $input);
	}
	public function delete($id){
		return $this->courseRepo->delete($id);
	}
}