<?php
class Project extends Eloquent {

	protected $table = 'projects';
	protected $fillable = ['user_id','bid_price','duration','comment','name','description', 'currency'];
	public function users()
    {
        return $this->belongsToMany('User')->withPivot('bid_price','duration','comment');
    }
    public function currencies(){
		return $this->hasMany('Currency');
	}
	public function project_types(){
		return $this->hasMany('Project_type')->withPivot('name','description');
	}
}