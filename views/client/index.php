<?php
/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<body id="dashboard">   
    <div id="header">
        <img src="images/logo-new.png" alt="" class="logo">
        <div class="user">
            <a href="#" class="avatar"><img src="images/avatar.png" alt=""></a>
            <label>Khiem Nguyen</label>
            <span>ID: <strong>112345</strong></span>
        </div>
        <div class="budget">
            <span>Spent: <strong>2000$</strong></span>
        </div>
        <ul class="header-menu">
            <li>
                <div class="menu-message">
                    <button class="icon"><span>5</span></button>
                    <div class="message-hide">                          
                        <h1>Messages</h1>
                        <ul class="list-messages">
                            <li class="active">
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
                            </li>
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
                            <li class="active">
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
                            </li>
                        </ul>
                        <a class="view-all" href="#">View All</a>                           
                    </div>
                </div>
            </li>
            <li>
                <a href="/site/logout" class="logout"></a>
            </li>
        </ul>
    </div>
    <div id="content">
        <div class="container">
            <ul class="list-menu-dashboard">
                <li>
                    <a href="marketing-calendar.html" title="">
                        <div class="box-icon" style="background-color: #0091bc"><img src="images/icon-marketing-calendar-250.png" alt=""/></div>
                        <label>Marketing Calendar</label>
                    </a>
                </li>
                <li>
                    <a href="marketing-services.html" title="">
                        <div class="box-icon" style="background-color: #009593"><img class="icon" src="images/icon-marketing-service-250.png" alt=""/></div>
                        <label>Marketing Services</label>
                    </a>
                </li>
                <li>
                    <a href="advertising.html" title="">
                        <div class="box-icon" style="background-color: #ec7b32"><img class="icon" src="images/icon-advertising-250.png" alt=""/></div>
                        <label>Advertising</label>
                    </a>
                </li>
                <li>
                    <a href="ads.html" title="">
                        <div class="box-icon" style="background-color: #ed2c33"><img class="icon" src="images/icon-ads-250.png" alt=""/></div>
                        <label>ADs</label>
                    </a>
                </li>
                <li>
                    <a href="reports.html" title="">
                        <div class="box-icon" style="background-color: #498310"><img class="icon" src="images/icon-reports-250.png" alt=""/></div>
                        <label>Reports</label>
                    </a>
                </li>
                <li>
                    <a href="content-vault.html" title="">
                        <div class="box-icon" style="background-color: #02518d"><img class="icon" src="images/icon-content-vault-250.png" alt=""/></div>
                        <label>Content Vault</label>
                    </a>
                </li>
                <li>
                    <a href="business-profile.html" title="">
                        <div class="box-icon" style="background-color: #673182"><img class="icon" src="images/icon-business-profile-250.png" alt=""/></div>
                        <label>My Business Profile</label>
                    </a>
                </li>
                <li>
                    <a href="support.html" title="">
                        <div class="box-icon"><img class="icon" src="images/icon-support-250.png" alt=""/></div>
                        <label>Support</label>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</body>