<?php
class Project_type extends Eloquent {
	protected $fillable = ['name','description'];
	public function project()
    {
        return $this->belongsTo('Project')->withPivot('name','description');
    }
}