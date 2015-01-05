<?php

use News;
	class NewsController extends BaseController {

		public function __construct()
	    {
	        $this->layout = 'layouts.newstemp';
	    }

		public function getindex(){
			$this->layout->content = View::make('news.mainpage', ['news' => News::paginate(7)]);
		}
		
		public function newsInd($atr, $par){
			$news = News::where($atr, '=', $par)->get();
			$this->layout->content = View::make('news.getnews', ['news' => $news, 'attribute' => $atr]);
		}

	}
?>