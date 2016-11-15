<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Signup Employee';
?>
<link href="<?=Yii::getAlias('@web')?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="<?=Yii::getAlias('@web')?>/js/moment.min.js" type="text/javascript"></script>
<script src="<?=Yii::getAlias('@web')?>/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<body id="login">   
    <div class="login-form signup">
        <div>
            <?php if(!$message){?>     
            <h1>SIGNUP EMPLOYEE</h1>
            <form id="signup-form" method="post" novalidate>
                <input type="hidden" name="salt" id="signup-salt" value="<?=$salt?>">                                        
                <ul>
                    <li class="col-6">                  
                        <input type="text" class="form-control" placeholder="First Name" id="signup-firstname" required>
                    </li>
                    <li class="col-6 clear">                    
                        <input type="text" class="form-control" placeholder="Last Name" id="signup-lastname" required>
                    </li>
                    <li>
                        <i class="fa fa-envelope"></i>
                        <input type="email" class="form-control" value="<?=$email?>" placeholder="Email Login" required disabled>
                    </li>
                    <li>
                        <i class="fa fa-lock"></i>
                        <input type="password" class="form-control" id="password" placeholder="Password" required>
                        <span class="check-strength">Strong</span>
                    </li>
                    <li>
                        <i class="fa fa-unlock-alt"></i>
                        <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password" required>
                    </li>
                    <li>
                        <i class="fa fa-calendar"></i>
                        <input type="text" class="form-control input-datepicker" id="signup-birthday" placeholder="Birthday (Month / Date / Year)" required>
                    </li>
                    <li>
                        <div class="ui-checkbox">
                            <input type="checkbox" id="agree-term">
                            <label for="agree-term">I agree to the Terms & conditlons <a href="#" title="">Terms & conditlons</a></label>
                        </div>
                    </li>
                    <li style="margin-bottom: 0">
                        <div class="alert"><p>Username or password is not correct</p></div>
                        <button type="submit" class="btn btn-submit" disabled>Create an Account</button>                
                    </li>               
                </ul>
            </form>
            <?php }else{
                echo '<h2 class="text-center">'.$message.'</h2>';
            }?>
        </div>
    </div>
</body>

