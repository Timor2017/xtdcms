<?php
namespace App\Controllers;

class FormController extends BaseController {
	public function __invoke() {
	}

	public function definition()  {
		$this->app->get('/{id}', 'App\Controllers\FormController:loadForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('[/]', 'App\Controllers\FormController:createForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->put('/{id}', 'App\Controllers\FormController:updateForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	
	public function data()  {
		$this->app->post('/{id}', 'App\Controllers\FormController:submitForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	
	public function loadForm($request, $response, $args)  {
		$parsedBody = $request->getParsedBody();
		
		$form = \App\Models\Forms::find($args['id']);
		//$form->properties;
		$form->items;
		
		$result = null;
		if (!empty($form)) {
			$result['id'] = $form->id;

			$result['items'] = $this->generateItems($form);
			$result['properties'] = $this->generateProperties($form);
			$result['validations'] = $this->generateValidations($form);
		}
		
		if (!empty($result)) {
			return $this->toJSON($result);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}
	
	private function generateItems($data) {
		$result = [];
		if (isset($data->items)) {
			foreach ($data->items as $item) {
				$properties = $this->generateProperties($item);
				$validations = $this->generateValidations($item);
				$result[] = array('properties'=>$properties, 'validations'=>$validations, 'id'=>$item->id, 'name'=>$item->id, 'type'=>$item->type, 'value_type'=>$item->value_type);
			}
		}
		return $result;
	}
	
	private function generateValidations($data) {
		$result = [];
		if (isset($data->properties)) {
			foreach ($data->properties as $property) {
				if ($property->group != 'validations') {
					continue;
				}
				$result[] = array('type'=>$property->type, 'rule'=>$property->rule,'message'=>$property->value,'sequence'=>$property->sequence);
			}
		}
		return $result;
	}
	
	private function generateProperties($data) {
		$result = [];
		if (isset($data->properties)) {
			foreach ($data->properties as $property) {
				if ($property->group == 'validations') {
					continue;
				}
				if ($property->group == 'common' && $property->name == 'name') {
					$result['name'] = $property->value;
				}
				$result[$property->group][$property->name] = array('group'=>$property->group, 'name'=>$property->name,'type'=>$property->type,'value'=>$property->value);
			}
		}
		return $result;
	}
	
	public function createForm($request, $response, $args) {
		$parsedBody = $request->getParsedBody();
		
		print_r($parsedBody);
		exit;
	}
	
	public function updateForm($request, $response, $args) {
		$id = $args['id'];
		
		if (!empty($id)) {
			$parsedBody = $request->getParsedBody();
			
			$form = \App\Models\Forms::find($id);
			$form->version++;
			$form->name = $parsedBody['properties']['common']['display']['value'];
			$form->description = $parsedBody['properties']['common']['description']['value'];
			$form->is_featured = $parsedBody['properties']['common']['is_featured']['value'];
			$form->save();
			
			foreach ($form->properties as $property) {
				if (!isset($parsedBody['properties'][$property->group][$property->name])) {
					$property->status = STATUS_DELETED;
				} else {
					$property->value = $parsedBody['properties'][$property->group][$property->name]['value'];
					$property->type = $parsedBody['properties'][$property->group][$property->name]['type'];
					$property->status = STATUS_ACTIVE;
					$property->save();
					unset($parsedBody['properties'][$property->group][$property->name]);
				}
			}
			$new_properties = [];
			foreach ($parsedBody['properties'] as $group_name => $group) {
				if (is_array($group)) {
					foreach ($group as $name => $prop) {
						$property = new \App\Models\FormProperties();
						$property->name = $name;
						$property->group = $group_name;
						$property->value = $prop['value'];
						$property->type = $prop['type'];
						$property->status = STATUS_ACTIVE;
						
						$new_properties[] = $property;
					}
				}
			}
			$form->properties()->saveMany($new_properties);
			
			//foreach ($form->items as $item) {
			//	if (!isset($parsedBody['items'][$property->group][$property->name])) {
			//		$property->status = STATUS_DELETED;
			//	} else {
			//		$property->value = $parsedBody['properties'][$property->group][$property->name]['value'];
			//		$property->type = $parsedBody['properties'][$property->group][$property->name]['type'];
			//		$property->status = STATUS_ACTIVE;
			//		$property->save();
			//		unset($parsedBody['properties'][$property->group][$property->name]);
			//	}
			//}
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
				
				$form_item->display =  isset($item['properties']['common']['display']['value']) ? $item['properties']['common']['display']['value'] : '';
				$form_item->description =  isset($item['properties']['common']['description']['value']) ? $item['properties']['common']['description']['value'] : '';
				$form_item->type = isset($item['type']) ? $item['type'] : '';
				$form_item->value_type = isset($item['value_type']) ? $item['value_type'] : '';
				$form_item->default_value = isset($item['properties']['common']['default_value']['value']) ? $item['properties']['common']['default_value']['value'] : '';
				$form_item->default_value_formula = isset($item['properties']['common']['default_value_formula']['value']) ? $item['properties']['common']['default_value_formula']['value'] : '';
				$form_item->value_display_format = isset($item['properties']['common']['value_display_format']['value']) ? $item['properties']['common']['value_display_format']['value'] : '';
				$form_item->value_score =  isset($item['properties']['common']['value_score']['value']) ? $item['properties']['common']['value_score']['value'] : '0';
				$form_item->is_required =  isset($item['properties']['common']['is_required']['value']) ? $item['properties']['common']['is_required']['value'] : '0';
				$form_item->is_searchable =  isset($item['properties']['common']['is_searchable']['value']) ? $item['properties']['common']['is_searchable']['value'] : '1';
				$form_item->is_readonly =  isset($item['properties']['common']['is_readonly']['value']) ? $item['properties']['common']['is_readonly']['value'] : '0';
				$form_item->is_private =  isset($item['properties']['common']['is_private']['value']) ? $item['properties']['common']['is_private']['value'] : '0';
				$form_item->is_show_in_list =  isset($item['properties']['common']['is_show_in_list']['value']) ? $item['properties']['common']['is_show_in_list']['value'] : '1';
				$form_item->is_show_in_mobile_list =  isset($item['properties']['common']['is_show_in_mobile_list']['value']) ? $item['properties']['common']['is_show_in_mobile_list']['value'] : '1';
				$form_item->sort_sequence =  isset($item['properties']['common']['sort_sequence']['value']) ? $item['properties']['common']['sort_sequence']['value'] : '';
				$form_item->sequence = $sequence;
				$form_item->save();
				foreach ($item['properties'] as $group_name => $group) {
					if (is_array($group)) {
						foreach ($group as $name => $prop) {
							$property = $form_item->properties()->where(array('name' => $name, 'group' => $group_name))->first();
							if (empty($property)) {
								$property = new \App\Models\FormItemProperties();
							}
							$property->form_id = $form->id;
							$property->name = $name;
							$property->group = $group_name;
							$property->value = $prop['value'];
							$property->type = $prop['type'];
							$property->status = STATUS_ACTIVE;
							
							$new_properties[] = $property;
						}
					}
				}
				foreach ($item['validations'] as $validation_sequence => $validation) {
					$property = $form_item->properties()->where(array('sequence' => $validation_sequence, 'group' => 'validations'))->first();
					if (empty($property)) {
						$property = new \App\Models\FormItemProperties();
					}
					$property->form_id = $form->id;
					$property->name = '';
					$property->group = 'validations';
					$property->rule = $validation['rule'];
					$property->value = $validation['message'];
					$property->type = $validation['type'];
					$property->sequence = $validation_sequence;
					$property->status = STATUS_ACTIVE;
					
					$new_properties[] = $property;
				}
				$form_item->properties()->saveMany($new_properties);
			}
		}
	}
	
	public function submitForm($request, $response, $args) {
	}

}
