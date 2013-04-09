<?php
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'teaconf',
    
    'preload' => array(
        'log',
    ),
    
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

        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),

        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=testdrive',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
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
        'adminEmail' => 'webmaster@example.com'
    )
);
