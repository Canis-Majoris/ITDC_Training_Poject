<?php

class Skill extends Eloquent{	
	protected $fillable = ['name'];
	public function users() {
        return $this->belongsToMany('User')->withPivot('level');
    }
    public function projects() {
        return $this->belongsToMany('Project')->withPivot('level');
    }

}