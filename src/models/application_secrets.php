<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationSecrets extends Model {
	protected $connection = 'core';
	protected $table = 'application_secrets';
}