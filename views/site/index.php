<?php
use app\assets\FacebookAds;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
<?php
        // $ADwordsUser = Yii::$app->GoogleAds->user;

        // // Get the service, which loads the required classes.
        // $managedCustomerService =
        //     $ADwordsUser->GetService('ManagedCustomerService');

        // // Create customer.
        // $customer = new \ManagedCustomer();
        // $customer->name = 'Account #' . uniqid();
        // $customer->currencyCode = 'EUR';
        // $customer->dateTimeZone = 'Europe/London';

        // // Create operation.
        // $operation = new \ManagedCustomerOperation();
        // $operation->operator = 'ADD';
        // $operation->operand = $customer;

        // $operations = [$operation];

        // // Make the mutate request.
        // $result = $managedCustomerService->mutate($operations);        
        // // Display result.
        // $customer = $result->value[0];
        // printf("Account with customer ID '%s' was created.\n",
        //     $customer->customerId);
        
        //FacebookAds::getUser();
        // echo '<br>';
        FacebookAds::init();
        $content = file_get_contents("http://youtube.com/get_video_info?video_id=hgGzsYYe2bE");
        parse_str($content, $ytarr);
        //echo $ytarr['length_seconds'];
        echo date("H:i", $ytarr['length_seconds']).'<br>';
        //print_r($ytarr);
?>
<button id="loginBtn">Facebook Login</button>
<div id="response"></div>
<script type="text/javascript">       
    //load the JavaScript SDK
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
     
     window.fbAsyncInit = function() {
        //SDK loaded, initialize it
        FB.init({
            appId      : <?=FacebookAds::APP_ID?>,
            xfbml      : true,
            version    : 'v2.7'
        });
     
        //check user session and refresh it
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                //user is authorized
                document.getElementById('loginBtn').style.display = 'none';
                getUserData();
            } else {
                //user is not authorized
            }
        });
    };

    //add event listener to login button
    document.getElementById('loginBtn').addEventListener('click', function() {
        //do the login
        FB.login(function(response) {
            if (response.authResponse) {
                //user just authorized your app
                document.getElementById('loginBtn').style.display = 'none';
                getUserData();
            }
        }, {scope: 'email,public_profile', return_scopes: true});
    }, false);
    function getUserData() {
        FB.api('/me', function(response) {
            console.log(JSON.stringify(response));
        });
        FB.api('/129782964150796/friends', function(response) {
            //document.getElementById('response').innerHTML = 'Hello ' + response.name;
            console.log(JSON.stringify(response));
            //console.log(response.summary.total_count);
        });
    }   
</script> 