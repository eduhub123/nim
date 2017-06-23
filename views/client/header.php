<?php
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Advertising;
use app\models\Ticket;
use app\models\TicketRelationship;
?>    
<div class="user">
    <?php $client = Yii::$app->user->identity;?>
    <a href="/client/userprofile" class="avatar <?=($client->avatar)?'none':''?>">
        <div class="img <?=($client->avatar)?'':'hide'?>" style="background-image: url(<?=$client->avatar?>)"></div>
        <?=substr($client->firstname, 0, 1)?>
    </a>
    <label><?=$client->firstname.' '.$client->lastname?></label>
    <span>ID: <strong><?=GlobalFunctions::getUserID($client->id)?></strong></span>
</div>
<div class="budget">
    <?php $advertising = Advertising::findOne(['client_id'=> Yii::$app->user->identity->id,'active'=>GlobalConstants::TRUE]);?>
    <span>Spent: <strong><?=($advertising)?$advertising->spent_amount:0?>$</strong></span>
</div>
<ul class="header-menu">
    <li>
        <div class="menu-message">
            <?php

            ?>
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
        <a href="/site/logout" class="logout"></a>
    </li>
</ul>