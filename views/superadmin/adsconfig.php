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
                <form method="post" id="form-ads-config" novalidation>
                    <ul class="list-marketing-services admin">
                        <?php 
                            $ads_assigns = AdAssignment::findAll(['client_id'=> Yii::$app->user->identity->current_client,'active'=>GlobalConstants::TRUE]);                            
                            $parents = Ads::findAll(['parent_id'=>'', 'active'=>GlobalConstants::TRUE]);
                            foreach ($parents as $index=>$parent) {?>
                                <li>
                                    <?php 
                                        $checked = '';
                                        foreach ($ads_assigns as $key => $ads_assign){
                                            if($ads_assign->ad_id == $parent->id)
                                            {
                                                $checked = 'checked';
                                                break;
                                            }
                                        }
                                    ?>
                                    <h3><div class="ui-checkbox"><input type="checkbox" name="ad[<?=$parent->id?>]" id="chk-big-<?=$index?>" value="<?=$parent->id?>" <?=$checked?>><label for="chk-big-<?=$index?>"><?=strtoupper($parent->name)?></label></div></h3>
                                    <ul class="<?=($checked != 'checked')?'hide':''?>">
                                        <?php
                                            $childs = Ads::findAll(['parent_id'=>$parent->id, 'active'=>GlobalConstants::TRUE]);
                                            foreach ($childs as $index2=>$child){?>
                                                <?php 
                                                    $checked_child = '';
                                                    foreach ($ads_assigns as $key => $ads_assign){
                                                        if($ads_assign->ad_id == $child->id)
                                                        {
                                                            $checked_child = 'checked';
                                                            break;
                                                        }
                                                    }
                                                ?>
                                                <li><div class="ui-checkbox"><input type="checkbox" name="ad[<?=$child->id?>]" id="chk-<?=$index.$index2?>" value="<?=$child->id?>" <?=$checked_child?>><label for="chk-<?=$index.$index2?>"><?=$child->name?></label></div></li>
                                        <?php }?>
                                    </ul>
                                </li>
                        <?php }?>
                    </ul>
                    <button type="submit" class="btn btn-submit" onclick="javascript:return true">Save</button>
                </form>
            </div>
        </div>        
    </div>
    <!-- /CONTENT -->
    <a href="/superadmin/ads" class="btn-right-side" data-text="Back to ADs"><i class="fa fa-undo" style="font-size: 28px"></i></a>
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>