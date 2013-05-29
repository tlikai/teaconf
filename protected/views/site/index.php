<?php /* @var $this Controller */ ?>
<?php $baseUrl = Yii::app()->request->getBaseUrl(true); ?>
<!DOCTYPE HTML>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <title><?php echo Yii::app()->name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- styles -->
        <link href="<?php echo $baseUrl; ?>/app/styles/style.css" rel="stylesheet">
        <!-- icons -->
        <!--<link rel="shortcut icon" href="assets/ico/favicon.png">-->
    </head>
    <body>
        <script type="text/javascript">
            var BASE_URL = '<?php echo $baseUrl; ?>';
            var API_URL = BASE_URL + '/api';
        </script>
        <script type="text/javascript" data-main="<?php echo $baseUrl; ?>/app/scripts/scripts/main" src="<?php echo $baseUrl; ?>/app/scripts/scripts/components/requirejs/require.js"></script>
    </body>
</html>
