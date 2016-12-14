<?php
namespace App\Controllers;

use Exception;

class BaseController {
	protected $container;
	protected $app;
	
	//Constructor
   public function __construct(\Slim\Container $c) {
		global $app;
		$this->container = $c;
		$this->app = $app;
	}
	
	public function __invoke() {

	}
	
	public function toJSON($data, $code=null, $message=null) {
		if ($code == null && $message == null) {
			$result = new \App\Models\ResponseData($data);
		} else {
			$result = new \App\Models\ResponseData($data, array('code'=>$code, 'message'=>$message));
		}
		$this->container->response = $this->container->response->withJson($result);
	}
	
	public function retrieveArray($array, $key, $defaultValue = '') {
		$keys = explode('.', $key, 2);
		if (count($keys) == 2) {
			if (isset($array[$keys[0]])) {
				return $this->retrieveArray($array[$keys[0]], $keys[1], $defaultValue);
			}
		} else {
			if (isset($array[$key])) {
				return $array[$key];
			}
		}
		return $defaultValue;
	}
	
	public function retrieveValue($value, $defaultValue = '') {
		if (isset($value)) {
			return $value;
		}
		return $defaultValue;
	}

}
