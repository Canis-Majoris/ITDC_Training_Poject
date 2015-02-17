<?php
class Rating extends Eloquent {
	protected $fillable = ['value', 'rater_id', 'type'];
	public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
}