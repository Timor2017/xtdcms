<?php
namespace App\Models;

class FormDataValues extends BaseModel {
	protected $connection = 'datapool';
	protected $table = 'form_data_values';
		
	public function form()
	{
		return $this->belongsTo('App\Models\Forms', 'form_id', 'id')->where('forms.status', STATUS_ACTIVE);
	}	

	public function data()
	{
		return $this->belongsTo('App\Models\FormDatas', 'form_data_id', 'id')->where('form_datas.status', STATUS_ACTIVE);
	}	
	
	public function item()
	{
		return $this->belongsTo('App\Models\FormItems', 'form_item_id', 'id')->where('form_items.status', STATUS_ACTIVE);
	}	
}