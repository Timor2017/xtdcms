<?php
namespace App\Models;

class StaticContents extends BaseModel {
	protected $connection = 'core';
	protected $table = 'static_contents';
	
	public function glossaries()
    {
        return $this->morphMany('\App\Models\Glossaries', 'target')->where('status',STATUS_ACTIVE);
    }
}