<?php
class Currency extends Eloquent {
	protected $fillable = ['name'];
	public function project()
    {
        return $this->belongsTo('Project')->withPivot('name');
    }
}