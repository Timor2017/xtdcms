<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model {
	protected $connection = 'membership';
	protected $table = 'groups';
}