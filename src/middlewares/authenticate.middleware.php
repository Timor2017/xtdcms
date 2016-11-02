<?php
namespace App\Middlewares;

class AuthenticateMiddleware {
	public  static function authHeader($request, $response, $next) {
		global $container;
		if ($container['auth.manager']->isValidRequest()) {
			$response = $next($request, $response);
		} else {
			$response->withStatus(403)
								->withHeader('Content-type', 'text/html')
								->write('Forbidden access the page');
		}
		return $response;
	}

	public static function authUser($request, $response, $next) {
		global $container;
		if ($container['auth.manager']->isAuthenticatedUser()) {
			$response = $next($request, $response);
		} else {
			$response->withStatus(403)
								->withHeader('Content-type', 'text/html')
								->write('Forbidden access the page');
		}
		return $response;
	}

}