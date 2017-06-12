<?php
namespace App\Models;

class RuleTriggers extends BaseModel {
	protected $connection = 'process_definition';
	protected $table = 'rule_triggers';

	protected $available_properties = ['max_record_count'];
	
	public function logics()
	{
		return $this->hasMany('App\Models\RuleLogics', 'trigger_id', 'id')->where('status', STATUS_ACTIVE);
	}	
	
	public function rule()
	{
		return $this->belongsTo('App\Models\Rules', 'rule_id', 'id')->where('rules.status', STATUS_ACTIVE);
	}	
	
}