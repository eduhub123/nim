<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;

$this->title = 'Employee Management';
$user_types = UserType::findAll(['parent_id'=> GlobalConstants::FALSE]);
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-employees.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div id="inner">
                <div class="management-box">

                    <ul class="employee-tabs">
                        <?php  
                            foreach ($user_types as $index => $user_type) {
                                $class = ($index == 0)?'active':'';
                        ?>
                            <li class="<?=$class?>" data-tab="<?=$user_type->slug?>"><?=$user_type->name?></li>
                        <?php }?>
                    </ul>
                    <?php                         
                        foreach ($user_types as $index => $user_type) {
                            $class = ($index == 0)?'':'hide';
                    ?>
                        <div class="employee-tab-child <?=$user_type->slug?> <?=$class?>">
                            <div class="employee-detail">
                                <h1><?=$user_type->name?></h1>
                                <p><?=$user_type->description?></p>
                            </div>
                            <div class="doc"></div>
                            <ul class="customers-list">
                                <?php
                                    $users = User::findAll(['user_type_id'=>$user_type->id, 'active'=>GlobalConstants::TRUE]);
                                    foreach ($users as $user) {
                                ?>
                                <li>
                                    <a>
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
                                        <button class="btn btn-remove-employee" data-id="<?=$user->id?>">Remove</button>
                                    </a>                            
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    <?php                            
                        }
                    ?> 
                    <div class="clearfix"></div>
                    <div class="title">
                        <h1>Add new Employee</h1>
                    </div>
                    <form method="post" id="mail-for-employee" novalidate>     
                        <ul class="management-form">                        
                            <li class="col-4">
                                <ul>
                                    <?php  
                                        foreach ($user_types as $index => $user_type) {
                                            $checked = ($index == 0)?'checked':'';
                                    ?>
                                        <li><input type="radio" name="user-type" value="<?=$user_type->id?>" data-tab="<?=$user_type->slug?>" id="checkbox-0<?=$index?>" <?=$checked?>>
                                            <label for="checkbox-0<?=$index?>"><?=$user_type->name?></label></li>
                                    <?php }?>
                                </ul>
                            </li>
                            <li class="col-8">
                                <input type="email" class="form-control" id="employee-email" placeholder="Enter Account Email" required>
                                <div class="alert"><p></p></div>
                                <?php  
                                    foreach ($user_types as $index => $user_type) {
                                        $class = ($index == 0)?'':'hide';
                                ?>
                                <div class="text <?=$user_type->slug?> <?=$class?>"><?=$user_type->description?></div>
                                <?php }?>
                            </li>                       
                            <li><button class="btn btn-submit" type="submit" style="float: right">Send</button></li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>      
    </div>
    <!-- /CONTENT -->
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>