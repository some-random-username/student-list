<?php
return [
    'routes' => [
        '' => ['controller' => 'students', 'action' => 'index'],
        'add' => ['controller' => 'students', 'action' => 'add'],
        '{controller}/{action}' => [],
        '{controller}/{id:\d+}/{action}' => []
    ],
    'db' => [
        'host'   => '127.0.0.1',
        'name'   => '',
	'user'   => '',
	'pass'   => '',
        'charset' => 'utf8'
    ]
];

