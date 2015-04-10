<?php

/**
 * Application configuration
 *
 * @author Oguzhan Uysal <development.php@oguzhanuysal.eu>
 * @version 1.0.1
 * 
 * @since 1.0.1 database configuration has been moved to environment file to differentiate Production, Staging and Development databases
 */
return new \Phalcon\Config(array(
	'application' => array(
		'controllersDir' => __DIR__ . '/../../app/controllers/',
		'modelsDir'      => __DIR__ . '/../../app/models/',
		'viewsDir'       => __DIR__ . '/../../app/views/',
		'pluginsDir'     => __DIR__ . '/../../app/plugins/',
		'libraryDir'     => __DIR__ . '/../../app/library/',
		'baseUri'        => "http" . (($_SERVER['SERVER_PORT']==443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] .'/',
                'domain'        => 'link',
	),
	'models' => array(
		'metadata' => array(
			'adapter' => 'Memory'
		)
	)
));