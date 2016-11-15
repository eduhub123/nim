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
            <h1>Please Input Your Log in Credential</h1>
            <form id="login-form" method="post" novalidate>                                     
            <ul>
                <li>
                    <i class="fa fa-envelope"></i>
                    <input type="email" class="form-control" id="login-email" placeholder="Username" required>
                </li>
                <li>
                    <i class="fa fa-lock"></i>
                    <input type="password" class="form-control" id="login-password" placeholder="Password" required>
                </li>
                <li>
                    <div class="alert"><p></p></div>
                    <button type="submit" class="btn btn-submit">Login</button>             
                </li>               
                <li style="margin-bottom: 0">
                    <a href="#" title="">Forgot username or password ?</a>
                </li>
            </ul>
            </form>
        </div>
    </div>
</body>

