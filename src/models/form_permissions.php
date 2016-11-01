<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormPermissions extends Model {
	protected $connection = 'form_definition';
	protected $table = 'form_permissoins';
}