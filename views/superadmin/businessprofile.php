<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Business;
use app\models\BusinessCategory;
use app\models\BusinessHasQuestion;
use app\models\BusinessOption;
use app\models\BusinessQuestion;
use app\models\BusinessHour;

$this->title = 'Business Profile';

$business = Business::findOne(['user_id'=>Yii::$app->user->identity->current_client]);
$salt = User::findOne(['id'=>Yii::$app->user->identity->current_client])->salt;
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-business-profile.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div class="business-profile">
                <h1 class="big-title other">GENERAL BUSINESS PROFILE</h1>
                <ul class="business-profile-detail">
                    <li>
                        <label>1. What is your business name?</label>
                        <div class="input"><?=($business->name)?$business->name:'N/A'?></div>
                    </li>
                    <li>
                        <label>2. What year was your business established?</label>                              
                        <div class="input"><?=($business->month)?$business->month:'N/A'?> - <?=($business->year)?$business->year:'N/A'?></div>
                    </li>
                    <li>
                        <label>3. How many business locations do you have?</label>                              
                        <div class="input"><?=($business->locations)?$business->locations:'N/A'?></div>
                    </li>
                    <li>
                        <label>4. What are address of these business locations?</label>
                        <ul class="list-usp">
                        <?php 
                            $business_locations = BusinessOption::findAll(['business_id'=>$business->id, 'tag'=>'locations', 'active'=>GlobalConstants::TRUE]);
                            if($business->locations && $business_locations){
                                foreach ($business_locations as $index=>$business_location) {
                                    echo '<li>'.($index+1).'. '.$business_location->content.'</li>';                                    
                                } 
                            }
                        ?>
                        </ul>
                    </li>
                    <li>
                        <label>5. What is your business hour?</label>
                        <?php
                            if($business->always_open == GlobalConstants::TRUE)
                                echo '<div style="padding-left: 20px">Always open</div>';
                            else{
                                $days = BusinessHour::findAll(['business_id'=>$business->id, 'active'=>GlobalConstants::TRUE]);
                                if($days) foreach ($days as $day) {
                                    if($day->status == GlobalConstants::TRUE)
                                        echo '<div style="padding-left: 20px"><span class="day-input">'.$day->day.':</span> <div class="input">'.$day->time_open.' - '.$day->time_close.'</div></div>';
                                    else
                                        echo '<div style="padding-left: 20px"><span class="day-input">'.$day->day.':</span> <div class="input">Closed</div></div>';
                                }
                            }
                        ?>
                    </li>
                    <li>
                        <label>6. What is the slogan of your business (if any)?</label>
                        <div class="input"><?=($business->slogan)?$business->slogan:'N/A'?></div>
                    </li>
                    <li>
                        <label>7. What are the top ten USPs of your business?</label>
                        <ul class="list-usp">
                            <?php
                                $business_usp = BusinessOption::findAll(['business_id'=>$business->id, 'tag'=>'usp', 'active'=>GlobalConstants::TRUE]);
                                if($business_usp) foreach ($business_usp as $index=>$usp) {                                    
                                    echo '<li>'.($index+1).'. '.$usp->content.'</li>';
                                }
                            ?>
                        </ul>
                    </li>
                    <li>
                        <label>8. Please attach your business logo and/or banner (if any) in here.</label>                        
                        <div class="input">
                        <?php 
                            if($business->logo)
                                echo '<img src="'.$business->logo.'" style="max-width: 200px" alt=""><br>';
                            if($business->banner)
                                echo '<img src="'.$business->banner.'" height="300" alt="">';
                            if(!$business->logo && !$business->banner)
                                echo 'None';
                        ?>
                        </div>
                    </li>
                    <li>
                        <label>9. What is your business advertising budget annually?</label>
                        <div class="input"><?=($business->budget)?$business->budget:'0.00'?></div>$
                    </li>
                </ul>
                <div class="clearfix"></div>        
                <h1 class="big-title other">SERVICE PROFILE</h1>
                <ul class="business-profile-detail">
                    <li>
                        <label>1. Please write down primary services that your business offers with their average price respectively.</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Primary services</th>
                                    <th><center>Average price range ($)</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $primary_services = BusinessOption::findAll(['business_id'=>$business->id, 'tag'=>'primary_services', 'active'=>GlobalConstants::TRUE]);
                                    if($primary_services) foreach ($primary_services as $primary_service) {
                                        echo '<tr>
                                                <td>'.$primary_service->name.'</td>
                                                <td align="center">'.$primary_service->content.'</td>
                                            </tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <label>2. What is the most in-demand service of your business?</label>
                        <div class="input"><?=($business->in_demand_service)?$business->in_demand_service:'N/A'?></div>
                    </li>
                    <li>
                        <label>3. Please indicate percentage between walk-in versus appointment:</label>
                        <div class="row" style="padding-left: 25px">
                            <div class="col-md-3">Walk-in: <?=($business->walk_in)?$business->walk_in:'0'?>%</div>
                            <div class="col-md-3">Appointment: <?=($business->appointment)?$business->appointment:'0'?>%</div>
                        </div>
                    </li>
                    <li>
                        <label>4. Please indicate the demand of your business in percentage for each month in a year.</label>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td align="center">Jan</td>
                                    <td align="center">100%</td>
                                    <td align="center">Jul</td>
                                    <td align="center">100%</td>
                                </tr>
                                <tr>
                                    <td align="center">Feb</td>
                                    <td align="center">100%</td>
                                    <td align="center">Aug</td>
                                    <td align="center">90%</td>
                                </tr>
                                <tr>
                                    <td align="center">Mar</td>
                                    <td align="center">100%</td>
                                    <td align="center">Sep</td>
                                    <td align="center">100%</td>
                                </tr>
                                <tr>
                                    <td align="center">Apr</td>
                                    <td align="center">95%</td>
                                    <td align="center">Oct</td>
                                    <td align="center">95%</td>
                                </tr>
                                <tr>
                                    <td align="center">May</td>
                                    <td align="center">100%</td>
                                    <td align="center">Nov</td>
                                    <td align="center">100%</td>
                                </tr>
                                <tr>
                                    <td align="center">Jun</td>
                                    <td align="center">100%</td>
                                    <td align="center">Dec</td>
                                    <td align="center">100%</td>
                                </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <label>5. Do you currently have any promotion program?</label>
                        <div class="input">Yes</div>
                    </li>
                    <li>
                        <label>6. Please select the most profitable holidays of your business.</label>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td width="33.33%">New Year’s Day</td>
                                    <td width="33.33%">Valentine’s Day<i class="fa fa-check-square-o"></i></td>
                                    <td width="33.33%">St. Patrick’s Day<i class="fa fa-check-square-o"></i></td>
                                </tr>
                                <tr>
                                    <td>Martin Luther King Day</td>
                                    <td>President’s Day</td>
                                    <td>April Fool’s Day</td>
                                </tr>
                                <tr>
                                    <td>Good Friday</td>
                                    <td>Easter Day</td>
                                    <td>Passover Day</td>
                                </tr>
                                <tr>
                                    <td>Mother’s Day<i class="fa fa-check-square-o"></i></td>
                                    <td>Memorial Day</td>
                                    <td>Father’s Day<i class="fa fa-check-square-o"></i></td>
                                </tr>
                                <tr>
                                    <td>Independence Day</td>
                                    <td>Labor Day</td>
                                    <td>Columbus Day</td>
                                </tr>
                                <tr>
                                    <td>Halloween Day<i class="fa fa-check-square-o"></i></td>
                                    <td>Veterans Day</td>
                                    <td>Thanksgiving Day</td>
                                </tr>
                                <tr>
                                    <td>Christmas<i class="fa fa-check-square-o"></i></td>
                                    <td>Kwanzaa Day</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </li>
                </ul>
                <div class="clearfix"></div>        
                <h1 class="big-title other">CUSTOMERS PROFILE</h1>
                <ul class="business-profile-detail">
                    <li>
                        <label>1. What is the percentage of each gender in your business?</label>
                        <div class="row" style="padding-left: 25px">
                            <div class="col-md-3">Male: <?=$business->male?>%</div>
                            <div class="col-md-3">Female: <?=$business->female?>%</div>
                        </div>
                    </li>
                    <li>
                        <label>2. What is the percentage of each age group of your target customer ?</label>
                        <div class="row" style="padding-left: 25px">
                            <?php 
                                $business_questions = BusinessQuestion::findAll(['category_id'=> GlobalConstants::TARGET_CUSTOMER, 'active'=>GlobalConstants::TRUE]);                     
                                foreach ($business_questions as $index=>$business_question) {
                                    $business_has_question = BusinessHasQuestion::findOne(['question_id'=>$business_question->id, 'business_id'=>$business->id, 'active'=>GlobalConstants::TRUE]);
                            ?>
                                    <div class="col-md-3"><?=$business_question->name?>: <?=($business_has_question)?$business_has_question->answer:0?>%</div>
                            <?php } ?>
                        </div>
                    </li>
                    <li>
                        <label>3. What is the percentage of each customer relationship status in your business?</label>
                        <div class="row" style="padding-left: 25px">
                            <?php 
                                $business_questions = BusinessQuestion::findAll(['category_id'=> GlobalConstants::CUSTOMER_RELATIONSHIP, 'active'=>GlobalConstants::TRUE]);                     
                                foreach ($business_questions as $index=>$business_question) {
                                    $business_has_question = BusinessHasQuestion::findOne(['question_id'=>$business_question->id, 'business_id'=>$business->id, 'active'=>GlobalConstants::TRUE]);
                            ?>
                                    <div class="col-md-3"><?=$business_question->name?>: <?=($business_has_question)?$business_has_question->answer:0?>%</div>
                            <?php } ?>
                        </div>
                    </li>
                    <li>
                        <label>4. In the business industry, what is your customer segment level?</label>
                        <div class="input">
                            <?php
                                if($business->segment_level == 1)
                                    echo 'High-end customer';
                                else if($business->segment_level == 2)
                                    echo 'Medium-end customer';
                                else
                                    echo 'Low-end customer';
                            ?>
                        </div>
                    </li>
                    <li>
                        <label>5. What is major purchasing behavior of your target customers (if any)?</label>
                        <div class="input">
                            <pre style="border: 0; background: none; padding: 0; font: 300 16px/1.4 Roboto"><?=$business->purchasing_behavior?></pre>
                        </div>
                    </li>
                </ul>
                <div class="clearfix"></div>        
                <h1 class="big-title other">INDUSTRY SPECIFY</h1>
                <ul class="business-profile-detail">
                    <li>
                        <label>1. What is the percentage of each gender in your business?</label>
                        <div class="input">Coming soon...</div>
                    </li>
                    <li>
                        <label>2. What is the percentage of each age group in your business?</label>
                        <div class="input">Coming soon...</div>
                    </li>
                    <li>
                        <label>3. What is the percentage of each customer relationship status in your business?</label>
                        <div class="input">Coming soon...</div>
                    </li>
                    <li>
                        <label>4. In the business industry, what is your customer segment level?</label>
                        <div class="input">Coming soon...</div>
                    </li>
                    <li>
                        <label>5. What is major purchasing behavior of your target customers (if any)?</label>
                        <div class="input">Coming soon...</div>
                    </li>
                </ul>               
            </div>
        </div>
    </div>
    <!-- /CONTENT -->
    <a href="/site/updateinformation?salt=<?=$salt?>&type=edit" class="btn-right-side" data-text="Update Profile"><i class="fa fa-edit"></i></a>
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>