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
	protected $hidden = array('remember_token');
	protected $fillable = array(
		'firstname',
		'lastname',
		'username',
		'password', 
		'password_temp',
		'code', 
		'active',
		'status',
		'email', 
		'gender', 
		'type', 
		'company_name', 
		'avatar',
		'description',
		'reputation',
		'github_token',
		'online'
	);
	protected $throwValidationExceptions = true;
	protected $rules = [];

	public function phones(){
		return $this->hasMany('Phone');
	}
	public function rating(){
		return $this->hasMany('Rating', 'user_id');
	}
	public function projects(){
		
		return $this->belongsToMany('Project')
			->withPivot('bid_price','duration','comment', 'user_id', 'project_id', 'bid_currency', 'created_at', 'id', 'status');
	}
	public function offers(){
		
		return $this->belongsToMany('Project', 'project_user', 'creator_id')
			->withPivot('bid_price','duration','comment', 'user_id', 'project_id', 'bid_currency', 'created_at', 'id', 'status');
	}
	 public function comments()
    {
        return $this->hasMany('Comment');
    }
	public function skills()
    {
        return $this->belongsToMany('Skill')->withPivot('level');
    }

    public function courses()
    {
        return $this->belongsToMany('Course')->withPivot('mark');
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

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
}
