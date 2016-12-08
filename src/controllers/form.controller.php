<?php
namespace App\Controllers;

class FormController extends BaseController {
	public function __invoke() {
	}

	public function definition()  {
		$this->app->get('[/[{id}]]', 'App\Controllers\FormController:loadForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('[/]', 'App\Controllers\FormController:createForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->put('/{id}', 'App\Controllers\FormController:updateForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->delete('/{id}', 'App\Controllers\FormController:deleteForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	
	public function data()  {
		$this->app->post('/{id}', 'App\Controllers\FormController:submitForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->put('/{id}[/{data_id}]', 'App\Controllers\FormController:submitForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		
	}
	public function deleteForm($request, $response, $args)  {
		$id = $args['id'];
		
		if (!empty($id)) {
			$form = \App\Models\Forms::find($id);
			if (!empty($form)) {
				$form->status=STATUS_DELETED;
				$form->save();
				//同时也删除和form相关联的
				
					
				$formItems = \App\Models\FormItems::where('form_id','=',$form->id)->get();
				if ($formItems->count()>=1){
					foreach ($formItems as $formItem) {
						$formItem->status=STATUS_DELETED;
						$formItem->save();
					}
				}
				
				$formListItems = \App\Models\FormListItems::where('form_id','=',$form->id)->get();
				if ($formListItems->count()>=1){
					foreach ($formListItems as $formListItem) {
						$formListItem->status=STATUS_DELETED;
						$formListItem->save();
					}
				}
				
				$formPermissions = \App\Models\FormPermissions::where('form_id','=',$form->id)->get();
				if ($formPermissions->count()>=1){
					foreach ($formPermissions as $formPermission) {
						$formPermission->status=STATUS_DELETED;
						$formPermission->save();
					}
				}
					
				return $this->toJSON(true);
			} else {
				return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
			}
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}
	public function loadForm($request, $response, $args)  {
		$parsedBody = $request->getParsedBody();
		$id = (isset($args['id'])) ? $args['id'] : '';
		if (!empty($id)) {
			$form = \App\Models\Forms::find($args['id']);
			$result = null;
			if (!empty($form)) {
				$result['id'] = $form->id;

				$result['items'] = $this->generateItems($form);
				$result['properties'] = $this->generateProperties($form);
				$result['validations'] = $this->generateValidations($form);
			}
		} else {
			$form = new \App\Models\Forms();
				$result['id'] = '';
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
		
		$form = new \App\Models\Forms();
		$form->version = 1;
		$form->name = 				$this->retrieveValue($parsedBody['properties']['common']['display']['value'], '');
		$form->description = 	$this->retrieveValue($parsedBody['properties']['common']['description']['value'], '');
		$form->is_featured = 	$this->retrieveValue($parsedBody['properties']['common']['is_featured']['value'], '0');
		$form->save();
		
		$this->extractProperties($form, $parsedBody);
		foreach ($parsedBody['items'] as $sequence => $item) {
			$new_properties = [];
			$form_item = new \App\Models\FormItems();
			$form_item->form_id = $form->id;
			$form_item->status = STATUS_ACTIVE;
			$form_item->display = 									$this->retrieveValue($item['properties']['common']['display']['value'], '');
			$form_item->description = 							$this->retrieveValue($item['properties']['common']['description']['value'], '');
			$form_item->type = 										$this->retrieveValue($item['type'], '');
			$form_item->value_type = 							$this->retrieveValue($item['value_type'] , '');
			$form_item->value_score = 						$this->retrieveValue($item['properties']['common']['value_score']['value'] , '0');
			$form_item->is_searchable = 						$this->retrieveValue($item['properties']['common']['is_searchable']['value'] , '1');
			$form_item->is_show_in_list =					$this->retrieveValue($item['properties']['common']['is_show_in_list']['value'] , '1');
			$form_item->is_show_in_mobile_list =	$this->retrieveValue($item['properties']['common']['is_show_in_mobile_list']['value'] , '1');
			$form_item->sort_sequence =					$this->retrieveValue($item['properties']['common']['sort_sequence']['value'] , '');
			$form_item->sequence =								$sequence;
			$form_item->save();
			
			$this->extractProperties($form_item, $item);
		}
		$args['id'] = $form->id;

		return  $this->loadForm($request, $response, $args);
	}
	
	public function updateForm($request, $response, $args) {
		$id = $args['id'];
		
		if (!empty($id)) {
			$parsedBody = $request->getParsedBody();
			
			$form = \App\Models\Forms::find($id);
			$form->version++;
			$form->name = $this->retrieveValue($parsedBody['properties']['common']['display']['value'] , '');
			$form->description = $this->retrieveValue($parsedBody['properties']['common']['description']['value'] , '');
			$form->is_featured = $this->retrieveValue($parsedBody['properties']['common']['is_featured']['value'] , '0');
			$form->save();
			
			$this->extractProperties($form, $parsedBody);
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
				
				$form_item->type =										$this->retrieveValue($item['type'] , '');
				$form_item->value_type =							$this->retrieveValue($item['value_type'] , '');
				$form_item->display =									$this->retrieveValue($item['properties']['common']['display']['value'] , '');
				$form_item->description =							$this->retrieveValue($item['properties']['common']['description']['value'] , '');
				$form_item->value_score =							$this->retrieveValue($item['properties']['common']['value_score']['value'] , '0');
				$form_item->is_searchable =						$this->retrieveValue($item['properties']['common']['is_searchable']['value'] , '1');
				$form_item->is_show_in_list =					$this->retrieveValue($item['properties']['common']['is_show_in_list']['value'] , '1');
				$form_item->is_show_in_mobile_list =	$this->retrieveValue($item['properties']['common']['is_show_in_mobile_list']['value'] , '1');
				$form_item->sort_sequence =  					$this->retrieveValue($item['properties']['common']['sort_sequence']['value'] , '');
				$form_item->sequence =								$sequence;
				$form_item->save();
				
				$this->extractProperties($form_item, $item);
			}

			return  $this->loadForm($request, $response, $args);
		} 
		return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
	}
	
	private function extractProperties($item, $properties) {
		foreach ($item->properties as $property) {
			if (!isset($properties['properties'][$property->group][$property->name])) {
				$property->status = STATUS_DELETED;
			} else {
				$property->value = $properties['properties'][$property->group][$property->name]['value'];
				$property->type = $properties['properties'][$property->group][$property->name]['type'];
				$property->status = STATUS_ACTIVE;
				$property->save();
				unset($properties['properties'][$property->group][$property->name]);
			}
		}
		$new_properties = [];
		foreach ($properties['properties'] as $group_name => $group) {
			if (is_array($group)) {
				foreach ($group as $name => $prop) {
					$property = new \App\Models\ItemProperties();
					//$property->form_id = $form_id;
					$property->name = $name;
					$property->group = $group_name;
					$property->value = $prop['value'];
					$property->type = $prop['type'];
					$property->status = STATUS_ACTIVE;
					
					$new_properties[] = $property;
				}
			}
		}
		if (isset($properties['validations'])) {
			foreach ($properties['validations'] as $validation_sequence => $validation) {
				$property = $item->properties()->where(array('sequence' => $validation_sequence, 'group' => 'validations'))->first();
				if (empty($property)) {
					$property = new \App\Models\ItemProperties();
				}
				//$property->form_id = $form_id;
				$property->name = '';
				$property->group = 'validations';
				$property->rule = $validation['rule'];
				$property->value = $validation['message'];
				$property->type = $validation['type'];
				$property->sequence = $validation_sequence;
				$property->status = STATUS_ACTIVE;
				
				$new_properties[] = $property;
			}
		}
		$item->properties()->saveMany($new_properties);
	}
	
	public function submitForm($request, $response, $args) {
		$id = $args['id'];
		$data_id = $args['data_id'];
		
		if (!empty($id)) {
			$form = \App\Models\Forms::find($id);
			if (!empty($form)) {
				if (empty($data_id)) {
					if (!has_form_permission($form->id, PERMISSION_CREATE)){
						return $this->toJSON(false, ERR_NO_PERMISSION, ERR_NO_PERMISSION);;
					}
				} else {
					if (!has_form_permission($form->id, PERMISSION_UPDATE)){
						return $this->toJSON(false, ERR_NO_PERMISSION, ERR_NO_PERMISSION);;
					}
				}
				$parsedBody = $request->getParsedBody();
				
				$is_valid = true;
				foreach ($form->items as $item) {
					if (!isset($parsedBody[$item->id])) {
						$isvalid = false;
						break;
					}
				}
				if ($is_valid) {
					$form_data = null;
					if (empty($data_id)) {
						$form_data = new \App\Models\FormDatas();
						$form_data->form_id = $id;
						$form_data->version = 1;
						$form_data->status = STATUS_ACTIVE;
						$form_data->save();
					} else {
						$form_data = \App\Models\FormDatas::find($data_id);
						$form_data->version++;
						$form_data->status = STATUS_ACTIVE;
						$form_data->save();
					}
					if ($form_data != null) {
						$values = [];
						//print_r($parsedBody);
						foreach ($form->items as $item) {
							$value = new \App\Models\FormDataValues();
							$value->form_id = $id;
							$value->form_item_id = $item->id;
							$value->item_version = $form->version;
							$value->data_version = $form_data->version;
							switch ($item->value_type) {
								case 'number':
									$value->number_value = $parsedBody[$item->id];
									break;
								case 'file':
								case 'image':
									$value->file_value = $parsedBody[$item->id];
									break;
								default:
								//echo $parsedBody[$item->id];
									$value->text_value = $parsedBody[$item->id];
									break;
							}
							$value->status = STATUS_ACTIVE;
							$values[] = $value;
						}
						$form_data->values()->saveMany($values);
					}
				}
				return $this->toJSON(true);;
			}
		}
		return $this->toJSON(false, ERR_INVALID_FORM_ID, ERR_INVALID_FORM_ID);;

	}

}
