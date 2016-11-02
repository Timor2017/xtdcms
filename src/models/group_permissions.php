<?php
namespace App\Models;

class GroupPermissions extends BaseModel {
	protected $connection = 'membership';
	protected $table = 'group_permissions';
}