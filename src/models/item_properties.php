<?php
namespace App\Models;

class ItemProperties extends BaseModel {
	protected $connection = 'form_definition';
	protected $table = 'item_properties';
	
	public function target()
    {
        return $this->morphTo();
    }
	
	public function properties()
	{
		return $this->morphMany('\App\Models\ItemProperties', 'target')->where('status',STATUS_ACTIVE);
	}	
	
	public function all_properties()
	{
		return $this->morphMany('\App\Models\ItemProperties', 'target');
	}	
	
}		