<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Industry;
$this->title = 'User Profile';
$user = Yii::$app->user->identity;
?>
<link href="<?=Yii::getAlias('@web')?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="<?=Yii::getAlias('@web')?>/js/moment.min.js" type="text/javascript"></script>
<script src="<?=Yii::getAlias('@web')?>/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="/images/icon-employees.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">         
            <div class="user-profile">
                <div class="title">
                    <h1>Personal profile</h1>                    
                    <div class="customer-id">CUSTOMER ID: <strong><?=GlobalFunctions::getUserID($user->id)?></strong></div>
                </div>
                <form method="post" id="updateprofile-form" novalidate>                             
                <ul class="list-profile">                   
                    <li class="col-6">
                        <label>First Name</label>
                        <input type="text" name="firstname" value="<?=$user->firstname?>" class="form-control" required>

                    </li>
                    <li class="col-6 clear">
                        <label>Last Name</label>
                        <input type="text" name="lastname" value="<?=$user->lastname?>" class="form-control" required>
                    </li>
                    <li>
                        <label>Industry</label>
                        <select class="form-control" name="industry">
                            <option value="">Select Industry</option>
                            <?php 
                                $industries = Industry::findAll(['active'=>GlobalConstants::TRUE]);
                                foreach ($industries as $industry) {
                                    if($user->industry_id == $industry->id)
                                        echo '<option value="'.$industry->id.'" selected>'.$industry->name.'</option>';
                                    else
                                        echo '<option value="'.$industry->id.'">'.$industry->name.'</option>';
                                }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label>Contact Phone Number</label>
                        <input type="text" name="phone" value="<?=$user->phone?>" class="form-control" required>
                    </li>
                    <li>
                        <label>Birthday</label>
                        <input type="text" name="birthday" value="<?=($user->birthday)?date('m/d/Y', strtotime($user->birthday)):date('m/d/Y')?>" class="form-control input-datepicker" required>
                    </li>
                    <li>
                        <label>Address</label>
                        <input type="text" name="address" value="<?=$user->address?>" class="form-control" required>
                    </li>
                    <li>
                        <div class="ui-checkbox">
                            <input type="checkbox" name="is-change" id="change-password">
                            <label for="change-password">I want change password</label>                     
                        </div>
                    </li>
                    <li class="open-change-password hide">
                        <label>Old Password</label>
                        <input type="password" name="old-password" class="form-control">
                    </li>
                    <li class="open-change-password hide">
                        <label>New Password</label>
                        <input type="password" name="new-password" id="password" class="form-control">
                        <span class="check-strength">Strong</span>
                    </li>
                    <li class="open-change-password hide">
                        <label>Confirm Password</label>
                        <input type="password" id="confirm-password" class="form-control">
                    </li>
                    <li>
                        <div class="alert"><p></p></div>
                        <button type="submit" class="btn">Save</button>
                    </li>
                </ul>
                </form>
                <div class="user-avatar">
                    <div class="avatar <?=($user->avatar)?'none':''?>">          
                        <div class="img <?=($user->avatar)?'':'hide'?>" style="background-image: url(<?=$user->avatar?>)"></div>
                        <?=substr($user->firstname, 0, 1)?>
                    </div>
                    <label for="upload-user-avatar">Change Avatar</label>
                    <input type="file" id="upload-user-avatar">
                </div>
            </div><!-- /user-profile -->
        </div>  
    </div>
    <!-- /CONTENT -->    
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>    
</body>