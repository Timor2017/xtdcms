<?php
namespace App\Controllers;

class FormController extends BaseController {
	public function __invoke() {
	}

	public function definition()  {
		$this->app->get('/{id}', 'App\Controllers\FormController:loadForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('[/]', 'App\Controllers\FormController:createForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
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
				$result[] = array('properties'=>$properties, 'validations'=>$validations);
			}
		}
		return $result;
	}
	
	private function generateValidations($data) {
		$result = [];
		if (isset($data->properties)) {
			foreach ($data->properties as $property) {
				if ($property->group != 'validation') {
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
				if ($property->group == 'validation') {
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
		echo 'a';
		//print_r($request);
		exit;
	}
	
	public function submitForm($request, $response, $args) {
	}

}
