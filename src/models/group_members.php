<?php
namespace App\Models;

class GroupMembers extends BaseModel {
	protected $connection = 'membership';
	protected $table = 'group_members';
}