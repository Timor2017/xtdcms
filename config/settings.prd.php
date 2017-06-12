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
					'dbname' => 'xtd_archives',
					'username' => 'xtd_dba',
					'password' => 'Xc4INrD1vIiRVk9F',
				],
				'core' => [
					'dbname' => 'xtd_core',
					'username' => 'xtd_dba',
					'password' => 'Xc4INrD1vIiRVk9F',
				],
				'datapool' => [
					'dbname' => 'xtd_datapool',
					'username' => 'xtd_dba',
					'password' => 'Xc4INrD1vIiRVk9F',
				],
				'form_definition' => [
					'dbname' => 'xtd_form_definition',
					'username' => 'xtd_dba',
					'password' => 'Xc4INrD1vIiRVk9F',
				],
				'membership' => [
					'dbname' => 'xtd_membership',
					'username' => 'xtd_dba',
					'password' => 'Xc4INrD1vIiRVk9F',
				],
				'process_definition' => [
					'dbname' => 'xtd_process_definition',
					'username' => 'xtd_dba',
					'password' => 'Xc4INrD1vIiRVk9F',
				],
				'report_definition' => [
					'dbname' => 'xtd_report_definition',
					'username' => 'xtd_dba',
					'password' => 'Xc4INrD1vIiRVk9F',
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
