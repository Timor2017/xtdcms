<?php
namespace App\Models;

class Glossaries extends BaseModel {
	protected $connection = 'core';
	protected $table = 'glossaries';
	
	public function target()
    {
        return $this->morphTo();
    }
}