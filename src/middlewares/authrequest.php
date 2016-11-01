<?php

class AuthRequest {
	public function __invoke($request, $response, $next) {
		if ($this->isValidRequest()) {
			$response = $next($request, $response);
		} else {
			$response->withStatus(403)
								->withHeader('Content-type', 'text/html')
								->write('Forbidden access the page');
		}
			return $response;
	}

	protected function isValidRequest() {
		$headers = getallheaders();
		
		$appID = isset($headers['X-XTD-APP-ID']) ? $headers['X-XTD-APP-ID'] : '';
		$secret = isset($headers['X-XTD-APP-SECRET']) ? $headers['X-XTD-APP-SECRET'] : '';
		$version = isset($headers['X-XTD-APP-VERSION']) ? $headers['X-XTD-APP-VERSION'] : '';
if (__IS_DEBUG){
		$appID = isset($headers['X-XTD-APP-ID']) ? $headers['X-XTD-APP-ID'] : '6d25b55d-987a-41dd-87b3-4db79b81f86c';
		$secret = isset($headers['X-XTD-APP-SECRET']) ? $headers['X-XTD-APP-SECRET'] : '8861b2e14d94';
		$version = isset($headers['X-XTD-APP-VERSION']) ? $headers['X-XTD-APP-VERSION'] : '1.0';
}
		
		$model = \App\Models\ApplicationSecrets::where([
																								['app_id','=', $appID],
																								['secret','=', $secret],
																								['version','=', $version]
																							])->get();
		if ($model->count() > 0){
			return true;
		}
		
		return false;
	}

}