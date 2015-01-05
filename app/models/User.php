<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Watson\Validating\ValidatingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, ValidatingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	protected $fillable = array('firstname', 'lastname', 'username', 'password', 'email', 'gender', 'type', 'company_name', 'avatar');
	protected $throwValidationExceptions = true;
	protected $rules = [
        'username'   => 'required',
        'firstname'  => 'required',
        'lastname'   => 'required',
        'email'      => 'required',
        'type'       => 'required',
    ];

	public function phones(){
		return $this->hasMany('Phone');
	}
	
	public function skills()
    {
        return $this->belongsToMany('Skill')->withPivot('level');
    }

    public function extendRules($newRules){
    	$this->rules = array_merge($newRules, $this->rules);
    }
    public function printRules(){
    	dd($this->rules);
    }

    public function getGenderAttribute(){
    	if ($this->attributes['gender']) {
    		return 'male';
    	}
    	return 'female';
    }

}
