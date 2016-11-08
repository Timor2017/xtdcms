<?php
namespace App\Models;

class Folders extends BaseModel {
	protected $connection = 'form_definition';
	protected $table = 'folders';
	
	public function permissions()
	{
		return $this->morphMany('\App\Models\Permissions', 'target')->where('status', STATUS_ACTIVE);
	}	
	
	public function all_permissions()
	{
		return $this->morphMany('\App\Models\Permissions', 'target');
	}	
	
	public function forms()
	{
		return $this->hasMany('App\Models\Forms', 'folder_id', 'id');->where('status', STATUS_ACTIVE)
	}	
	
	public function all_forms()
	{
		return $this->hasMany('App\Models\Forms', 'folder_id', 'id');
	}	

	public function subfolders()
	{
		return $this->hasMany('App\Models\Folders', 'parent_id', 'id')->where('status', STATUS_ACTIVE);
	}

	public function all_subfolders()
	{
		return $this->hasMany('App\Models\Folders', 'parent_id', 'id');
	}
	
	public function parentfolder()
	{
		return $this->belongsTo('App\Models\Folders', 'id', 'parent_id')->where('status', STATUS_ACTIVE);
	}
}