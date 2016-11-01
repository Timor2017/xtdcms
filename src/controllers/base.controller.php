<?php
namespace App\Controllers;

use Exception;

class BaseController {
	protected $container;
	protected $app;
	protected $appID;
	protected $secret;
    protected $version;
    protected $token;
	
	
	//Constructor
   public function __construct(\Slim\Container $c) {
		global $app;
		$this->container = $c;
		$this->app = $app;
	}
	
	public function __invoke() {
		$this->appID = isset($headers['X-XTD-APP-ID']) ? $headers['X-XTD-APP-ID'] : '';
		$this->secret = isset($headers['X-XTD-APP-SECRET']) ? $headers['X-XTD-APP-SECRET'] : '';
		$this->version = isset($headers['X-XTD-APP-VERSION']) ? $headers['X-XTD-APP-VERSION'] : '';
		$this->token = isset($headers['X-XTD-AUTH-HEADER']) ? $headers['X-XTD-AUTH-HEADER'] : '';

		$this->appID = isset($headers['X-XTD-APP-ID']) ? $headers['X-XTD-APP-ID'] : '6d25b55d-987a-41dd-87b3-4db79b81f86c';
		$this->secret = isset($headers['X-XTD-APP-SECRET']) ? $headers['X-XTD-APP-SECRET'] : '8861b2e14d94';
		$this->version = isset($headers['X-XTD-APP-VERSION']) ? $headers['X-XTD-APP-VERSION'] : '1.0';
		$this->token = isset($headers['X-XTD-AUTH-HEADER']) ? $headers['X-XTD-AUTH-HEADER'] : '1.0';

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
