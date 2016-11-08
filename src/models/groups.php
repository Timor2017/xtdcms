<?php
namespace App\Models;

class Groups extends BaseModel {
	protected $connection = 'membership';
	protected $table = 'groups';
	
	public function permissions()
	{
		return $this->morphMany('\App\Models\Permissions', 'target');
	}	
	
	public function members() {
		return $this->belongsToMany('App\Models\Members', 'group_members', 'group_id', 'member_id');
	}
}