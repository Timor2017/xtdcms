<?php
namespace App\Models;

class Permissions extends BaseModel {
	protected $connection = 'core';
	protected $table = 'permissions';
	
	public function target()
    {
        return $this->morphTo();
    }
}