<?php
namespace App\Models;

class Forms extends BaseModel {
	protected $connection = 'form_definition';
	protected $table = 'forms';
	
	public function permissions()
	{
		return $this->morphMany('\App\Models\Permissions', 'target')->where('status', STATUS_ACTIVE);
	}	
	
	public function properties()
	{
		return $this->morphMany('\App\Models\ItemProperties', 'target')->where('status', STATUS_ACTIVE);
		//return $this->hasMany('App\Models\FormProperties', 'form_id', 'id');
	}	
	
	public function items()
	{
		return $this->hasMany('App\Models\FormItems', 'form_id', 'id')->where('status', STATUS_ACTIVE);
	}	
	
	public function datas()
	{
		return $this->hasMany('App\Models\FormDatas', 'form_id', 'id')->where('status', STATUS_ACTIVE);
	}	
	
	public function all_permissions()
	{
		return $this->morphMany('\App\Models\Permissions', 'target');
	}	
	
	public function all_properties()
	{
		return $this->morphMany('\App\Models\ItemProperties', 'target');
		//return $this->hasMany('App\Models\FormProperties', 'form_id', 'id');
	}	
	
	public function all_items()
	{
		return $this->hasMany('App\Models\FormItems', 'form_id', 'id');
	}	
}