<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forms extends Model {
	protected $connection = 'form_definition';
	protected $table = 'forms';
}