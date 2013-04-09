<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo Yii::app()->name; ?></title>
        <link href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/assets/scripts/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/assets/styles/main.css" rel="stylesheet" media="screen">
    </head>
    <body>
        <!-- header { -->
        <div id="header">
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="brand" href="#">TeaConf</a>
                        <ul class="nav pull-right">
                            <li><a href="#" class="name">likai</a></li>
                            <li><a href="#">提醒</a></li>
                            <li><a href="#">设置</a></li>
                            <!--<li><img src="http://placekitten.com/40/40" /></li>-->
                            <li><a href="?modal" data-toggle="modal">登录</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- } header -->

        <!-- wrapper { -->
        <div id="wrapper">
            <!-- <div id="loading">Loading</div> -->
            <div class="container" id="container"></div>
        </div>
        <!-- } wrapper -->

        <div id="footer">
            <div class="container">
                <div class="links pull-left">
                    <a href="#">关于</a>
                    <a href="#">合作</a>
                    <a href="#">反馈</a>
                    <a href="#">源码</a>
                </div>
                <div class="pull-right">
                    <a href="#">TEACONF.COM</a> <?php echo Yii::powered(); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var URL_ROOT = '/';
            var BASE_URL = '<?php echo Yii::app()->request->getBaseUrl(true); ?>';
            var API_URL = BASE_URL + '/api';
        </script>
        <script data-main="<?php echo Yii::app()->request->getBaseUrl(true); ?>/assets/scripts/main" src="<?php echo Yii::app()->request->getBaseUrl(true); ?>/assets/scripts/libs/requirejs/require.js"></script>
    </body>
</html>
