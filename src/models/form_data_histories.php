<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormDataHistories extends Model {
	protected $connection = 'archive';
	protected $table = 'form_data_histories';
}