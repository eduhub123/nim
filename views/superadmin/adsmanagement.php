<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Ads;

$this->title = 'ADs Management';
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-ads.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div id="inner">
                <div class="management-box">
                    <div class="title">
                        <h1>ADs</h1>
                        <input class="txt-search ad" placeholder="Search ads ..."/>
                    </div>
                    <div class="clearfix"></div>
                    <ul class="management-header">
                        <li class="col-number">No.</li>
                        <li class="col-name">AD Name</li>
                        <li class="col-parent">Parent</li>
                        <li class="col-other"></li>
                    </ul><!-- /management-header -->
                    <ul class="management-list">
                        <?php 
                            $ads = Ads::find()->where(['active'=>GlobalConstants::TRUE])->orderBy(['parent_id'=>SORT_ASC])->all();
                            foreach ($ads as $index => $ad) {?>
                                <li>
                                    <ul>
                                        <li class="col col-number"><?=$index+1?></li>
                                        <li class="col col-name"><i class="fa <?=$ad->icon?>" style="color: <?=$ad->color?>"></i> <?=$ad->name?></li>
                                        <li class="col col-parent">
                                            <?php if(!$ad->parent_id)
                                                    echo 'N/A';
                                                else{
                                                    $parent = Ads::findOne(['id'=>$ad->parent_id]);
                                                    echo '<i class="fa '.$parent->icon.'" style="color: '.$parent->color.'"></i> '.$parent->name;
                                                }
                                            ?>
                                        </li>
                                        <li class="col col-other">
                                            <a href="/superadmin/updatead/<?=$ad->id?>" class="btn-edit">Edit</a>
                                            <a data-id="<?=$ad->id?>" class="btn-delete btn-delete-ad">Delete</a>
                                        </li>
                                    </ul>
                                </li>
                        <?php }?>
                    </ul><!-- /management-list -->
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>        
    </div>
    <!-- /CONTENT -->
    <a href="/superadmin/addad" class="btn-right-side" data-text="Add New"><span class="fi">+</span></a>
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>