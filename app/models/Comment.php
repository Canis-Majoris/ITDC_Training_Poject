<?php

class Comment extends Eloquent {
	protected $fillable = array('author_id', 'body', 'comment_id', 'replaying_id', 'comment_type', 'project_id');	
	 public function user(){
        return $this->belongsTo('User');
    }

    public function parent(){
        return $this->belongsTo('Comment', 'replaying_id');
    }

    public function children(){
        return $this->hasMany('Comment', 'replaying_id');
    }
}