<?php
use yii\helpers\Html;
use app\assets\GlobalConstants;
use app\assets\GlobalFunctions;
use yii\web\View;
/* @var $this \yii\web\View */
/* @var $content string */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= Html::encode($this->title) ?> - Northern Interactive Media</title>
    <link rel="icon" href="<?=Yii::getAlias('@web')?>/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?=Yii::getAlias('@web')?>/favicon.png" type="image/x-icon"/>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="<?=Yii::getAlias('@web')?>/lib/mCustomScrollbar/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/css/style.css">
    <script src="<?=Yii::getAlias('@web')?>/js/jquery.js" type="text/javascript"></script>
    <script src="<?=Yii::getAlias('@web')?>/js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?=Yii::getAlias('@web')?>/lib/mCustomScrollbar/jquery.mCustomScrollbar.js"></script>
    <?php if (!Yii::$app->user->isGuest) { ?>
        <script src="<?=Yii::getAlias('@web')?>/js/socket.io-1.4.5.js"></script>
        <script src="<?=Yii::getAlias('@web')?>/js/back.js" type="text/javascript"></script>
    <?php }else{?>
        <script src="<?=Yii::getAlias('@web')?>/js/front.js" type="text/javascript"></script>
    <?php }?>    
    <?php if (!Yii::$app->user->isGuest) { ?>
        <?php if (Yii::$app->user->can(GlobalConstants::SUPERADMIN_PERMISSIONS)){?>
            <script src='<?=Yii::getAlias('@web')?>/js/superadmin.js'></script>
        <?php } else if (Yii::$app->user->can(GlobalConstants::ADMIN_PERMISSIONS)){?>
            <script src='<?=Yii::getAlias('@web')?>/js/admin.js'></script>
        <?php } else if (Yii::$app->user->can(GlobalConstants::CLIENT_PERMISSIONS)){?>
            <script src='<?=Yii::getAlias('@web')?>/js/client.js'></script>
        <?php }?>
    <?php }?>
</head>
<?= $content ?>
</html>