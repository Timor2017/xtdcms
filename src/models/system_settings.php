<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSettings extends Model {
	protected $connection = 'core';
	protected $table = 'system_settings';
}