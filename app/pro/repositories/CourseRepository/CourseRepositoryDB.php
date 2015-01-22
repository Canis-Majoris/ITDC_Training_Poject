<?php
namespace pro\repositories\CourseRepository;
use Course;
use Hash;
use Redirect;
class CourseRepositoryDB implements CourseRepositoryInterface {
	public function all() {
		return Course::get();
	}
	public function withUser($id) {
		return Course::with('users')->find($id);
	}
	public function create($input){
		$course = new Course;
		$course->fill($input);
		$course->save();
		return $course;
	}
	public function byId($id){
		return Course::find($id);
	}
	public function update($id, $input){
		$course = $this->byId($id);
		if(is_null($course)) {
			return Redirect::to('admin/course');
		}
		$course->fill($input);
		$course->save();
	}
	public function delete($id){
		$course = $this->byId($id);
		if(is_null($course)) {
			return Redirect::to('admin/course');
		}
		$course->delete();
	}	
	
}