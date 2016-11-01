<?php

class AuthUser {
	public function __invoke($request, $response, $next) {
		if ($this->isAuthenticatedUser()) {
			$response = $next($request, $response);
		} else {
			$response->withStatus(403)
								->withHeader('Content-type', 'text/html')
								->write('Forbidden access the page');
		}
			return $response;
	}
	
	protected function isAuthenticatedUser() {
		if ($this->isValidRequest()) {
			$token = isset($headers['X-XTD-AUTH-HEADER']) ? $headers['X-XTD-AUTH-HEADER'] : '';
			
			$model = \App\Models\Members::where('token','=', $this->token)->get();
			if ($model->count() == 1) {
				$username = $model[0]->username;
				
				$token = md5(session_id() . $username . time() . $_SERVER['REMOTE_ADDR'] . $this->appID . $this->secret . $this->version);
				if ($token == $this->token) {
					return true;
				}
			}
		}
		
		return false;
	}
}