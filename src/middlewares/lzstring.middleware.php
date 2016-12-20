<?php
use LZCompressor\LZString as LZString;
namespace App\Middlewares;

class LZStringMiddleware {
	public  static function decryptString($request, $response, $next) {
		global $container;
		
		$parsedBody = $request->getParsedBody();
		if (isset($parsedBody['o'])) {
			LZString::decompress($parsedBody['o']);
		}
		
		$response = $next($request, $response);

		return $response;
	}

}