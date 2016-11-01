<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormItemHistories extends Model {
	protected $connection = 'archive';
	protected $table = 'form_item_histories';
}