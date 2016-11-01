<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormDataValues extends Model {
	protected $connection = 'datapool';
	protected $table = 'form_data_values';
}