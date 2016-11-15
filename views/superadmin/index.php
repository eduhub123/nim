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
                <?php if(Yii::$app->user->identity->current_client){?>
                <li>
                    <a href="/superadmin/marketingcalendar" title="">
                        <div class="box-icon" style="background-color: #0091bc"><img src="images/icon-marketing-calendar-250.png" alt=""/></div>
                        <label>Marketing Calendar</label>
                    </a>
                </li>
                <li>
                    <a href="/superadmin/marketingservices" title="">
                        <div class="box-icon" style="background-color: #009593"><img class="icon" src="images/icon-marketing-service-250.png" alt=""/></div>
                        <label>Marketing Services</label>
                    </a>
                </li>
                <li>
                    <a href="/superadmin/advertising" title="">
                        <div class="box-icon" style="background-color: #ec7b32"><img class="icon" src="images/icon-advertising-250.png" alt=""/></div>
                        <label>Advertising</label>
                    </a>
                </li>
                <li>
                    <a href="/superadmin/ads" title="">
                        <div class="box-icon" style="background-color: #ed2c33"><img class="icon" src="images/icon-ads-250.png" alt=""/></div>
                        <label>ADs</label>
                    </a>
                </li>
                <li>
                    <a href="/superadmin/reports" title="">
                        <div class="box-icon" style="background-color: #498310"><img class="icon" src="images/icon-reports-250.png" alt=""/></div>
                        <label>Reports</label>
                    </a>
                </li>
                <li>
                    <a href="/superadmin/contentvault" title="">
                        <div class="box-icon" style="background-color: #02518d"><img class="icon" src="images/icon-content-vault-250.png" alt=""/></div>
                        <label>Content Vault</label>
                    </a>
                </li>
                <li>
                    <a href="/superadmin/businessprofile" title="">
                        <div class="box-icon" style="background-color: #673182"><img class="icon" src="images/icon-business-profile-250.png" alt=""/></div>
                        <label>My Business Profile</label>
                    </a>
                </li>
                <li>
                    <a href="/superadmin/support" title="">
                        <div class="box-icon"><img class="icon" src="images/icon-support-250.png" alt=""/></div>
                        <label>Support</label>
                    </a>
                </li>
                <?php }?>
                <li>
                    <a href="/superadmin/services" title="">
                        <div class="box-icon"><img class="icon" src="images/icon-services-250.png" alt=""/></div>
                        <label>Services</label>
                    </a>
                </li>
                <li>
                    <a href="/superadmin/adsmanagement" title="">
                        <div class="box-icon"><img class="icon" src="images/icon-advertising-250.png" alt=""/></div>
                        <label>ADs Management</label>
                    </a>
                </li>               
                <li>
                    <a href="/superadmin/customers" title="">
                        <div class="box-icon"><img class="icon" src="images/icon-customers-250.png" alt=""/></div>
                        <label>Customers</label>
                    </a>
                </li>
                <li>
                    <a href="/superadmin/employees" title="">
                        <div class="box-icon"><img class="icon" src="images/icon-employees-250.png" alt=""/></div>
                        <label>Employees</label>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</body>