<?php
namespace pro\repositories\SkillRepository;
use Skill;
use Hash;
use Redirect;
class SkillRepositoryDb implements SkillRepositoryInterface {
	public function all() {
		return Skill::get();
	}
	public function withUser($id) {
		return Skill::with('users')->find($id);
	}
	public function create($input){
		$skill = new Skill;
		$skill->fill($input);
		$skill->save();
		return $skill;
	}
	public function byId($id){
		return Skill::find($id);
	}
	public function update($id, $input){
		$skill = $this->byId($id);
		if(is_null($skill)) {
			return Redirect::to('admin/skill');
		}
		$skill->fill($input);
		$skill->save();
	}
	public function delete($id){
		$skill = $this->byId($id);
		if(is_null($skill)) {
			return Redirect::to('admin/skill');
		}
		$skill->delete();
	}	
	
}