<?php
namespace App\Middlewares;

class AuthenticateMiddleware {
	public  static function authHeader($request, $response, $next) {
		global $container;
		if ($container['auth.manager']->isValidRequest()) {
			$response = $next($request, $response);
		} else {
			$msg = new \App\Models\ResponseData(false, array('code'=>'403.1', 'message'=>'Forbidden access the page')); // with unauthorized header
			$response->withStatus(403)
								->withHeader('Content-type', 'text/html')
								->write(json_encode($msg));
		}
		return $response;
	}

	public static function authUser($request, $response, $next) {
		global $container;
		if ($container['auth.manager']->isAuthenticatedUser()) {
			$response = $next($request, $response);
		} else {
			$msg = new \App\Models\ResponseData(false, array('code'=>'403.2', 'message'=>'Forbidden access the page')); // with unauthorized user
			$response->withStatus(403)
								->withHeader('Content-type', 'text/html')
								->write(json_encode($msg));
		}
		return $response;
	}

	public static function checkUserRight($request, $response, $next) {
		global $container;
		if ($container['auth.manager']->isAuthenticatedUser()) {
			$response = $next($request, $response);
		} else {
			$msg = new \App\Models\ResponseData(false, array('code'=>'403.3', 'message'=>'Forbidden access the page')); // with unauthorized access right
			$response->withStatus(403)
								->withHeader('Content-type', 'text/html')
								->write(json_encode($msg));
		}
		return $response;
	}

}