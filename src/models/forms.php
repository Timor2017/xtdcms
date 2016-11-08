<?php
namespace App\Models;

class Forms extends BaseModel {
	protected $connection = 'form_definition';
	protected $table = 'forms';
	
	public function permissions()
	{
		return $this->morphMany('\App\Models\Permissions', 'target');
	}	
	
	public function properties()
	{
		return $this->hasMany('App\Models\FormProperties', 'form_id', 'id');
	}	
	
	public function items()
	{
		return $this->hasMany('App\Models\FormItems', 'form_id', 'id');
	}	
}