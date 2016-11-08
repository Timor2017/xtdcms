<?php
namespace App\Models;

class FormItems extends BaseModel {
	protected $connection = 'form_definition';
	protected $table = 'form_items';
	
	public function permissions()
	{
		return $this->morphMany('\App\Models\Permissions', 'target');
	}	
	
	public function properties()
	{
		return $this->hasMany('App\Models\FormItemProperties', 'form_item_id', 'id');
	}	
}