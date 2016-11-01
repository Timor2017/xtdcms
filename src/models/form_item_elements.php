<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormItemElements extends Model {
	protected $connection = 'form_definition';
	protected $table = 'form_item_elements';
}