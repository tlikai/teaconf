<?php

defined('ROOT_PATH') || define('ROOT_PATH', __DIR__);
defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') || define('YII_TRACE_LEVEL', 3);

require_once ROOT_PATH . '/../../yii/framework/yii.php';
Yii::createWebApplication(require_once ROOT_PATH . '/protected/config/main.php')->run();
