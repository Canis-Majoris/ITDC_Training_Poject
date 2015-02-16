<?php

namespace pro\gateways;
use pro\repositories\CommentRepository\CommentRepositoryInterface;
use User;
use Redirect;
use DB;
use Account;
use Validator;
use Comment;
class CommentGateway {

	private $commentRepo;

	public function __construct(CommentRepositoryInterface $commentRepo) {
		$this->commentRepo = $commentRepo;
	}
	public function destroy($id){
		return $this->commentRepo->destroy($id);
	}
	public function collectComments($project_id){
		return $this->commentRepo->collect($project_id);
	}
	public function myComments($user_id){
		return $this->commentRepo->myComments($user_id);
	}
	public function store($input){
		return $this->commentRepo->store($input);
	}
}