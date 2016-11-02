<?php
namespace App\Controllers;

class ApiController extends BaseController {
	protected $appID;
	protected $secret;
    protected $version;
    protected $token;

	public function __invoke() {
		$this->app->group('/me', '\App\Controllers\MemberController:me');
		$this->app->group('/user', '\App\Controllers\MemberController:user');
		$this->app->group('/group', '\App\Controllers\MemberController:group');
	}

	public function login($request, $response, $args)  {
		
		
	}

}
