<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\UserAssignment;

$this->title = 'Customer Assignment';
$userAssignment = UserAssignment::findOne(['client_id'=>$modal->id]);
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-customers.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div class="user-profile">
                <div class="title">
                    <h1>Assign Employee</h1>                    
                    <div class="customer-id">CUSTOMER ID: <strong><?=GlobalFunctions::getUserID($modal->id)?></strong></div>
                </div>
                <form method="post" id="customer-profile-form" novalidate>
                    <input type="hidden" name="client_id" value="<?=$modal->id?>">                                        
                    <ul class="list-profile">
                        <li>
                            <label>Admin</label>
                            <select class="form-control" name="admin" required>
                                <option value="">Select Employee</option>
                                <?php 
                                    $users = User::findAll(['user_type_id'=> GlobalConstants::ADMIN_TYPE_ID, 'active'=>GlobalConstants::TRUE]);
                                    foreach ($users as $user) {
                                        $checked = ($userAssignment && $userAssignment->admin && $userAssignment->admin == $user->id)?'checked':'';                                    
                                    ?>
                                        <option value="<?=$user->id?>" <?=$checked?>>
                                            <?php 
                                                if($user->firstname)
                                                    echo $user->firstname.' '.$user->lastname;
                                                else
                                                    echo 'N/A';
                                            ?>
                                        </option>
                                <?php }?>
                            </select>
                        </li>
                        <li>
                            <label>Ad Specialist</label>
                            <select class="form-control" name="ad_specialist" required>
                                <option value="">Select Employee</option>
                                <?php 
                                    $users = User::findAll(['user_type_id'=> GlobalConstants::ADSPECIALIST_TYPE_ID, 'active'=>GlobalConstants::TRUE]);
                                    foreach ($users as $user) {
                                        $checked = ($userAssignment && $userAssignment->ad_specialist && $userAssignment->ad_specialist == $user->id)?'checked':'';                                    
                                    ?>
                                        <option value="<?=$user->id?>" <?=$checked?>>
                                            <?php 
                                                if($user->firstname)
                                                    echo $user->firstname.' '.$user->lastname;
                                                else
                                                    echo 'N/A';
                                            ?>
                                        </option>
                                <?php }?>
                            </select>
                        </li>
                        <li>
                            <label>Marketing Director</label>
                            <select class="form-control" name="marketing_director" required>
                                <option value="">Select Employee</option>
                                <?php 
                                    $users = User::findAll(['user_type_id'=> GlobalConstants::MARKETINGDIRECTOR_TYPE_ID, 'active'=>GlobalConstants::TRUE]);
                                    foreach ($users as $user) {
                                        $checked = ($userAssignment && $userAssignment->marketing_director && $userAssignment->marketing_director == $user->id)?'checked':'';                                    
                                    ?>
                                        <option value="<?=$user->id?>" <?=$checked?>>
                                            <?php 
                                                if($user->firstname)
                                                    echo $user->firstname.' '.$user->lastname;
                                                else
                                                    echo 'N/A';
                                            ?>
                                        </option>
                                <?php }?>
                            </select>
                        </li>
                        <li>
                            <label>CopyWriter</label>
                            <select class="form-control" name="copywriter" required>
                                <option value="">Select Employee</option>
                                <?php 
                                    $users = User::findAll(['user_type_id'=> GlobalConstants::COPYWRITER_TYPE_ID, 'active'=>GlobalConstants::TRUE]);
                                    foreach ($users as $user) {
                                        $checked = ($userAssignment && $userAssignment->copywriter && $userAssignment->copywriter == $user->id)?'checked':'';                                    
                                    ?>
                                        <option value="<?=$user->id?>" <?=$checked?>>
                                            <?php 
                                                if($user->firstname)
                                                    echo $user->firstname.' '.$user->lastname;
                                                else
                                                    echo 'N/A';
                                            ?>
                                        </option>
                                <?php }?>
                            </select>
                        </li>
                        <li>
                            <label>Designer</label>
                            <select class="form-control" name="designer" required>
                                <option value="">Select Employee</option>
                                <?php 
                                    $users = User::findAll(['user_type_id'=> GlobalConstants::DESIGNER_TYPE_ID, 'active'=>GlobalConstants::TRUE]);
                                    foreach ($users as $user) {
                                        $checked = ($userAssignment && $userAssignment->designer && $userAssignment->designer == $user->id)?'checked':'';                                    
                                    ?>
                                        <option value="<?=$user->id?>" <?=$checked?>>
                                            <?php 
                                                if($user->firstname)
                                                    echo $user->firstname.' '.$user->lastname;
                                                else
                                                    echo 'N/A';
                                            ?>
                                        </option>
                                <?php }?>
                            </select>
                        </li>
                        <li>
                            <label>General</label>
                            <select class="form-control" name="general" required>
                                <option value="">Select Employee</option>
                                <?php 
                                    $users = User::findAll(['user_type_id'=> GlobalConstants::GENERAL_TYPE_ID, 'active'=>GlobalConstants::TRUE]);
                                    foreach ($users as $user) {
                                        $checked = ($userAssignment && $userAssignment->general && $userAssignment->general == $user->id)?'checked':'';                                    
                                    ?>
                                        <option value="<?=$user->id?>" <?=$checked?>>
                                            <?php 
                                                if($user->firstname)
                                                    echo $user->firstname.' '.$user->lastname;
                                                else
                                                    echo 'N/A';
                                            ?>
                                        </option>
                                <?php }?>
                            </select>
                        </li>
                        <li>
                            <div class="alert"><p></p></div>
                            <button type="submit" class="btn">Save</button></li>
                    </ul>
                </form>
                <div class="user-avatar">
                    <div class="avatar">
                        <?php if($modal->avatar){?>
                            <img src="<?=Yii::getAlias('@web')?>/images/avatar.png" alt="">
                        <?php }else if(!$modal->firstname){
                            echo 'N';
                        }else{
                            echo substr($modal->firstname, 0, 1);
                        }?>
                    </div>
                    <a title=""><?php 
                        if($modal->firstname)
                            echo $modal->firstname.' '.$modal->lastname;
                        else
                            echo 'N/A';
                    ?></a>
                </div>
            </div>
        </div>        
    </div>
    <!-- /CONTENT -->
    <a href="/superadmin/customers" class="btn-right-side" data-text="Back to Customers"><i class="fa fa-undo" style="font-size: 28px"></i></a>
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>