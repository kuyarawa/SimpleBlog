<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Simlpe Blog',
	'defaultController' => 'feed',
	'theme'=>'bootstrap', // requires you to copy the theme under your themes directory
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),
		),

		'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'md5',
 
            # send activation email
            'sendActivationMail' => true,
 
            # allow access for non-activated users
            'loginNotActiv' => false,
 
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,
 
            # automatically login from registration
            'autoLogin' => true,
 
            # registration path
            'registrationUrl' => array('/user/registration'),
 
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
 
            # login form path
            'loginUrl' => array('/user/login'),
 
            # page after login
            'returnUrl' => array('/user/profile'),
 
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
		
	),

	// application components
	'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'class' => 'WebUser',
            'allowAutoLogin'=>true,
            'loginUrl' => array('/user/login'),
        ),
		// uncomment the following to enable URLs in path-format
		'Paypal' => array(
		    'class'=>'application.components.Paypal',
		    'apiUsername' => 'boddicheg-facilitator_api1.gmail.com',
		    'apiPassword' => '1377161881',
		    'apiSignature' => 'Ar7qusazQiJeXTUleir3g.ucm7bmAKPq3KFCUbRGHzZgyATaNk5StAz2',
		    'apiLive' => false,
		 
		    'returnUrl' => 'paypal/confirm/', //regardless of url management component
		    'cancelUrl' => 'paypal/cancel/', //regardless of url management component
		 
		    // Default currency to use, if not set USD is the default
		    'currency' => 'EUR',
		 
		    // Default description to use, defaults to an empty string
		    //'defaultDescription' => '',
		 
		    // Default Quantity to use, defaults to 1
		    //'defaultQuantity' => '1',
		 
		    //The version of the paypal api to use, defaults to '3.0' (review PayPal documentation to include a valid API version)
		    //'version' => '3.0',
		),
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(

			),
		),
		'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
		
		// 'db'=>array(
		// 	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		// ),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=learn_yii',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '1',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'feed/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);