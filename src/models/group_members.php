<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMembers extends Model {
	protected $connection = 'form_definition';
	protected $table = 'group_members';
}