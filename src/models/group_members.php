<?php
namespace App\Models;

class GroupMembers extends BaseModel {
	protected $connection = 'membership';
	protected $table = 'group_members';

	public function member()
	{
		return $this->belongsTo('App\Models\Members', 'member_id', 'id')->where('members.status', STATUS_ACTIVE);
	}

	public function group()
	{
		return $this->belongsTo('App\Models\Groups', 'group_id', 'id')->where('groups.status', STATUS_ACTIVE);
	}
}