<?php

/**
 * Development configuration
 * 
 * @author Oguzhan Uysal <development.php@oguzhanuysal.eu>
 * @version 1.0.0
 */
return new \Phalcon\Config(array(
	'database' => array(
		'adapter'  => 'Mysql',
		'host'     => '10.1.3.1',
		'username' => 'development_user',
		'password' => 'development_password',
		'name'     => 'development_database',
	),
));