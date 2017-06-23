<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\Advertising;
use app\models\AdvertisingPromotion;

$this->title = 'Advertising Promotion Detail
';
?>
<body>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/css/bootstrap-datetimepicker.min.css">    
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
                <h1 class="big-title">Promotion Creator</h1>
                <form method="post" id="form-update-advertising-promotion" novalidate>
                    <input type="hidden" name="id" value="<?=$modal->id?>">
                    <ul class="advertising-list">
                        <li>
                            <h3>Do you want to create an ad out this promotion ?</h3>
                            <div class="ui-radio"><input type="radio" name="create_ad" value="<?=GlobalConstants::TRUE?>" id="checkbox-01" <?=($modal->create_ad == GlobalConstants::TRUE)?'checked':''?>><label for="checkbox-01">Yes</label></div>
                            <div class="ui-radio"><input type="radio" name="create_ad" value="<?=GlobalConstants::FALSE?>" id="checkbox-02" <?=($modal->create_ad == GlobalConstants::FALSE)?'checked':''?>><label for="checkbox-02">No</label></div>
                        </li>
                        <li>
                            <h3>Target Customers : </h3>
                            <div class="ui-checkbox"><input type="checkbox" name="new_customer" id="checkbox-03" <?=($modal->new_customer == GlobalConstants::TRUE)?'checked':''?>><label for="checkbox-03">New Customers</label></div>
                            <div class="ui-checkbox"><input type="checkbox" name="exist_customer" value="<?=GlobalConstants::EXISTING_CUSTOMER?>" id="checkbox-04" <?=($modal->exist_customer == GlobalConstants::TRUE)?'checked':''?>><label for="checkbox-04">Existing Customers</label></div>
                            <div class="ui-checkbox"><input type="checkbox" name="lost_customer" value="<?=GlobalConstants::LOST_CUSTOMER?>" id="checkbox-05" <?=($modal->lost_customer == GlobalConstants::TRUE)?'checked':''?>><label for="checkbox-05">Lost Customers</label></div>
                        </li>
                        <li>
                            <h3>Choose your type of promotion</h3>
                            <div class="ui-radio"><input type="radio" name="promotion_type" data-index="0" value="<?=GlobalConstants::DISCOUNT_PROMOTION?>" id="checkbox-06" <?=($modal->promotion_type == GlobalConstants::DISCOUNT_PROMOTION)?'checked':''?>><label for="checkbox-06">Discount Promotion</label></div>
                            <div class="ui-radio"><input type="radio" name="promotion_type" data-index="1" value="<?=GlobalConstants::GIVE_AWAY_PROMOTION?>" id="checkbox-07" <?=($modal->promotion_type == GlobalConstants::GIVE_AWAY_PROMOTION)?'checked':''?>><label for="checkbox-07">Give Away Promotion</label></div>
                            <div class="ui-radio"><input type="radio" name="promotion_type" data-index="2" value="<?=GlobalConstants::INCREASE_SALE_PROMOTION?>" id="checkbox-08" <?=($modal->promotion_type == GlobalConstants::INCREASE_SALE_PROMOTION)?'checked':''?>><label for="checkbox-08">Increase Sale Promotion</label></div>
                            <div class="clearfix"></div>
                            <ul class="discount-content">
                                <li class="<?=($modal->promotion_type == GlobalConstants::DISCOUNT_PROMOTION)?'active':''?>">Discount 
                                    <div class="ui-input-format"><input type="number" name="discount" value="<?=$modal->discount?>" required>
                                        <select name="discount_type">
                                            <option value="percent" <?=($modal->discount_type == 'percent')?'selected':''?>>%</option>
                                            <option value="dollar" <?=($modal->discount_type == 'dollar')?'selected':''?>>$</option>
                                        </select>
                                    </div> 
                                for <input type="text" name="service_productname1" value="<?=($modal->promotion_type == GlobalConstants::DISCOUNT_PROMOTION)?$modal->service_productname:''?>" placeholder="enter your service or product name"> 
                                    <?php if(!$modal->service_productname_2){?>
                                        <button>+ together with</button>
                                        <div class="hide">together with <input type="text" name="service_productname1_2" placeholder="enter your service or product name"></div>
                                    <?php }else{?>
                                        <div>together with <input type="text" name="service_productname1_2" value="<?=$modal->service_productname_2?>" placeholder="enter your service or product name"></div>
                                    <?php }?>
                                </li>
                                <li class="<?=($modal->promotion_type == GlobalConstants::GIVE_AWAY_PROMOTION)?'active':''?>">Give <input type="text" value="<?=($modal->promotion_type == GlobalConstants::GIVE_AWAY_PROMOTION)?$modal->service_productname:''?>" placeholder="enter your service or product name" name="service_productname2"> when purchase <input type="text" name="service_productname2_2" value="<?=($modal->promotion_type == GlobalConstants::GIVE_AWAY_PROMOTION)?$modal->service_productname_2:''?>" placeholder="enter your service or product name"> together with <input type="text" name="service_productname2_3" value="<?=($modal->promotion_type == GlobalConstants::GIVE_AWAY_PROMOTION)?$modal->service_productname_3:''?>" placeholder="enter your service or product name"></li>
                                <li class="<?=($modal->promotion_type == GlobalConstants::INCREASE_SALE_PROMOTION)?'active':''?>">Buy <input type="text" name="service_productname3" value="<?=($modal->promotion_type == GlobalConstants::INCREASE_SALE_PROMOTION)?$modal->service_productname:''?>" placeholder="enter your service or product name"> together with <input type="text" name="service_productname3_2" value="<?=($modal->promotion_type == GlobalConstants::INCREASE_SALE_PROMOTION)?$modal->service_productname_2:''?>" placeholder="enter your service or product name"> and <input type="text" name="service_productname3_3" value="<?=($modal->promotion_type == GlobalConstants::INCREASE_SALE_PROMOTION)?$modal->service_productname_3:''?>" placeholder="enter your service or product name"></li>
                            </ul>
                        </li>
                        <li>
                            <h3>Average Cost Per Customer ?</h3>
                            <div class="ui-input-format gray" data-format="$"><input type="number" name="average_cost" value="<?=$modal->average_cost?>" required></div>
                        </li>
                        <li>
                            <h3>What is your total budget for this promotion?</h3>
                            <div class="ui-input-format gray" data-format="$"><input type="number" name="budget" value="<?=$modal->budget?>" style="width: 150px" required></div>
                        </li>
                        <li>
                            <h3>What is your ultimate reason for this promotion?</h3>
                            <textarea class="form-control" name="ultimate_reason" style="border: 1px solid #ebebeb"><?=$modal->ultimate_reason?></textarea>
                        </li>
                        <li>
                            <h3>Start date</h3>
                            <div class="ui-input-format date"><input type="text" name="start_date" class="input-datepicker" value="<?=date('m-d-Y',strtotime($modal->start_date))?>" placeholder="Month / Date / Year" required></div>
                        </li>
                        <li>
                            <h3>End date</h3>
                            <div class="ui-input-format date"><input type="text" name="end_date" class="input-datepicker" value="<?=date('m-d-Y',strtotime($modal->end_date))?>" placeholder="Month / Date / Year" required></div>
                        </li>
                        <li>
                            <h3>Anualy reocuring</h3>
                            <div class="ui-radio"><input type="radio" name="anualy_reocuring" value="<?=GlobalConstants::TRUE?>" id="checkbox-09" <?=($modal->anualy_reocuring == GlobalConstants::TRUE)?'checked':''?>><label for="checkbox-09">Yes</label></div>
                            <div class="ui-radio"><input type="radio" name="anualy_reocuring" value="<?=GlobalConstants::FALSE?>" id="checkbox-10" <?=($modal->anualy_reocuring == GlobalConstants::FALSE)?'checked':''?>><label for="checkbox-10">No</label></div>
                        </li>
                    </ul>
                    <?php if($modal->active == 2){?>
                        <button class="btn btn-submit" type="submit">Submit</button>
                    <?php }?>
                </form>
            </div>
        </div>    
    </div>
    <!-- /CONTENT -->
    <div id="darkness"></div>
    <a href="/superadmin/advertising" class="btn-right-side" data-text="Back to Advertising"><i class="fa fa-undo" style="font-size: 28px"></i></a>
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>