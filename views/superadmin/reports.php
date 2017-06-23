<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;

$this->title = 'Reports';
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-reports.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div id="inner">                
            </div>
        </div>        
    </div>
    <!-- /CONTENT -->
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>    
</body>