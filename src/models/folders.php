<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folders extends Model {
	protected $connection = 'form_definition';
	protected $table = 'folders';
}