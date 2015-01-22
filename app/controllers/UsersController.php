<?php
	class UsersController extends BaseController {

		public function __construct()
	    {
	        $this->layout = 'layouts.admintemp';
	    }

		public function getindex(){
			$this->layout->content = View::make('users.getusers', ['users' => User::paginate(25)]);
		}
		
		public function userInd($atr, $par){
			$news = User::where($atr, '=', $par)->get();
			$this->layout->content = View::make('news.getnews', ['news' => $news, 'attribute' => $atr]);
		}

	}
?>