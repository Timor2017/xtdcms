<?php
namespace App\Models;

class RuleLogics extends BaseModel {
	protected $connection = 'process_definition';
	protected $table = 'rule_logics';

	protected $available_properties = ['max_record_count'];
	
	public function trigger()
	{
		return $this->belongsTo('App\Models\RuleTriggers', 'trigger_id', 'id')->where('rule_triggers.status', STATUS_ACTIVE);
	}	
	
}