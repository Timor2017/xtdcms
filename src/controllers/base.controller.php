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
		$this->container->response->withJson($result);
	}

}
