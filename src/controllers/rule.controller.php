<?php
namespace App\Controllers;

class RuleController extends BaseController {
	public function __invoke() {
	}

	public function definition()  {
		$this->app->put('/form/{id}[/]', 'App\Controllers\RuleController:updateForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}

	public function loadForm($request, $response, $args)  {
		$parsedBody = $request->getParsedBody();
		$id = (isset($args['id'])) ? $args['id'] : '';
		if (!empty($id)) {
			$form = \App\Models\Forms::find($args['id']);
			$result = null;
			if (!empty($form)) {
				$result['id'] = $form->id;

				$result['processes'] = $this->generateProcesses($form);
			}
		} else {
			$form = new \App\Models\Forms();
				$result['id'] = '';
		}
		
		if (!empty($result)) {
			return $this->toJSON($result);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}
	
	private function generateProcesses($data) {
		$result = [];
		$rules = \App\Models\RuleTriggers::where('trigger_type','=', get_class($data))->where('trigger_id','=',$data->id)->where('handler','=','client')->get();
		$loaded_rule = [];
		$rule = [];
		foreach ($rules as $base_rule) {
			if (in_array($base_rule->rule->id, $loaded_rule)) {
				continue;
			}
			foreach ($base_rule->rule->triggers as $trigger) {
				$rule['triggers'][$trigger->id] = array('source'=>$trigger->trigger_id, 'event'=>$trigger->event, 'depends'=>$trigger->dependency_id);
				foreach ($trigger->logics as $logic) {
					$rule['triggers'][$trigger->id]['logics'][] = array('type'=>$logic->logic_type, 'id'=>$logic->logic_id, 'source'=>$logic->source, 'gate'=>$logic->gate, 'value'=>$logic->value);
				}
			}
			foreach ($base_rule->rule->results as $rresult) {
				$rule['results'][$rresult->id] = array('type'=>$rresult->target_type, 'target'=>$rresult->target_id, 'handler'=>$rresult->handler, 'parameters'=>$rresult->parameters);
			}
			$loaded_rule[] = $base_rule->rule->id;
			//$result[$property->group][$property->name] = array('group'=>$property->group, 'name'=>$property->name,'type'=>$property->type,'value'=>$value);
			$result[] = $rule;
		}
		return $result;
	}

	public function updateForm($request, $response, $args) {
		$id = (isset($args['id'])) ? $args['id'] : '';
		
		if (!empty($id)) {
			$parsedBody = $request->getParsedBody();
			$form_item = new \App\Models\FormItems();
			
			foreach ($parsedBody as $rule_id => $rule) {
				$rule_obj = null;
				if ($rule_id < 0) {
					$rule_obj = new \App\Models\Rules();
				} else {
					$rule_obj = \App\Models\Rules::find($rule_id);
				}
				$rule_obj->form_id = $id;
				$rule_obj->status = STATUS_ACTIVE;
				$rule_obj->save();
				
				foreach ($rule['triggers'] as $trigger_id => $trigger) {
					print_r($trigger);
					$trigger_obj = null;
					if ($trigger_id < 0) {
						$trigger_obj = new \App\Models\RuleTriggers();
					} else {
						$trigger_obj = \App\Models\RuleTriggers::find($trigger_id);
					}
					$trigger_obj->rule_id = $rule_obj->id;
					$trigger_obj->trigger_type =  get_class($form_item);
					$trigger_obj->trigger_id = $trigger['source'];
					$trigger_obj->dependency_id = $trigger['depends'];
					$trigger_obj->handler = 'client';
					$trigger_obj->event = $trigger['event'];
					$trigger_obj->status = STATUS_ACTIVE;
					$trigger_obj->save();
					
					foreach ($trigger['logics'] as $logic_id => $logic) {
						$logic_obj = null;
						if ($logic_id < 0) {
							$logic_obj = new \App\Models\RuleLogics();
						} else {
							$logic_obj = \App\Models\RuleLogics::find($logic_id);
						}
						$logic_obj->trigger_id = $trigger_obj->id;
						$logic_obj->logic_type =  get_class($form_item);
						$logic_obj->logic_id = $logic['id'];
						$logic_obj->source = $logic['source'];
						$logic_obj->gate = $logic['gate'];
						$logic_obj->value = $logic['value'];
						$logic_obj->status = STATUS_ACTIVE;
						$logic_obj->save();
					}
				}
				
				foreach ($rule['results'] as $result_id => $result) {
					$result_obj = null;
					if ($result_id < 0) {
						$result_obj = new \App\Models\RuleResults();
					} else {
						$result_obj = \App\Models\RuleResults::find($result_id);
					}
					$result_obj->rule_id = $rule_obj->id;
					$result_obj->target_type =  get_class($form_item);
					$result_obj->target_id = $result['target'];
					$result_obj->handler = $result['handler'];
					$result_obj->parameters = $result['parameters'];
					$result_obj->status = STATUS_ACTIVE;
					$result_obj->save();
				}
			}
			print_r($parsedBody);
			/*
			$form = \App\Models\Forms::find($id);
			$form->version++;
			$form->name = $this->retrieveArray($parsedBody, 'properties.common.display.value' , '');
			$form->description = $this->retrieveArray($parsedBody, 'properties.common.description.value' , '');
			$form->is_featured = $this->retrieveArray($parsedBody, 'properties.common.is_featured.value' , '0');
			$form->save();
			
			$this->extractProperties($form, $parsedBody);
			foreach ($form->items as $fitem) {
				$found = false;
				foreach ($parsedBody['items'] as $sequence => $item) {
					if ($fitem->id == $item['id']) {
						$found = true;
					}
				}
				if (!$found) {
					$fitem->status = STATUS_DELETED;
					$fitem->save();
				}
			}
			foreach ($parsedBody['items'] as $sequence => $item) {
				$new_properties = [];
				$item_id = $item['id'];
				$form_item = null;
				if (!empty($item_id)) {
					$form_item = \App\Models\FormItems::find($item_id);
				}
				if (empty($form_item)) {
					$form_item = new \App\Models\FormItems();
					$form_item->form_id = $form->id;
					$form_item->status = STATUS_ACTIVE;
				}
				
				$form_item->type =										$this->retrieveArray($item, 'type', '');
				$form_item->value_type =							$this->retrieveArray($item, 'value_type', '');
				$form_item->display =									$this->retrieveArray($item, 'properties.common.display.value', '');
				$form_item->description =							$this->retrieveArray($item, 'properties.common.description.value', '');
				$form_item->value_score =							$this->retrieveArray($item, 'properties.common.value_score.value', '0');
				$form_item->is_searchable =						$this->retrieveArray($item, 'properties.common.is_searchable.value', '1');
				$form_item->is_show_in_list =					$this->retrieveArray($item, 'properties.common.is_show_in_list.value', '1');
				$form_item->is_show_in_mobile_list =		$this->retrieveArray($item, 'properties.common.is_show_in_mobile_list.value', '1');
				$form_item->sort_sequence =  					$this->retrieveArray($item, 'properties.common.sort_sequence.value', null);
				$form_item->sequence =								$sequence;

				$form_item->code			 						= 	'';
				$form_item->value_score 					= 	$form_item->value_score 					? '1' : '0';
				$form_item->is_searchable 					= 	$form_item->is_searchable 					? '1' : '0';
				$form_item->is_show_in_list 				=	$form_item->is_show_in_list 				? '1' : '0';
				$form_item->is_show_in_mobile_list =	$form_item->is_show_in_mobile_list ? '1' : '0';
				$form_item->sort_sequence 				=	empty($form_item->sort_sequence)	? null : $form_item->sort_sequence;

				$form_item->save();
				
				$this->extractProperties($form_item, $item);
			}
				
			if (!empty($parsedBody['alias'])) {
				$alias = \App\Models\FormAliases::where('alias','=',$parsedBody['alias'])->first();
				if (empty($alias)) {
					$alias = new \App\Models\FormAliases();
					$alias->form_id = $form->id;
					$alias->alias = $parsedBody['alias'];
					$alias->status = STATUS_ACTIVE;
					$alias->save();
				}
			}

			return  $this->loadForm($request, $response, $args);
		*/
		} 
		//return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
	}

}
