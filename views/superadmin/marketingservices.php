<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Service;
use app\models\ServiceAssignment;

$this->title = 'Service Management';
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-marketing-service.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <form method="post" id="marketing-services-form" novalidation>            
                <ul class="list-marketing-services admin">
                    <?php 
                        $service_assigns = ServiceAssignment::findAll(['client_id'=> Yii::$app->user->identity->current_client,'active'=>GlobalConstants::TRUE]);
                        print_r($service_assigns);
                        $parents = Service::findAll(['parent_id'=>'', 'active'=>GlobalConstants::TRUE]);
                        foreach ($parents as $index=>$parent) {?>
                            <li>
                                <h3><div class="ui-checkbox"><input type="checkbox" name="service[<?=$index?>]" id="chk-big-<?=$index?>" value="<?=$parent->id?>"><label for="chk-big-<?=$index?>"><?=strtoupper($parent->name)?></label></div></h3>
                                <ul class="hide">
                                    <?php
                                        $childs = Service::findAll(['parent_id'=>$parent->id, 'active'=>GlobalConstants::TRUE]);
                                        foreach ($childs as $index2=>$child){?>
                                            <li><div class="ui-checkbox"><input type="checkbox" name="service[<?=$index?>][<?=$index2?>]" id="chk-<?=$index.$index2?>" value="<?=$child->id?>"><label for="chk-<?=$index.$index2?>"><?=$child->name?></label></div></li>
                                    <?php }?>
                                </ul>
                            </li>
                    <?php }?>
                </ul>
                <button type="submit" class="btn btn-submit">Save</button>                    
            </form>
        </div>
    </div>
    <!-- /CONTENT -->
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>