<?php
namespace App\Models;

class RuleResults extends BaseModel {
	protected $connection = 'process_definition';
	protected $table = 'rule_results';

	protected $available_properties = ['max_record_count'];
	
	public function rule()
	{
		return $this->belongsTo('App\Models\Rules', 'rule_id', 'id')->where('rules.status', STATUS_ACTIVE);
	}	
	
}