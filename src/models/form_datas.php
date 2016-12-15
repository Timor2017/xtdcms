<?php
namespace App\Models;

class FormDatas extends BaseModel {
	protected $connection = 'datapool';
	protected $table = 'form_datas';
	
	public function values()
	{
		return $this->hasMany('App\Models\FormDataValues', 'form_data_id', 'id')->where('form_data_values.status', STATUS_ACTIVE);
	}	
	
	public function form()
	{
		return $this->belongsTo('App\Models\Forms', 'form_id', 'id')->where('forms.status', STATUS_ACTIVE);
	}	
}