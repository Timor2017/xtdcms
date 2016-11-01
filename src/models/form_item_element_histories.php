<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormItemElementHistories extends Model {
	protected $connection = 'archive';
	protected $table = 'form_item_element_histories';
}