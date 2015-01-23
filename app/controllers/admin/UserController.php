<?php
use pro\gateways\UserGateway;

class UserController extends BaseController {

	protected $layout = 'layouts.admin';
	protected $users_skills = 'ITDC_Project.admin.users.index';
	private $gateway;

	public function __construct(UserGateway $gateway) {
		$this->gateway = $gateway;
	}

	public function index() {
		$users = $this->gateway->allStudents();
		$skills = Skill::all();
		$courses = Course::all();
		$this->layout->content  = View::make('ITDC_Project.admin.users.index')->with(['skills' => $skills, 'tagname' => [], 'courses' => $courses, 'courseTagname' => []]);
		$this->layout->content->usr_skl = View::make('ITDC_Project.admin.users.byskills_load', ['users' => $users->paginate(80), 'skills' => $skills, 'tagname' => [], 'courses' => $courses, 'courseTagname' => []]);
	}

	public function show($id) {
		$user = $this->gateway->byId($id);
		$this->layout->content = View::make('ITDC_Project.admin.users.show')->with('user', $user);
	}

	public function create() {
		$skills = Skill::get();
		$courses = Course::get();
		$this->layout->content = View::make('ITDC_Project.admin.users.create')->with(['skills'=> $skills, 'courses' => $courses]);
	}

	public function store() {
		$input = Input::all();
		$this->gateway->createOrUpdate($input);
		return Redirect::to('admin/user')
			->with('message_type','success')
			->with('message', 'User added successfully');
	}

	public function edit($id) {
		$user = $this->gateway->byIdWSkills($id);
		$skills = Skill::get();
		$courses = Course::get();
		$this->layout->content = View::make('ITDC_Project.admin.users.edit')->with(array(
			'user'=> $user,
			'skills'=> $skills,
			'courses' => $courses
		));
	}

	public function update($id) {
		$input = Input::all();
		$this->gateway->createOrUpdate($input, $id);
		return Redirect::to('admin/user')
			->with('message_type','success')
			->with('message', 'User updated successfully');
	}

	public function destroy($id) {
		$this->gateway->delete($id);
		return Redirect::back()
			->with('message_type','success')
			->with('message', 'User deleted successfully');
	}

	public function filterSkills(){
		$input = Input::all();
		$skills = Skill::all();
		$courses = Course::all();
		$data = $this->gateway->bySkillTags($input, $skills, $courses);
		if (is_array($data)) {
			Input::flash();
			$this->layout->content = View::make('ITDC_Project.admin.users.index', ['skills' => $skills, 'tagname' => $data['tagname'], 'courses' => $courses, 'courseTagname' => $data['courseTagname']]);
			$this->layout->content->usr_skl = View::make('ITDC_Project.admin.users.byskills_load', $data);
		}else{ 
			return Redirect::to('admin/user');
		}
	}

	public function byTag($tag){
		$skills = Skill::all();
		$courses = Course::all();
		$data = $this->gateway->bySkill($tag, $skills);
		$this->layout->content = View::make('ITDC_Project.admin.users.index', ['skills' => $skills, 'tagname' => $data['tagname'], 'courses' => $courses, 'courseTagname' => []]);
		$this->layout->content->usr_skl = View::make('ITDC_Project.admin.users.byskills_load', $data);
	}

}
