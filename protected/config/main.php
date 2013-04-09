<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'teaconf',
    'timeZone' => 'Asia/Shanghai',
    
    'preload' => array('log'),
    
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    
    'modules' => array(
        'api',
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'teaconf',
            'ipFilters' => array('127.0.0.1', '::1'),
        )
    ),
    
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),

        'urlManager' => array(
			'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(

                // RESTful
                array('api/<controller>/list', 'pattern' => 'api/<controller:\w+>s', 'verb' => 'GET'),
                array('api/<controller>/create', 'pattern' => 'api/<controller:\w+>s', 'verb' => 'POST'),
                array('api/<controller>/read', 'pattern' => 'api/<controller:\w+>/<id:\d+>', 'verb' => 'GET'),
                array('api/<controller>/update', 'pattern' => 'api/<controller:\w+>/<id:\d+>', 'verb' => 'PUT'),
                array('api/<controller>/delete', 'pattern' => 'api/<controller:\w+>/<id:\d+>', 'verb' => 'DELETE'),

                // topic services
                array('topic/watch', 'pattern' => 'api/topic/watch/<id:\d+>', 'verb' => 'POST'),
                array('topic/unwatch', 'pattern' => 'api/topic/watch/<id:\d+>', 'verb' => 'DELETE'),

                '<action:.*>' => 'site/index',
                /*
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                 */
            ),
        ),

        'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=teaconf',
			'emulatePrepare' => true,
            'enableProfiling' => YII_DEBUG,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
            'tablePrefix' => '',
        ),

        'errorHandler' => array(
            'errorAction' => 'site/error'
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning'
                )
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            )
        )
    ),
    
    'params' => array(
        'time' => array(
            'format' => 'ago',
        ),
        'adminEmail' => 'webmaster@example.com'
    )
);
