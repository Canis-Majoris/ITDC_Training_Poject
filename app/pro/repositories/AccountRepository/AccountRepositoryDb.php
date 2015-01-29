<?php
namespace pro\repositories\AccountRepository;
use User;
use Hash;
use Skill;
use Phone;
use Course;
use Mail;
use URL;
use Redirect;
use DB;
use Account;
use Input;
class AccountRepositoryDb implements AccountRepositoryInterface {
	/*
	/ retrieving company employees
	*/
	public function all() {
		return User::where( function ($q) {
                $q->where('type','=', '1')
                    ->orWhere('type','=','2')
                    ->orWhere('type','=','3');
            });
		//return User::all();
	}

	public function allStudents() {
		return User::where( function ($q) {
                $q->where('type','=', '0')
                    ->orWhere('type','=','1');
            });
		//return User::all();
	}

	public function byIdWSkills($id) {
		return  User::with('phones')->with('skills')->with('courses')->find($id);
	}
	/*
	/ retrieving user by id
	*/
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
		$users = $this->allStudents();
		$data = $users->whereHas($table, function($q) use($comp)
		{
			$q->where($comp[0], $comp[2], $comp[1]);
		})->with($table);

		return $data;
	}

//---------------------------------------------------------------------------------------------------------------------
	/*
	/ Additional data update functions
	*/

	//for phones
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

	//for skills
	public function manageSkills($user, $skills, $levels){
		$sl = [];
		foreach ($skills as $skill) {
			if (!empty($levels[$skill])) {
				$sl[$skill] = ['level' => $levels[$skill]];
			}
			$user->skills()->sync($sl);
		}
	}

	//for courses
	public function manageCourses($user, $courses, $levels){

		$sl = [];
		foreach ($courses as $course) {
			if (!empty($levels[$course])) {
				$sl[$course] = ['mark' => $levels[$course]];
			}
			$user->courses()->sync($sl);
		}
	}
//---------------------------------------------------------------------------------------------------------------------
	/*
	/ Helper function for ditributing additional data updates
	*/
	public function updateAll($user, $updateData){
		if (isset($updateData['skills']) && isset($updateData['levels_sk'])) {
			$this->manageSkills($user, $updateData['skills'], $updateData['levels_sk']);
		}
		if (isset($updateData['courses']) && isset($updateData['levels_cr'])) {
			$this->manageCourses($user, $updateData['courses'], $updateData['levels_cr']);
		}
		if (isset($updateData['phones'])) {
			$this->managePhones($user, $updateData['phones']);
		}
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function createOrUpdate($input, $user, $id) {

		if (is_null($id)) {
			//create new user
		    $user->fill($input);
		    if (!empty($input['password']) && strlen($input['password']) >= 6) {
		    	$user->password = Hash::make($input['password']);
		    }
		    $code = str_random(60);
		    $user->code = $code;
		    $user->active = 0;
		    if($user->save()){
				Mail::send('emails.auth.activate', ['link' => URL::route('account-activate', $code), 'username' => $input['username'], 'name' => 'Gigi'], function($message) use($user) {
					$message->to($user->email, $user->username)->subject('ITDC Project Account Activation');
				});
			}

		}else{
			if (!empty($input['password'])) {
				$input['password'] = Hash::make($input['password']);
			}else{
				unset($input['password']);
			}
			$user->fill($input);
			$user->save();
		}
		if (Input::file('file')!=null) {
			$avatarName = str_random(40).'.'.Input::file('file')->guessClientExtension();
			Input::file('file')->move('./public/uploads',$avatarName);
			$user->avatar=$avatarName;
		}

		$user->save();

		$phones = null;
		if (array_filter($input['phone'])) {
			$phones = $input['phone'];
		}
		$skills = null; $levels_sk = null;
		
		if (isset($input['skill']) && array_filter($input['level'])) {
			$skills = $input['skill'];
			$levels_sk = $input['level'];
		}
		$courses = null; $levels_cr = null;
		if (isset($input['course']) && array_filter($input['level_cr'])) {
			$courses = $input['course'];
			$levels_cr = $input['level_cr'];
		}

		// All data to update
		$updateData = [
			'phones' => $phones,
			'skills' => $skills,
			'levels_sk' => $levels_sk,
			'courses' => $courses,
			'levels_cr' => $levels_cr
		];
		$this->updateAll($user, $updateData);
		return $user;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	

	public function delete($id) {
		$user = $this->byId($id);
		if(is_null($user)) {
			return Redirect::back();
		}
		$user->delete();
	}

	public function bySkillTags($input, $skills, $courses){
		$users = $this->allStudents();

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

	
	/*
	/ filtering by one tag
	*/
	public function bySkill($tag, $skills){
		$courses = Course::all();
		$users = $this->whereHasSkill('skills', 'name', $tag, '=');
		return ['users' => $users->paginate(80), 'skills' => $skills, 'tagname' => [$tag], 'courses' => $courses, 'courseTagname' => []];
	}

//---------------------------------------------------------------------------------------------------------------------

}