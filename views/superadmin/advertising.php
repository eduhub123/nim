<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\Advertising;
use app\models\AdvertisingPromotion;

$this->title = 'Advertising';
?>
<body>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/css/nouislider.min.css">
    <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/css/bootstrap-datetimepicker.min.css">
    <script src="<?=Yii::getAlias('@web')?>/js/nouislider.min.js" type="text/javascript"></script>
    <script src="<?=Yii::getAlias('@web')?>/js/moment.min.js" type="text/javascript"></script>
    <script src="<?=Yii::getAlias('@web')?>/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-advertising.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container"> 
            <div class="advertising">
                <h1 class="big-title">Advertising Dashboard</h1>
                <?php $advertising = Advertising::findOne(['client_id'=>Yii::$app->user->identity->current_client, 'active'=>GlobalConstants::TRUE]);?>
                <form method="post" id="form-update-advertising" novalidate>                
                    <ul class="advertising-list">
                        <li>
                            <h3>Your Current Advertising Plan <span class="hint" data-html="true" data-toggle="tooltip" data-placement="right" title="Typing something in here">?</span></h3>
                            <ul class="demand-focus">
                                <li><input type="radio" name="plan" value="1" id="demand_focus" <?=(!$advertising || ($advertising && $advertising->plan != 2))?'checked':''?>><label for="demand_focus">Demand Focus</label></li>
                                <li><input type="radio" name="plan" value="2" id="less_demand_focus" <?=($advertising && $advertising->plan == 2)?'checked':''?>><label for="less_demand_focus">Less Demand Focus</label></li>
                            </ul>
                        </li>
                        <li>
                            <h3>Adjust advertising campaign intensity</h3>
                            <div class="slider-adplan" data-first="Slow Down" data-last="Fast Forward">
                                <div id="run-slider" data-value="<?=($advertising && $advertising->intensity)?$advertising->intensity:0?>">
                                    <ul class="slider-doc">
                                        <li data-number="-50"></li>
                                        <li data-number="-25"></li>
                                        <li data-number="0"></li>
                                        <li data-number="25"></li>
                                        <li data-number="50"></li>
                                    </ul>
                                </div>
                                <input type="hidden" name="intensity" value="<?=($advertising && $advertising->intensity)?$advertising->intensity:0?>">
                            </div>                        
                        </li>
                        <li>
                            <h3>Pause marketing campaign</h3>
                            <div class="ui-checkbox right">
                                <input type="checkbox" id="mode-pause" name="pause" <?=($advertising && $advertising->pause)?'checked':''?>><label for="mode-pause" id="mode-pause-label">Pause </label>
                            </div>
                        </li>
                        <li>
                            <h3>Spent Amount <div class="ui-input-format" data-format="$"><input type="number" name="spent_amount" value="<?=($advertising && $advertising->spent_amount)?$advertising->spent_amount:0?>" required></div></h3>
                        </li>
                        <li>
                            <h3>Annual Budget <div class="ui-input-format" data-format="$"><input type="number" name="annual_budget" value="<?=($advertising && $advertising->annual_budget)?$advertising->annual_budget:0?>" required></div></h3>
                        </li>
                    </ul>
                    <center class="alert"><p></p></center>
                    <button class="btn btn-submit" type="submit">Send</button>                          
                </form>
                <div class="clearfix"></div>
                <div class="doc"></div>
                <h1 class="big-title">Promotion Creator</h1>
                <div id="inner">
                <?php $advertising_promotions = AdvertisingPromotion::find()->where(['client_id'=>Yii::$app->user->identity->current_client])->andWhere('active <> '.GlobalConstants::FALSE)->orderBy(['active'=>SORT_DESC])->all();
                    if($advertising_promotions){?>
                    <div class="management-box">
                        <div class="title">
                            <input class="txt-search promotion" placeholder="Search promotion ..."/>
                        </div>
                        <ul class="management-header">
                            <li class="col-number">No.</li>
                            <li class="col-name">Promotion Type</li>
                            <li class="col-parent">Date</li>
                            <li class="col-other"></li>
                        </ul><!-- /management-header -->
                        <ul class="management-list">
                            <?php foreach ($advertising_promotions as $index => $advertising_promotion) {?>
                                    <li>
                                        <ul>
                                            <li class="col col-number"><?=$index+1?></li>
                                            <li class="col col-name" <?=($advertising_promotion->active != GlobalConstants::TRUE)?'style="color: red"':''?>><?=$advertising_promotion->promotion_type?></li>
                                            <li class="col col-parent"><?=date('m-d-Y',strtotime($advertising_promotion->create_date))?></li>
                                            <li class="col col-other">
                                                <a href="/superadmin/promotiondetail/<?=$advertising_promotion->id?>" class="btn-edit">Edit</a>
                                                <a href="/superadmin/removepromotion/<?=$advertising_promotion->id?>" class="btn-delete">Delete</a>
                                            </li>
                                        </ul>
                                    </li>
                            <?php } ?>
                        </ul><!-- /management-list -->
                        <!-- <div class="no-results hide">
                            No results related to phrase "<strong>tets</strong>" found.                            
                        </div> -->
                        <div class="clearfix"></div>
                    </div>
                <?php }else{?>
                    <div class="no-results">
                        No results found            
                    </div>
                <?php }?>
                </div>                
            </div>
        </div>    
    </div>
    <!-- /CONTENT -->
    <div class="md-modal" id="confirm-change">
        Chosen action will have an immediate affect on your current advertising campaign. Your upcoming campaigns will return to its original state in Marketing Calendar. Are you sure to continue?
        <div class="md-footer">
            <button class="btn btn-submit">Yes</button>
            <button class="btn btn-cancel">No</button>
        </div>
    </div><!-- /video-play -->
    <div id="darkness"></div>
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>