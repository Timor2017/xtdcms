<?php
namespace App\Models;

class Members extends BaseModel {
	protected $connection = 'membership';
	protected $table = 'members';
	
	public function groups() {
		return $this->belongsToMany('App\Models\Groups', 'group_members', 'member_id', 'group_id');
	}
}