<?php
	class ContactController extends BaseController {
		public function getIndex(){
			//return 'contact';
			$this->layout->content = View::make('contact.index');
		}
		public function postIndex(){
			//return 'contact';
			$this->layout->content = 'contact post method';
		}
	}
?>