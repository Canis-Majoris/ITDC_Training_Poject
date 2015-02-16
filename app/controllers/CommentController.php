<?php
use pro\gateways\CommentGateway;
class CommentController extends Controller{
	protected $layout = 'layouts.home';
	private $gateway; 

	public function __construct(CommentGateway $gateway) {
		$this->gateway = $gateway;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->gateway->store($input);
		return Redirect::back();
	}

	/**
	 * Return the specified resource using JSON
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Response::json(Comment::find($id));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{	
		$this->gateway->destroy($id);
		return Redirect::back()
			->with('message_type','success')
			->with('message', 'Comment Deleted.');
		//return Response::json(array('success' => true));
	}

	
	public function outputAll($project_id){
		return $data = $this->gateway->collectComments($project_id);
	}

	public function myComments($user_id){
		return $this->gateway->myComments($user_id);
	}

	public function edit($id){
		return Redirect::back();
	}

}