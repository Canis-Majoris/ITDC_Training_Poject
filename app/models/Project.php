<?php

use Watson\Validating\ValidatingTrait;
class Project extends Eloquent {
	use ValidatingTrait;
	protected $throwValidationExceptions = true;
	protected $rules = [];

	//protected $table = 'projects';
	protected $fillable = ['user_id','bid_price', 'bid_currency', 'duration','comment','name','description', 'currency', 'salary'];
	public function users(){
        return $this->belongsToMany('User')->withPivot('bid_price','duration','comment', 'user_id', 'project_id', 'bid_currency', 'created_at');
    }
    public function currencies(){
		return $this->hasMany('Currency');
	}
	public function project_types(){
		return $this->hasMany('Project_type')->withPivot('name','description');
	}
	public function extendRules($newRules){
    	$this->rules = array_merge($newRules, $this->rules);
    }
    public function skills(){
        return $this->belongsToMany('Skill')->withPivot('bid_price','duration','comment', 'user_id', 'project_id', 'bid_currency', 'created_at');
    }
}