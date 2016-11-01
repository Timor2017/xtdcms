<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormListItems extends Model {
	protected $connection = 'form_definition';
	protected $table = 'form_list_items';
}