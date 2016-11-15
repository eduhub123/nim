<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Industry;

$this->title = 'Customer Management';
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-customers.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div id="inner">
                <div class="management-box">
                    <div class="title">
                        <h1>Customer Management</h1>
                        <input class="txt-search customers" placeholder="Search customer ..."/>
                    </div>
                    <ul class="customers-list">
                        <?php
                            $users = User::findAll(['user_type_id'=>GlobalConstants::CLIENT_TYPE_ID, 'active'=>GlobalConstants::TRUE]);
                            foreach ($users as $user) {?>                                
                                <li>
                                    <a href="/superadmin/customerdetail/<?=$user->id?>">
                                        <div class="avatar">
                                            <?php if($user->avatar){?>
                                                <img src="<?=Yii::getAlias('@web')?>/images/avatar.png" alt="">
                                            <?php }else if(!$user->firstname){
                                                echo 'N';
                                            }else{
                                                echo substr($user->firstname, 0, 1);
                                            }?>
                                        </div>
                                        <label><?php 
                                            if($user->firstname)
                                                echo $user->firstname.' '.$user->lastname;
                                            else
                                                echo 'N/A';
                                        ?></label>
                                        <span class="id">ID: <strong><?=GlobalFunctions::getUserID($user->id)?></strong></span>
                                        <?=($user->industry_id)?Industry::findOne(['id'=>$user->industry_id])->name:'N/A'?>
                                    </a>
                                </li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /CONTENT -->
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>