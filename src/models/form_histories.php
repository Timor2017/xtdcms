<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormHistories extends Model {
	protected $connection = 'archive';
	protected $table = 'form_histories';
}