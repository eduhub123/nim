<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Ads;
use app\models\AdAssignment;

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
                    <a href="/superadmin/adsconfig" title="" class="go-ads-config">Go to ADs Config</a>
                    <ul class="ads-tabs">
                        <?php  
                            $ads_assigns = AdAssignment::findAll(['client_id'=> Yii::$app->user->identity->current_client,'active'=>GlobalConstants::TRUE]);
                            foreach ($ads_assigns as $index => $ads_assign) {
                                if($ads_assign->getAd()->one()->parent_id == ''){
                            ?>
                                <li <?=($index == 0)?'class="active"':''?> data-tab="ad-tab-<?=$index?>"><?=$ads_assign->getAd()->one()->name?></li>
                        <?php }}?>
                    </ul>
                    <?php
                        foreach ($ads_assigns as $index => $ads_assign) {
                            if($ads_assign->getAd()->one()->parent_id == ''){
                    ?>
                        <div class="ads-tab-child ad-tab-<?=$index?> <?=($index != 0)?'hide':''?>">
                            <div class="row">
                                <?php foreach ($ads_assigns as $ads_child) {
                                    if($ads_child->getAd()->one()->parent_id == $ads_assign->getAd()->one()->id){                                                                
                                ?>
                                <div class="col-md-6">
                                    <h3>
                                        <?=$ads_child->getAd()->one()->name?>
                                        <div class="ad-child-checkbox">
                                            <input type="checkbox" id="ad-child-type-<?=$ads_child->id?>" <?=($ads_child->type == GlobalConstants::IMAGE_TYPE)?'':'checked'?>>
                                            <label for="ad-child-type-<?=$ads_child->id?>"></label>
                                        </div>
                                    </h3>
                                    <ul class="form-list">
                                        <li>
                                            <div class="feature-image <?=($ads_child->type == GlobalConstants::IMAGE_TYPE)?'':'hide'?>" data-id="image" data-ad="<?=$ads_child->id?>">
                                                <img src="<?=($ads_child->type == GlobalConstants::IMAGE_TYPE)?$ads_child->file_url:''?>" style="<?=($ads_child->file_url)?'display: block':''?>" alt="" id="banner_image">
                                                <input type="file">
                                            </div>
                                            <div class="feature-image <?=($ads_child->type == GlobalConstants::VIDEO_TYPE)?'':'hide'?>" data-id="video" data-ad="<?=$ads_child->id?>">
                                                <img src="<?=($ads_child->type == GlobalConstants::VIDEO_TYPE)?'http://img.youtube.com/vi/'.$ads_child->file_url.'/0.jpg':''?>" style="<?=($ads_child->file_url)?'display: block':''?>" alt="" id="banner_image">
                                                <input type="text" placeholder="Link video youtube" value="<?=$ads_child->file_url?>">
                                            </div>
                                        </li>
                                        <li>
                                            <input placeholder="Upload Link" class="input-ad-link" data-ad="<?=$ads_child->id?>" value="<?=$ads_child->link?>">
                                        </li>
                                    </ul>
                                </div>
                                <?php }}?>
                            </div>
                        </div>
                    <?php }}?>
                </div>
            </div>
        </div>        
    </div>
    <!-- /CONTENT -->
    <a href="#" class="btn-right-side btn-open-comment" data-text="Comment"><i class="fa fa-comments-o"></i></a>
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
    <div class="comment-box hide">      
        <textarea placeholder="Enter for your suggest"></textarea>
        <button class="btn"><i class="fa fa-send"></i></button>
    </div>
</body>