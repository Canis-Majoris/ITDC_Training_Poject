<?php
use pro\gateways\SkillGateway;

class SkillController extends BaseController {

	protected $layout = 'layouts.admin';
	private $gateway;

	public function __construct(SkillGateway $gateway) {
		$this->gateway = $gateway;
		
	}

	public function index()
	{
		$skills = $this->gateway->all();
		return View::make('ITDC_Project.admin.skills.index')->with('skills', $skills);
	}
	public function show($id) {
		$skill = $this->gateway->withUser($id);
		return View::make('ITDC_Project.admin.skills.show')->with('skill', $skill);
	}

	public function create() {
		return View::make('ITDC_Project.admin.skills.create');
	}

	public function store() {
		$input = Input::all();
		$this->gateway->create($input);
		return Redirect::to('admin/skill')
			->with('message_type','success')
			->with('message', 'Skill added successfully');
	}

	public function edit($id) {
		$skill = $this->gateway->byId($id);
		return View::make('ITDC_Project.admin.skills.edit')->with('skill', $skill);
	}

	public function update($id) {
		$input = Input::all();
		$this->gateway->update($id, $input);
		return Redirect::to('admin/skill')
			->with('message_type','success')
			->with('message', 'Skill updated successfully');
	}

	public function destroy($id) {
		$this->gateway->delete($id);
		return Redirect::to('admin/skill')
			->with('message_type','success')
			->with('message', 'User deleted successfully');
	}

}
