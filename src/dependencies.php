<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// Register Twig View helper
$container['view'] = function ($c) {
	$settings = $c->get('settings')['renderer'];
    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => $settings['cache_path'],
		'auto_reload' => true
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

// database
$container['db'] = function ($c) {
	$settings = $c->get('settings')['db'];
	//$db = new \Slim\PDO\Database($settings['connectionString'], $settings['username'], $settings['password']);
	
	$capsule = new \Illuminate\Database\Capsule\Manager;
	if (is_array($settings['database'])) {
		$config = $settings;
		foreach ($settings['database'] as $name => $dbinfo) {
			$config['database'] = $dbinfo['dbname'];
			$config['username'] = $dbinfo['username'];
			$config['password'] = $dbinfo['password'];

			$capsule->addConnection($config, $name);
		}
	} else {
		$capsule->addConnection($container['settings']['db']);
	}
	$capsule->setAsGlobal();
	$capsule->setEventDispatcher(new Illuminate\Events\Dispatcher(new Illuminate\Container\Container));
	$capsule->bootEloquent();
	
	return $capsule;
};

//initialize the database
$container->db;