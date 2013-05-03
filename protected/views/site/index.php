<?php /* @var $this Controller */ ?>
<!DOCTYPE HTML>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <title><?php echo Yii::app()->name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- styles -->
        <link href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/assets/styles/bootstrap/css/bootstrap.css" rel="stylesheet">
        <!-- icons -->
        <!--<link rel="shortcut icon" href="assets/ico/favicon.png">-->
    </head>
    <body>
        <header id="topnav">
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="brand" href="?index"><strong>TEA</strong>CONF</a>
                        <div class="nav-collapse collapse">
                            <form class="navbar-search pull-left" action="javascript:;">
                                <input type="text" class="search-query" placeholder="Search">
                            </form>
                            <ul class="nav">
                                <li class="active"><a href="?index">首页</a></li>
                                <li><a href="#">帮助</a></li>
                                <li><a href="#">关于</a></li>
                            </ul>
                            <ul class="nav pull-right">
                                <li><a href="?admin/index">后台</a></li>
                                <li><a href="?login">登录</a></li>
                                <li><a href="?register">注册</a></li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
        </header>

        <div id="wrapper">
            <div id="container" class="container"></div>
        </div>

        <footer>
            <div class="container">
                <div class="container">
                    <div class="pull-right">
                        Powered by <a href="http://www.yiiframework.com/" rel="external">Yii Framework</a>.
                    </div>
                    <div class="links">
                        <a href="#">关于</a>
                        <a href="#">合作</a>
                        <a href="#">反馈</a>
                        <a href="#">源码</a>
                    </div>
                </div>
            </div>
        </footer>

<script type="text/javascript">
var BASE_URL = '<?php echo Yii::app()->request->getBaseUrl(true); ?>';
var API_URL = BASE_URL + '/api';
</script>
        <?php ?>
        <script type="text/javascript" data-main="<?php echo Yii::app()->request->getBaseUrl(true); ?>/assets/scripts/main" src="<?php echo Yii::app()->request->getBaseUrl(true); ?>/assets/scripts/vendors/requirejs/require.js"></script>
    </body>
</html>
