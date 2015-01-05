<?php
namespace pro\repositories\UserRepository;
use User;
use Hash;
use Skill;
use Phone;
use Redirect;
use DB;
class UserRepositoryDb implements UserRepositoryInterface {

	public function all() {
		return User::where('type', '=', '0')->orWhere('type', '=', '1')->with('skills');
	}

	public function byId($id) {
		return User::with('phones')->find($id);
	}

	public function whereHasSkinMulti($langArr, $skillArr, $optimal){
		//dd($optimal);
		$users = $this->all();
		if ($optimal == null) {
			$data = $users->whereHas('skills', function($q) use($langArr)
			{
				$q->whereIn('name', $langArr);
			}, '=', count($langArr));
		}else{
			$data = $users;
			foreach ($skillArr as $skl) {
				$data->whereHas('skills', function($q) use($skl, $optimal)
				{
					$q->where('skill_id', $skl);
					if (isset($optimal[$skl])) {
						$q->where('level', '>=', $optimal[$skl]);
					}
				});
			}
		}

		return $data->with('skills');
	}

	public function whereHasSkin($table, $arg, $val, $byArg){

		$comp = [$arg, $val, $byArg];
		$users = $this->all();
		$data = $users->whereHas($table, function($q) use($comp)
		{
			$q->where($comp[0], $comp[2], $comp[1]);
		})->with($table);

		return $data;
	}

	public function managePhones($user, $phones){
			$allPhones = [];
			foreach ($phones as $k => $v) {
				if ($v!=null) {
					$allPhones[] = new Phone(['phone' => $v]);
				}
			}
			$user->phones()->delete();
			$user->phones()->saveMany($allPhones);
	}

	public function manageSkills($user, $skills, $levels){
		$sl = [];
		foreach ($skills as $skill) {
			if (!empty($levels[$skill])) {
				$sl[$skill] = ['level' => $levels[$skill]];
			}
			$user->skills()->sync($sl);
		}
	}

	public function updateSkillsPhones($user, $phones, $skills, $levels){
		if (isset($skills) && isset($levels)) {
			$this->manageSkills($user, $skills, $levels);
		}
		if (isset($phones)) {
			$this->managePhones($user, $phones);
		}
	}

	public function create($input) {
	    $user = new User;
	    //dd($user->rules);
	    $newrules['password'] = 'required';
	    
	    
	    if (isset($input['password'])) {
	    	$user->password = Hash::make($input['password']);
	    }

	    if (isset($input['type'])&&$input['type'] == 3) {
	    	$newrules['company_name'] = 'required';
	    }
	    $user->extendRules($newrules);
	    $user->fill($input);
		$user->save();
		$phones = null;
		if (isset($input['phone'])) {
			$phones = $input['phone'];
		}
		$skills = null; $levels = null;
		if (isset($input['skill']) && isset($input['level'])) {
			$skills = $input['skill'];
			$levels = $input['level'];
		}
		$this->updateSkillsPhones($user, $phones, $skills, $levels);
		return $user;
	}

	public function byIdWSkills($id) {
		return  User::with('phones')->with('skills')->find($id);
	}
	
	public function update($id, $input) {
		$user = $this->byId($id);
		if(is_null($user)) {
			return Redirect::to('admin/user');
		}
		$user->fill($input);
		if($pass = $input['password']) {
			$user->password = Hash::make($pass);
		}
		$user->save();
		$phones = null;
		if (isset($input['phone'])) {
			$phones = $input['phone'];
		}
		$skills = null; $levels = null;
		if (isset($input['skill']) && isset($input['level'])) {
			$skills = $input['skill'];
			$levels = $input['level'];
		}
		$this->updateSkillsPhones($user, $phones, $skills, $levels);
		return $user;
		
	}

	public function delete($id) {
		$user = $this->byId($id);
		if(is_null($user)) {
			return Redirect::to('admin/user');
		}
		$user->delete();
	}

	public function bySkillTags($input, $skills){
		$levels = $input['levelFil'];
		if (!isset($input['skillFil'])) {
			$users = $this->all();
			return 0;
		}
		$skill = $input['skillFil'];
		$optional = null;
		$skillArr = [];
		$langArr = [];
		foreach ($levels as $k => $v) {
			if($v!=0){
				$optional[$k] = $v;
			}
		}
		foreach ($skill as $id) {
			$sk = Skill::find($id);
			$langArr[] = $sk->name;
			$skillArr[] = $id;
		}
		//dd($optional);
		$users = $this->whereHasSkinMulti($langArr, $skillArr, $optional);
		return ['users' => $users->paginate(40), 'skills' => $skills, 'tagname' => $langArr];
	}

	

	public function bySkill($tag, $skills){
		$users = $this->whereHasSkin('skills', 'name', $tag, '=');
		return ['users' => $users->paginate(40), 'skills' => $skills, 'tagname' => [$tag]];
	}
}