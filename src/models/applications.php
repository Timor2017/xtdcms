<?php
namespace App\Models;

class Applications extends BaseModel {
  protected $connection = 'core';
  protected $table = 'applications';
  
  	
	public function secrets() {
		return $this->hasMany('App\Models\ApplicationSecrets', 'application_id', 'id')->where('status', STATUS_ACTIVE);
	}

}