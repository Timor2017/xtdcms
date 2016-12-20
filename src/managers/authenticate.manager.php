<?php
namespace App\Managers;

class AuthenticateManager {
	protected $appID = '';
	protected $secret = '';
	protected $version = '';
	protected $token = '';
	protected $headers = [];
	
	public function getAppID() {
		if (empty($this->appID)) {
			$headers = getallheaders();
			$this->appID = isset($headers['X-XTD-APP-ID']) ? $headers['X-XTD-APP-ID'] : '';
if (__IS_DEBUG){
			$this->appID = isset($headers['X-XTD-APP-ID']) ? $headers['X-XTD-APP-ID'] : '6d25b55d-987a-41dd-87b3-4db79b81f86c';
}
		}
		
		return $this->appID;
	}

	public function getSecret() {
		if (empty($this->secret)) {
			$headers = getallheaders();
			$this->secret = isset($headers['X-XTD-APP-SECRET']) ? $headers['X-XTD-APP-SECRET'] : '';
if (__IS_DEBUG){
			$this->secret = isset($headers['X-XTD-APP-SECRET']) ? $headers['X-XTD-APP-SECRET'] : '8861b2e14d94';
}
		}
		
		return $this->secret;
	}
	
	public function getVersion() {
		if (empty($this->version)) {
			$headers = getallheaders();
			$this->version = isset($headers['X-XTD-APP-VERSION']) ? $headers['X-XTD-APP-VERSION'] : '';
if (__IS_DEBUG){
			$this->version = isset($headers['X-XTD-APP-VERSION']) ? $headers['X-XTD-APP-VERSION'] : '1.0';
}
		}
		
		return $this->version;
	}
	
	public function getToken() {
		if (empty($this->token)) {
			$headers = getallheaders();
			$this->token = isset($headers['X-XTD-AUTH-HEADER']) ? $headers['X-XTD-AUTH-HEADER'] : '';
if (__IS_DEBUG){
}
		}
		
		return $this->token;
	}
	
	public function getSessionToken() {
		if (empty($this->token)) {
			//$this->token = $_SESSION['token'];
			$this->token = isset($_COOKIE['appCode']) ? $_COOKIE['appCode'] : '';
		}
		
		return $this->token;
	}


	public function isValidRequest() {
		$model = \App\Models\ApplicationSecrets::where([
																								['app_id','=', $this->getAppID()],
																								['secret','=', $this->getSecret()],
																								['version','=', $this->getVersion()],
																								['status','=',STATUS_ACTIVE]
																							])->get();
		
		if ($model->count() > 0){
			return true;
		}
		
		return false;
	}

	
	public function isAuthenticatedUser() {
		if ($this->isValidRequest()) {
			$session_token = '';
			$token = $this->getToken();
			if (empty($token)) {
				$token = $session_token = $this->getSessionToken();
			}

			$model = \App\Models\Members::where('token','=', $token)->get();
			
			if ($model->count() == 1) {
				$username = $model[0]->username;
				$time = $model[0]->login_time;
				if (!empty($time)){
					$time = strtotime($time);
				}
				
				$check_token = $this->getCurrentToken($username, $time);
				if ($token == $check_token || !empty($session_token)) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	public function getCurrentToken($username, $time = null) {
		if ($time == null) {
			$time = time();
		}
		$token = md5(session_id() . $username . $time . $_SERVER['REMOTE_ADDR'] . $this->getAppID() . $this->getSecret() . $this->getVersion());
		
		return $token;
	}
}