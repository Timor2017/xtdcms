<?php
namespace App\Models;

class FormDatas extends BaseModel {
	protected $connection = 'datapool';
	protected $table = 'form_datas';
	
	public function values()
	{
		return $this->hasMany('App\Models\FormDataValues', 'form_data_id', 'id')->where('status', STATUS_ACTIVE);
	}	
}