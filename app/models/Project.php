<?php
class Project extends Eloquent {
	protected $fillable = ['user_id','bid_price','duration','comment','name','description'];
	public function users()
    {
        return $this->belongsToMany('User')->withPivot('bid_price','duration','comment');
    }
    public function currencies(){
		return $this->hasMany('Currency')->withPivot('name');
	}
	public function project_types(){
		return $this->hasMany('Project_type')->withPivot('name','description');
	}
}