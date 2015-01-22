<?php 

namespace pro\repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
	public function register() {
		$this->app->bind('pro\repositories\UserRepository\UserRepositoryInterface', 'pro\repositories\UserRepository\UserRepositoryDb');
		$this->app->bind('pro\repositories\SkillRepository\SkillRepositoryInterface', 'pro\repositories\SkillRepository\SkillRepositoryDB');
		$this->app->bind('pro\repositories\CourseRepository\CourseRepositoryInterface', 'pro\repositories\CourseRepository\CourseRepositoryDB');				
	}
}