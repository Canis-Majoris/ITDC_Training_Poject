<?php
use pro\gateways\CourseGateway;

class CourseController extends BaseController {

	protected $layout = 'layouts.admin';
	private $gateway;
	
	public function __construct(CourseGateway $gateway) {
		$this->gateway = $gateway;
	}
	public function index()
	{
		$courses = $this->gateway->all();
		return View::make('ITDC_Project.admin.courses.index')->with('courses', $courses);
	}
	public function show($id) {
		$course = $this->gateway->withUser($id);
		return View::make('ITDC_Project.admin.courses.show')->with('course', $course);
	}
	public function create() {
		return View::make('ITDC_Project.admin.courses.create');
	}
	public function store() {
		$input = Input::all();
		$this->gateway->create($input);
		return Redirect::to('admin/course')
			->with('message_type','success')
			->with('message', 'Course added successfully');
	}
	public function edit($id) {
		$course = $this->gateway->byId($id);
		return View::make('ITDC_Project.admin.courses.edit')->with('course', $course);
	}
	public function update($id) {
		$input = Input::all();
		$this->gateway->update($id, $input);
		return Redirect::to('admin/course')
			->with('message_type','success')
			->with('message', 'Course updated successfully');
	}
	public function destroy($id) {
		$this->gateway->delete($id);
		return Redirect::to('admin/course')
			->with('message_type','success')
			->with('message', 'Course deleted successfully');
	}
}