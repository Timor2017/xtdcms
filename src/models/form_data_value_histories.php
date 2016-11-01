<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormDataValueHistories extends Model {
	protected $connection = 'archive';
	protected $table = 'form_data_value_histories';
}