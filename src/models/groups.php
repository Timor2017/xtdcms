<?php
namespace App\Models;

class Groups extends BaseModel {
	protected $connection = 'membership';
	protected $table = 'groups';
	
	public function permissions()
	{
		return $this->morphMany('\App\Models\Permissions', 'target')->where('status', STATUS_ACTIVE);
	}	
	
	public function all_permissions()
	{
		return $this->morphMany('\App\Models\Permissions', 'target');
	}	
	
	public function members() {
		return $this->belongsToMany('App\Models\Members', 'group_members', 'group_id', 'member_id')->where('status', STATUS_ACTIVE);
	}
	
	public function all_members() {
		return $this->belongsToMany('App\Models\Members', 'group_members', 'group_id', 'member_id');
	}
}