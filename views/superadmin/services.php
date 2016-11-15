<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Service;

$this->title = 'Service Management';
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-services.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div id="inner">
                <div class="management-box">
                    <div class="title">
                        <h1>Services</h1>
                        <input class="txt-search services" placeholder="Search services ..."/>
                    </div>
                    <ul class="management-header">
                        <li class="col-number">No.</li>
                        <li class="col-name">Service Name</li>
                        <li class="col-parent">Parent</li>
                        <li class="col-other"></li>
                    </ul><!-- /management-header -->
                    <ul class="management-list">
                        <?php 
                            $services = Service::find()->where(['active'=>GlobalConstants::TRUE])->orderBy(['parent_id'=>SORT_ASC])->all();
                            foreach ($services as $index => $service) {?>
                                <li>
                                    <ul>
                                        <li class="col col-number"><?=$index+1?></li>
                                        <li class="col col-name"><?=$service->name?></li>
                                        <li class="col col-parent">
                                            <?php if(!$service->parent_id)
                                                    echo 'N/A';
                                                else
                                                    echo Service::findOne(['id'=>$service->parent_id])->name;
                                            ?>
                                        </li>
                                        <li class="col col-other">
                                            <a href="/superadmin/updateservice/<?=$service->id?>" class="btn-edit">Edit</a>
                                            <a data-id="<?=$service->id?>" class="btn-delete btn-delete-service">Delete</a>
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
    <a href="/superadmin/addservice" class="btn-right-side" data-text="Add New"><span class="fi">+</span></a>
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>