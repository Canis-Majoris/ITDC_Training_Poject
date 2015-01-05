<?php
class Phone extends Eloquent {
	protected $fillable = ['phone'];
	public function user()
    {
        return $this->belongsTo('User')->withPivot('phone');
    }
}