<?php

class Skill extends Eloquent{	
	protected $fillable = ['name'];
	public function users() {
        return $this->belongsToMany('User')->withPivot('level');
    }

    public function projects() {
		
		return $this->belongsToMany('Project')->withPivot('bid_price','duration','comment', 'user_id', 'project_id', 'bid_currency', 'created_at');
	}
}