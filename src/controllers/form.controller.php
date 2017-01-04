<?php
namespace App\Controllers;

class FormController extends BaseController {
	public function __invoke() {
	}

	public function definition()  {
		$this->app->get('[/[{id}]]', 'App\Controllers\FormController:loadForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('/{folder_id}[/]', 'App\Controllers\FormController:createForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->put('/{id}[/]', 'App\Controllers\FormController:updateForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->delete('/{id}[/]', 'App\Controllers\FormController:deleteForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	
	public function data()  {
		$this->app->post('/import/{id}', 'App\Controllers\FormController:importFormData')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('/{id}', 'App\Controllers\FormController:submitFormData')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->put('/{id}[/{data_id}]', 'App\Controllers\FormController:submitFormData')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('/paging/{id}', 'App\Controllers\FormController:getFormData')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->get('/{id}[/{data_id}]', 'App\Controllers\FormController:getFormData')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->delete('/{id}/{data_id}', 'App\Controllers\FormController:deleteFormData')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	public function deleteForm($request, $response, $args)  {
		$id = $args['id'];
		
		if (!empty($id)) {
			$form = \App\Models\Forms::find($id);
			if (!empty($form)) {
				$form->status=STATUS_DELETED;
				$form->save();
				//同时也删除和form相关联的
				
				foreach ($form->items as $formItem) {
					$formItem->status=STATUS_DELETED;
					$formItem->save();
				}
				
				foreach ($form->permissions as $formPermission) {
					$formPermission->status=STATUS_DELETED;
					$formPermission->save();
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
				$value = $property->value;
				$result[$property->group][$property->name] = array('group'=>$property->group, 'name'=>$property->name,'type'=>$property->type,'value'=>$value);
			}
		}
		return $result;
	}
	
	public function createForm($request, $response, $args) {
		$folder_id = (isset($args['folder_id'])) ? $args['folder_id'] : '';
		$parsedBody = $request->getParsedBody();
		
		if (isset($parsedBody['items'])) {
			$form = new \App\Models\Forms();
			$form->version = 1;
			$form->status = STATUS_ACTIVE;
			$form->folder_id = 		$folder_id;
			$form->name = 				$this->retrieveArray($parsedBody, 'properties.common.display.value', '');
			$form->description = 	$this->retrieveArray($parsedBody, 'properties.common.description.value', '');
			$form->is_featured = 	$this->retrieveArray($parsedBody, 'properties.common.is_featured.value', '0');
			$form->save();
			
			$this->extractProperties($form, $parsedBody);
			foreach ($parsedBody['items'] as $sequence => $item) {
				$new_properties = [];
				$form_item = new \App\Models\FormItems();
				$form_item->form_id = $form->id;
				$form_item->status = STATUS_ACTIVE;
				$form_item->display = 									$this->retrieveArray($item, 'properties.common.display.value', '');
				$form_item->description = 							$this->retrieveArray($item, 'properties.common.description.value', '');
				$form_item->type = 										$this->retrieveArray($item, 'type', '');
				$form_item->value_type = 							$this->retrieveArray($item, 'value_type' , '');
				$form_item->value_score = 							$this->retrieveArray($item, 'properties.common.value_score.value' , '0');
				$form_item->is_searchable = 						$this->retrieveArray($item, 'properties.common.is_searchable.value' , '1');
				$form_item->is_show_in_list =					$this->retrieveArray($item, 'properties.common.is_show_in_list.value' , '1');
				$form_item->is_show_in_mobile_list =		$this->retrieveArray($item, 'properties.common.is_show_in_mobile_list.value' , '1');
				$form_item->sort_sequence =						$this->retrieveArray($item, 'properties.common.sort_sequence.value' , null);
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
			$args['id'] = $form->id;
			return  $this->loadForm($request, $response, $args);
		}
		return  $this->toJSON(false);
	}
	
	public function updateForm($request, $response, $args) {
		$folder_id = (isset($args['folder_id'])) ? $args['folder_id'] : '';
		$id = (isset($args['id'])) ? $args['id'] : '';
		
		if (!empty($id)) {
			$parsedBody = $request->getParsedBody();
			
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
					$property->name = $name;
					$property->group = $group_name;
					$property->rule = '';
					$property->sequence = '0';
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
	
	public function submitFormData($request, $response, $args) {
		$id = (isset($args['id'])) ? $args['id'] : '';
		$data_id = (isset($args['data_id'])) ? $args['data_id'] : '';
		$parsedBody = $request->getParsedBody();
		
		if (!empty($id)) {
			$form = \App\Models\Forms::find($id);
			if (!empty($form)) {
				$is_valid = true;
				foreach ($form->items as $item) {
					if (!isset($parsedBody[$item->id]) && !isset($parsedBody[$item->display])) {
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
						foreach ($form->items as $item) {
							$value = new \App\Models\FormDataValues();
							$value->form_id = $id;
							$value->form_item_id = $item->id;
							$value->item_version = $form->version;
							$value->data_version = $form_data->version;
							
							$data_value = isset($parsedBody[$item->display]) ? $parsedBody[$item->display] : $parsedBody[$item->id];
							($data_value !== null) ? $data_value : '';
							switch ($item->value_type) {
								case 'number':
									$value->number_value = $data_value;
									break;
								case 'file':
								case 'image':
									$value->file_value = $data_value;
									break;
								default:
									$value->text_value = $data_value;
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

	
	public function importFormData($request, $response, $args) {
		$id = (isset($args['id'])) ? $args['id'] : '';
		$data_id = (isset($args['data_id'])) ? $args['data_id'] : '';
		
		$files = $request->getUploadedFiles();
		if (!empty($id)) {
			$form = \App\Models\Forms::find($id);
			if (!empty($form)) {
				$csvfile = $files['csvfile'];
				if ($csvfile->getError() === UPLOAD_ERR_OK) {
					$row = 1;
					if (($handle = fopen($csvfile->file, 'r')) !== FALSE) {
						$columns = [];
						while (($data = fgetcsv($handle)) !== FALSE) {
							$num = count($data);
							if ($row == 1) {
								$columns = $data;
								$is_valid = true;
								foreach ($form->items as $item) {
									if (!isset($parsedBody[$item->id]) && !isset($parsedBody[$item->display])) {
										$isvalid = false;
										break;
									}
								}
								if (!$is_valid) {
									break;
								}
							} else { 
								$rowdata = [];
								for ($c=0; $c < $num; $c++) {
									$rowdata[$columns[$c]] = $data[$c];
								}
								$form_data = new \App\Models\FormDatas();
								$form_data->form_id = $id;
								$form_data->version = 1;
								$form_data->status = STATUS_ACTIVE;
								$form_data->save();
								if ($form_data != null) {
									$values = [];
									foreach ($form->items as $item) {
										$value = new \App\Models\FormDataValues();
										$value->form_id = $id;
										$value->form_item_id = $item->id;
										$value->item_version = $form->version;
										$value->data_version = $form_data->version;
										
										$data_value = $rowdata[$item->display];
										($data_value !== null) ? $data_value : '';
										switch ($item->value_type) {
											case 'number':
												$value->number_value = $data_value;
												break;
											case 'file':
											case 'image':
												$value->file_value = $data_value;
												break;
											default:
												$value->text_value = $data_value;
												break;
										}
										$value->status = STATUS_ACTIVE;
										$values[] = $value;
									}
									$form_data->values()->saveMany($values);
								}
							}
							$row++;
						}
					}
				}
			}
		}
		return $this->toJSON(true);;
		//return $this->toJSON(false, ERR_INVALID_FORM_ID, ERR_INVALID_FORM_ID);;

	}
	
	public function getFormData($request, $response, $args) {
		$id = (isset($args['id'])) ? $args['id'] : '';
		$data_id = (isset($args['data_id'])) ? $args['data_id'] : '';
		$result = [];
		if (!empty($id)) {
			if (!empty($data_id)) {
				$data = \App\Models\FormDatas::find($data_id);
				foreach ($data->values as $value) {
					$result[$value->form_item_id] = $value->text_value;
				}
			} else {
				$parsedBody = $request->getParsedBody();
				$page = isset($parsedBody['page']) ? $parsedBody['page'] : 1;
				$size = isset($parsedBody['size']) ? $parsedBody['size'] : 25;
				if (--$page < 0) $page = 0;
				$offset = $page * $size;
				$search_range = $offset + $size;
				$form = \App\Models\Forms::find($id);
				$display_items = [];
				$result['columns'] = [];
				$result['info'] = $form;
				unset($result['info']->created_by);
				unset($result['info']->created_date);
				unset($result['info']->last_modified_by);
				unset($result['info']->last_modified_date);
				unset($result['info']->concurrent_id);
				foreach ($form->items as $item) {
					if ($item->is_show_in_list > 0) {
						$display_items[$item->id] = $item->display;
						$result['columns'][] = $item->display;
					}
				}
				$count = 0;
				$result['total'] = $form->datas->count();
				$result['page_size'] = $size;
				$result['current_page'] = $page + 1;
				$result['total_page'] = ceil($result['total'] / $result['page_size']);
				foreach ($form->datas as $data) {
					$count++;
					if ($count <= $offset) continue;
					if ($count > $search_range) break;
					$result['data'][$data->id] = [];
					foreach ($data->values as $value) {
						if (isset($display_items[$value->form_item_id])) {
							$result['data'][$data->id][$display_items[$value->form_item_id]] = $value->text_value;
						}
					}
				}
				unset($result['info']->datas);
				unset($result['info']->items);
				unset($result['info']->is_featured);
				
			}
		}
		return $this->toJSON($result);
	}
	
	public function deleteFormData($request, $response, $args) {
		$id = $args['id'];
		$data_id = $args['data_id'];
		if (!empty($id)) {
			$form = \App\Models\Forms::find($id);
			if (!empty($form)) {
				$data = \App\Models\FormDatas::find($data_id);
				if (!empty($data)) {
					$data->status=STATUS_DELETED;
					$data->save();
					if ($data->values->count()>=1){
						foreach ($data->values as $value) {
							$value->status=STATUS_DELETED;
							$value->save();
						}
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
}
