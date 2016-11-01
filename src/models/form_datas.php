<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormDatas extends Model {
	protected $connection = 'datapool';
	protected $table = 'form_datas';
}