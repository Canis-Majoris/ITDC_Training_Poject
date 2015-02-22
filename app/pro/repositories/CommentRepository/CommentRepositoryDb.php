<?php
namespace pro\repositories\CommentRepository;
use User;
use Hash;
use Skill;
use Phone;
use Course;
use Mail;
use URL;
use Redirect;
use DB;
use Auth;
use Account;
use Input;
use Comment;
use Project;
class CommentRepositoryDb implements CommentRepositoryInterface {

	public function collect($project_id){
		$comments = Comment::where('project_id', '=', $project_id)->where('replaying_id', '=', 0)->orderBy('created_at', 'DESC')->get();
		$user = Auth::user();
		$project = Project::find($project_id);
		$data['project'] = $project;
		$data['user'] = $user;
		$rendered = null;
		if ($comments->count()>0) {

			$rendered = $this->render_tree($comments, $data);
			//$rendered = $comments->first()->render_tree($comments, $data);
		}
		return $rendered;
	}
	public function store($input){
		$user = User::find($input['user_id']);
		unset($input['user_id']);

		$comment = new Comment;
		$comment->fill($input);
		
		if (isset($input['comment_type'])) {
			$comment->comment_type = $input['comment_type'];
		}
		if (isset($input['replaying_id'])) {
			$comment->replaying_id = $input['replaying_id'];
		}
		$user->comments()->save($comment);
	}

	public function destroy($id){
		Comment::where('replaying_id', '=', $id)->delete();
		Comment::destroy($id);
	}

	public function myComments($user_id){
		$counter = 0;
		$user = User::find($user_id);
		$comments = $user->comments()->get();
		foreach ($comments as $comment) {
			$counter += $comment->children()->count();
		}
		//return $counter;
	}

	//Render tree nodes
	public function render_tree($tree, $data)
	{
		$rendered = '';
	    foreach($tree as $node)
	    {
	        $rendered = $this->render_node($rendered, $node, $data);
	    }
	    return $rendered;
	}

	// REcursive function for outputing Comments
	public function render_node($rendered, $comment, $data, $level = 0)
	{
		$otheruser =  User::find($comment->user_id);
		$authUser = Auth::user();
		$avatar = $otheruser->avatar;
		$activeIndicator = '';
	    $rendered 		.= '<div class="comment_container"><div class="avatar_wrap_3">';

		if($avatar){
			$rendered 	.= '<img src="/uploads/'.$avatar.'" class="img-rounded img-responsive" alt="Responsive image"/>';
		}else{
			$rendered 	.= '<img src="http://www.miyokids.com/catalog/view/theme/ULTIMATUM/image/no_avatar.jpg" class="img-rounded img-responsive" alt="Responsive image"/>';
		}

		$rendered 		.= '</div>
			<div class="pill-left content">
				<a href="'.URL::route('user-profile', $otheruser->username).'" class="author pull-left">'.$otheruser->username.'</a>';
		if ($otheruser->online) {
			$activeIndicator = 'good';
		}
		$rendered 		.= '<span class="glyphicon glyphicon-globe '.$activeIndicator.' pull-left online_indicator"></span>';
		if ($comment->replaying_id != 0) {
			$rendered 	.= '<span class="replaying_to"><span class="glyphicon glyphicon-share-alt"></span> '.User::find($comment->parent->user_id)->username.'</span>';
		}	

		$rendered 		.= '<span class="time pull-left"> posted'.$comment->created_at->diffForHumans().'</span>
				<div class="clear"></div>
				<p class="">'.$comment->body.'</p>
			</div>
			<div class="clear"></div>
		</div>';
		$project = Project::find($comment->project_id);
		//dd($authUser->id);
		if($otheruser->id == $data['user']->id || $project->user_id == $authUser->id || $authUser->type == 0){
			$rendered 	.= '<a href="'.URL::route('comment-delete', $comment->id).'"><span class="glyphicon glyphicon-remove-circle bad delete_comment" data-toggle="tooltip" 
			title="Delete Comment"><span></a>';
		}
		$rendered 		.= '<a class="replay_button">Replay</a>
	  	<div class="write_comment_wrapper">
			<input type="hidden" name="project_id" placeholder="Name" value="'.$data['project']->id.'" class="subinput">
			<input type="hidden" name="user_id" placeholder="Name" value="'.$data['user']->id .'" class="subinput">
			<input type="hidden" name="replaying_id" placeholder="Name" value="'.$comment->id.'" class="subinput">
			<div class="form-group">
				<input type="text" class="form-control input-lg mycomment subinput pill-left" name="body" placeholder="Say what you have to say">
				<button type="submit" class="btn btn-primary btn-lg commentSubmit pull-right"><span class="glyphicon glyphicon-share-alt send_comment"></span></button>
				<div class="clear"></div>
			</div>
		</div>';
	   	
	   	//Recursion
	    if ($comment->children->count() > 0)
	    {
	    	$ordererComments = $comment->children()->orderBy('created_at', 'DESC')->get();
			$rendered 	.= '<a class="show_discussion"><span class="glyphicon glyphicon-chevron-down"> 
				</span> <span class="badge" style="font-size:8px; background:#3E84C2;">'.$comment->children->count().'</span></a><div style="width:95%;" class="pull-right replays">';
	        foreach($ordererComments as $k)
	        {	
	           $rendered = $this->render_node($rendered, $k, $data, $level+1);
	        }
	        $rendered 	.= '</div><div class="clear"></div>';
	    }
	    $rendered 		.= '';

	    return $rendered;
	}
}