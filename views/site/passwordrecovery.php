<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
?>
<body id="login">   
    <div class="login-form">
        <div>       
            <h1>password recovery</h1>
            <form id="login-form" method="post" novalidate>                                     
            <ul>
                <li>
                    <i class="fa fa-lock"></i>
                    <input type="password" class="form-control" id="login-password" placeholder="Password" required>
                </li>
                <li>
                    <i class="fa fa-lock"></i>
                    <input type="password" class="form-control" id="login-confirm-password" placeholder="Confirm Password" required>
                </li>
                <li>
                    <div class="alert"><p></p></div>
                    <button type="submit" class="btn btn-submit">Send</button>             
                </li>
            </ul>
            </form>
        </div>
    </div>
</body>

