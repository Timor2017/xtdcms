<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

//load controllers
require_once __DIR__ . './controllers/base.controller.php';
foreach (glob(__DIR__ . './controllers/*.controller.php') as $filename) {
    require_once $filename;
}

//load models
foreach (glob(__DIR__ . './models/*.php') as $filename) {
    require_once $filename;
}

//load middleware
foreach (glob(__DIR__ . './middlewares/*.php') as $filename) {
    require_once $filename;
}

$container['auth.request'] =  function ($c) {
	$middleware = new AuthRequest();
    return $middleware;
};

$container['auth.user'] =  function ($c) {
	$middleware = new AuthUser();
    return $middleware;
};
