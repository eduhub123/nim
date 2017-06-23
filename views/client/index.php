<?php
/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<body id="dashboard">   
    <div id="header">
        <img src="images/logo-new.png" alt="" class="logo">
        <?php include 'header.php';?>
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