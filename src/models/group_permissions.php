<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupPermissions extends Model {
	protected $connection = 'form_definition';
	protected $table = 'group_permissions';
}