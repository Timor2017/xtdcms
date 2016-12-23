<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

//load controllers
require_once __DIR__ . '/controllers/base.controller.php';
foreach (glob(__DIR__ . '/controllers/*.controller.php') as $filename) {
    require_once $filename;
}

//load models
require_once __DIR__ . '/models/base.model.php';
foreach (glob(__DIR__ . '/models/*.php') as $filename) {
    require_once $filename;
}

//load middlewares
foreach (glob(__DIR__ . '/middlewares/*.middleware.php') as $filename) {
    require_once $filename;
}

//load managers
foreach (glob(__DIR__ . '/managers/*.manager.php') as $filename) {
    require_once $filename;
}

$container['auth.manager'] =  function ($c) {
	$middleware = new \App\Managers\AuthenticateManager();
    return $middleware;
};

// user
$container['user'] = function ($c) {
	$user = (object)$c->get('settings')['user'];
	if ($c['auth.manager']->isAuthenticatedUser()) {
		$member = \App\Models\Members::where('token','=',$c['auth.manager']->getToken())->first();
		$groups = \App\Models\GroupMembers::where(['member_id'=>$member->id, 'status'=>STATUS_ACTIVE])->get();
		$user->id = $member->id;
		$user->isLoggedIn = true;
		$user->info = $member;
		$user->groups = $groups;
	}
	return $user;
};
