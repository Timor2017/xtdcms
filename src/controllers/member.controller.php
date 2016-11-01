<?php
namespace App\Controllers;

class MemberController extends BaseController {
	public function __invoke() {
	}

	public function me()  {
		$this->app->get('/login', 'App\Controllers\MemberController:login');
		$this->app->get('/logout', 'App\Controllers\MemberController:logout')->add($this->container['auth.user']);
		$this->app->get('/getLoginStatus', 'App\Controllers\MemberController:logout')->add($this->container['auth.user']);
		$this->app->get('/profile', 'App\Controllers\MemberController:logout')->add($this->container['auth.user']);
		$this->app->post('/profile', 'App\Controllers\MemberController:logout')->add($this->container['auth.user']);

	}

	public function user()  {
		$this->app->get('/login', 'App\Controllers\MemberController:login');
		$this->app->get('/logout', 'App\Controllers\MemberController:logout')->add($this->container['auth.user']);
	}

	public function login($request, $response, $args)  {
		$username = 'admin';
		$token_key = session_id() . $username . time() . $_SERVER['REMOTE_ADDR'] . $this->appID . $this->secret . $this->version;
		$token = md5($token_key);
		
		$this->toJSON($token);
	}
}
