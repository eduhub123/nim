<?php
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
?>    
<?php if(Yii::$app->user->identity->current_client){?>
<div class="client-selected">
    <div class="user">
        <?php $user = User::findOne(['id'=> Yii::$app->user->identity->current_client,'active'=>GlobalConstants::TRUE]);?>
        <div class="avatar">
            <?php if($user->avatar){?>
                <img src="<?=Yii::getAlias('@web')?>/images/avatar.png" alt="">
            <?php }else{
                echo substr($user->firstname, 0, 1);
            }?>
        </div>
        <label><?=$user->firstname.' '.$user->lastname?></label>
        <span>ID: <strong><?=GlobalFunctions::getUserID($user->id)?></strong></span>
    </div>
    <div class="client-box">
        <input placeholder="Type for search">
        <ul>
            <li>Khiem Nguyen <span>12345</span></li>
            <li>Khiem Nguyen <span>12345</span></li>
            <li>Khiem Nguyen <span>12345</span></li>
            <li>Khiem Nguyen <span>12345</span></li>
            <li>Khiem Nguyen <span>12345</span></li>
        </ul>
    </div>
</div>
<div class="budget">
    <span>Spent: <strong>2000$</strong></span>
</div>
<?php }?>
<ul class="header-menu">
    <li>
        <div class="menu-message">
            <button class="icon"><span>5</span></button>
            <div class="message-hide">                          
                <h1>Messages</h1>
                <ul class="list-messages">
                    <!-- <li class="active">
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li class="active">
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>                              
                        Customer ID: <span class="blue">45782</span> made a suggestion on Ad 3  in ADs/ Facebook Advertising
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li> -->
                </ul>
                <a class="view-all" href="#">View All</a>                           
            </div>                  
        </div>
    </li>
    <li>
        <div class="menu-notification">
            <button class="icon"><span>2</span></button>
            <div class="notification-hide">                         
                <h1>Notifications</h1>
                <ul class="list-notifications">
                    <!-- <li class="active">
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li class="active">
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>                              
                        Customer ID: <span class="blue">45782</span> made a suggestion on Ad 3  in ADs/ Facebook Advertising
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/avatar.png" alt=""></div>
                        Customer ID: <span class="blue">45782</span> has (increase or decrease)  Advertising Budget to $2500
                        <div class="datetime">On 9/30/16, at 10:56 AM</div>
                    </li> -->
                </ul>
                <a class="view-all" href="#">View All</a>                           
            </div>
        </div>
    </li>
    <li>
        <a href="user-profile.html" class="menu-account">
            <button class="icon"></button>                      
        </a>
    </li>
    <li>
        <a href="/site/logout" class="logout"></a>
    </li>
</ul>