<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'teaconf',
    'language' => 'zh_cn',
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
        'redis' => array(
            'class' => 'ext.YiiRedis.ARedisConnection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
        ),

        'coreMessages' => array(
            'basePath' => null,
        ),

        'user' => array(
            'class' => 'WebUser',
            'allowAutoLogin' => true,
        ),

        'authManager' => array(
            'class' => 'AuthManager',
        ),

        'urlManager' => array(
			'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(

                /*
                /api/topics
                /api/topic/$id
                /api/topic/$id/posts

                /api/nodes
                /api/node/$id
                /api/node/$id/topics

                /api/user/$id

                /api/notifications
                 */

                // RESTful
                array('api/<controller>/list', 'pattern' => 'api/<controller:(topic|node)>s', 'verb' => 'GET'),
                array('api/<controller>/read', 'pattern' => 'api/<controller:(topic|user)>/<id:\d+>', 'verb' => 'GET'),
                array('api/<controller>/create', 'pattern' => 'api/<controller:\w+>s', 'verb' => 'POST'),
                array('api/<controller>/update', 'pattern' => 'api/<controller:\w+>/<id:\d+>', 'verb' => 'PUT'),
                array('api/<controller>/delete', 'pattern' => 'api/<controller:\w+>/<id:\d+>', 'verb' => 'DELETE'),

                // site services
                array('api/site/login', 'pattern' => 'api/login', 'verb' => 'POST'),
                array('api/site/authenticate', 'pattern' => 'api/authenticate', 'verb' => 'GET'),
                array('api/site/logout', 'pattern' => 'api/logout', 'verb' => 'DELETE'),
                array('api/site/register', 'pattern' => 'api/register', 'verb' => 'POST'),
                array('api/site/reserveRestPassword', 'pattern' => 'api/resetPassword', 'verb' => 'POST'),
                array('api/site/resetPassword', 'pattern' => 'api/resetPassword', 'verb' => 'PUT'),

                // user services
                array('api/user/changePassword', 'pattern' => 'api/user/changePassword', 'verb' => 'PUT'),
                array('api/user/updateAvatar', 'pattern' => 'api/user/updateAvatar', 'verb' => 'POST'),
                array('api/user/<action>', 'pattern' => 'api/user/<id:\d+>/<action:\w+>', 'verb' => 'GET'),

                // topic services
                array('api/topic/watch', 'pattern' => 'api/topic/watch/<id:\d+>', 'verb' => 'POST'),
                array('api/topic/unwatch', 'pattern' => 'api/topic/watch/<id:\d+>', 'verb' => 'DELETE'),
                array('api/post/list', 'pattern' => 'api/topic/<topic_id:\d+>/(posts)', 'verb' => 'GET'),

                // notification services
                array('api/notification/read', 'pattern' => 'api/notification/read/<id:\d+>', 'verb' => 'POST'),

                '<action:(?!api).*>' => 'site/index',
                //'<controller:\w+>/<id:\d+>'=>'<controller>/view',
                //'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                //'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
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
        ),

        'mailer' => array(
            'class' => 'ext.mailer.SmtpMailer',
            'server' => 'smtp.163.com',
            'port' => '25',
            'username' => '601200376@163.com',
            'password' => 'qw8120043',
            'timeout' => 10,
        ),
    ),
    
    'params' => array(
        'time' => array(
            'format' => 'ago',
        ),
        'user' => array(
            'defaultAvatar' => '/public/avatar/default.png',
        ),
        'adminEmail' => 'webmaster@example.com'
    )
);
