<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
            'cache_path' => __DIR__ . '/../caches/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        // Database settings
        //'db' => [
		//	//'connectionString' => 'mysql:host=misqld01;dbname=fdb;port=3307;charset=utf8',
		//	//'username' => 'dbadmin',
		//	//'password' => 'Abc123',
		//	'connectionString' => 'mysql:host=localhost;dbname=21db;port=3306;charset=utf8',
		//	'username' => 'root',
		//	'password' => '',
        //],
		'db' => [
			'driver' => 'mysql',
			'host' => 'localhost',
			'port' => 3306,
			'database' => [
				'archive' => [
					'dbname' => 'xtduat_archives',
					'username' => 'xtduat',
					'password' => 'xtd_UAT_144000',
				],
				'core' => [
					'dbname' => 'xtduat_core',
					'username' => 'xtduat',
					'password' => 'xtd_UAT_144000',
				],
				'datapool' => [
					'dbname' => 'xtduat_datapool',
					'username' => 'xtduat',
					'password' => 'xtd_UAT_144000',
				],
				'form_definition' => [
					'dbname' => 'xtduat_form_definition',
					'username' => 'xtduat',
					'password' => 'xtd_UAT_144000',
				],
				'membership' => [
					'dbname' => 'xtduat_membership',
					'username' => 'xtduat',
					'password' => 'xtd_UAT_144000',
				],
				'process_definition' => [
					'dbname' => 'xtduat_process_definition',
					'username' => 'xtduat',
					'password' => 'xtd_UAT_144000',
				],
				'report_definition' => [
					'dbname' => 'xtduat_report_definition',
					'username' => 'xtduat',
					'password' => 'xtd_UAT_144000',
				]
			],
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		],
		
		// User settings
		'user' => [
			'id' => null,
			'isLoggedIn' => false,
			'info' => [],
			'groups' => [],
		]
    ],
];
