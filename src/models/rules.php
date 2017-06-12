<?php
namespace App\Models;

class Rules extends BaseModel {
	protected $connection = 'process_definition';
	protected $table = 'rules';

	protected $available_properties = ['max_record_count'];
	
	public function triggers()
	{
		return $this->hasMany('App\Models\RuleTriggers', 'rule_id', 'id')->where('status', STATUS_ACTIVE);
	}	
	
	public function results()
	{
		return $this->hasMany('App\Models\RuleResults', 'rule_id', 'id')->where('status', STATUS_ACTIVE);
	}	
	
}