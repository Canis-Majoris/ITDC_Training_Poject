<?php
namespace pro\repositories\UserRepository;
use User;
use Hash;
use Skill;
use Phone;
use Course;
use Redirect;
use DB;
class UserRepositoryDb implements UserRepositoryInterface {

	public function all() {
		return User::where('type', '=', '0')->orWhere('type', '=', '1');
		//return User::all();
	}

	public function byId($id) {
		return User::with('phones')->find($id);
	}

	public function whereHasSkillMulti($langArr, $skillArr, $optimal, $users){
		$U = $users;
		if ($optimal == null) {
			$data = $U->whereHas('skills', function($q) use($langArr)
			{
				$q->whereIn('name', $langArr);
			}, '=', count($langArr));
		}else{
			$data = $U;
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

		return $data->with('skills')->with('courses');
	}

	public function whereHasCourseMulti($langArr, $skillArr, $optimal, $users){
		$U = $users;
		if ($optimal == null) {
			$data = $U->whereHas('courses', function($q) use($langArr)
			{
				$q->whereIn('name', $langArr);
			}, '=', count($langArr));
		}else{

			$data = $U;
			foreach ($skillArr as $skl) {
				$data->whereHas('courses', function($q) use($skl, $optimal)
				{
					$q->where('course_id', $skl);
					if (isset($optimal[$skl])) {
						$q->where('mark', '>=', $optimal[$skl]);
					}
				});
			}
		}

		return $data->with('skills')->with('courses');
	}

	public function whereHasSkill($table, $arg, $val, $byArg){

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

	    $newrules = [
	        'username'   => 'required',
	        'firstname'  => 'required',
	        'lastname'   => 'required',
	        'email'      => 'required|email',
	        'type'       => 'required',
	        'password'   => 'required|min:6'
    	];

	    if (isset($input['type'])&&$input['type'] == 3) {
	    	$newrules['company_name'] = 'required';
	    }
	    $user->extendRules($newrules);
	    if (isset($input['password'])) {
	    	$input['password'] = Hash::make($input['password']);
	    }
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

		$newrules = [
	        'username'   => 'required',
	        'firstname'  => 'required',
	        'lastname'   => 'required',
	        'email'      => 'required|email',
	        'type'       => 'required',
    	];
    	$user->extendRules($newrules);
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

	public function bySkillTags($input, $skills, $courses){
		$users = User::where('type', '=', '1');

		$levels_sk = $input['levelFil'];
		$levels_cr = $input['cr_levelFil'];
		$langArr_cr = [];
		$langArr_sk = [];

		if (!isset($input['skillFil']) && !isset($input['courseFil'])) {
			$users = $this->all();
			return 0;
		}
		if (isset($input['skillFil'])) {
			$skill = $input['skillFil'];
			$optional1 = null;
			$skillArr = [];
			
			foreach ($levels_sk as $k => $v) {
				if($v!=0){
					$optional1[$k] = $v;
				}
			}
			foreach ($skill as $id) {
				$sk = Skill::find($id);
				$langArr_sk[] = $sk->name;
				$skillArr[] = $id;
			}
			//dd($optional);
			$users = $this->whereHasSkillMulti($langArr_sk, $skillArr, $optional1, $users);
		}
		if (isset($input['courseFil'])) {
			$course = $input['courseFil'];
			$optional2 = null;
			$courseArr = [];
			
			foreach ($levels_cr as $k => $v) {
				if($v!=0){
					$optional2[$k] = $v;
				}
			}
			foreach ($course as $id) {
				$sk = Course::find($id);
				$langArr_cr[] = $sk->name;
				$courseArr[] = $id;
			}
			$users = $this->whereHasCourseMulti($langArr_cr, $courseArr, $optional2, $users);
		}
		
		return ['users' => $users->paginate(80), 'skills' => $skills, 'tagname' => $langArr_sk, 'courses' => $courses, 'courseTagname' => $langArr_cr];
	}

	

	public function bySkill($tag, $skills){
		$courses = Course::all();
		$users = $this->whereHasSkill('skills', 'name', $tag, '=');
		return ['users' => $users->paginate(80), 'skills' => $skills, 'tagname' => [$tag], 'courses' => $courses, 'courseTagname' => []];
	}
}