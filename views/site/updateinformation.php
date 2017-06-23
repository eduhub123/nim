<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\Business;
use app\models\BusinessCategory;
use app\models\BusinessQuestion;
use app\models\BusinessHasQuestion;
use app\models\BusinessOption;
use app\models\BusinessHour;
use app\models\Setting;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Update information';
$business = Business::findOne(['user_id'=>$client->id]);
$time_open = Setting::findOne(['key'=>'time_open'])->content;
$time_close = Setting::findOne(['key'=>'time_close'])->content;
?>
<body id="update-information" data-current="<?=$client->current_step?>" data-salt="<?=$client->salt?>">
	<link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/css/bootstrap-datetimepicker.min.css">    
    <script src="<?=Yii::getAlias('@web')?>/js/moment.min.js" type="text/javascript"></script>
    <script src="<?=Yii::getAlias('@web')?>/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
	<script src="/js/updatebusinessinfo.js" type="text/javascript"></script>
    <div class="immediate">
    	Immediate Assistant
    	<a href="tel:18008198000" title=""><i class="fa fa-phone-square"></i> 1 800 819 8000</a>
    </div>
    <div class="container">
	    <div class="title">
	    	<img src="/images/logo-info.png" alt="">
	    	<h1 class="hide">GENERAL BUSINESS PROFILE</h1>
	    	<span class="step hide">( Question <?=$client->current_step?> of 21 )</span>
	    </div>
	    <div class="slider-information">
	    	<span class="btn-arrow btn-prev hide"></span>
	    	<span class="btn-arrow btn-next hide"></span>
	    	<div class="slider-information-child step-0 hide">
	    		<br>
	    		<div class="intro">
	    			<p>You are taking part in providing your business information for Northern Interactive Media Corp. Northern Interactive Media Corp. is a digital marketing agency that helps improve digital marketing strategies and decision-making through research and analysis.</p>
	    			<p>The questionnaire is conducted by marketing research department of Northern Interactive Media Corp. We promise to protect your privacy and the information as confidential.</p>
	    			<p>It might take you approximately 10 – 20 minutes to complete the questionnaire; however, you will be ensured to receive the most effective and appropriate digital marketing strategies for your business. The information will be stored and intelligently remembered for future extended services.</p>
	    			<div class="clearfix"></div>
	    			<center><button class="btn">Continue</button></center>
	    		</div>
	    	</div>
	    	<div class="slider-information-child step-1 hide" data-title="GENERAL BUSINESS PROFILE">
	    		<label class="question">What is your business name ?</label>
	    		<input type="text" id="bi_name" placeholder=". . ." value="<?=$business->name?>">
	    	</div>
	    	<div class="slider-information-child step-2 hide" data-title="GENERAL BUSINESS PROFILE">
	    		<label class="question">What month and year was your business established ?</label>
	    		<select id="bi_month">
	    			<option value="">Month</option>
	    			<option value="1" <?=($business->month == 1)?'selected':''?>>January</option>
	    			<option value="2" <?=($business->month == 2)?'selected':''?>>February</option>
	    			<option value="3" <?=($business->month == 3)?'selected':''?>>March</option>
	    			<option value="4" <?=($business->month == 4)?'selected':''?>>April</option>
	    			<option value="5" <?=($business->month == 5)?'selected':''?>>May</option>
	    			<option value="6" <?=($business->month == 6)?'selected':''?>>June</option>
	    			<option value="7" <?=($business->month == 7)?'selected':''?>>July</option>
	    			<option value="8" <?=($business->month == 8)?'selected':''?>>August</option>
	    			<option value="9" <?=($business->month == 9)?'selected':''?>>September</option>
	    			<option value="10" <?=($business->month == 10)?'selected':''?>>October</option>
	    			<option value="11" <?=($business->month == 11)?'selected':''?>>November</option>
	    			<option value="12" <?=($business->month == 12)?'selected':''?>>December</option>
	    		</select>
	    		<input type="number" id="bi_year" placeholder="Year" value="<?=$business->year?>">
	    	</div>
	    	<div class="slider-information-child step-3 hide" data-title="GENERAL BUSINESS PROFILE">
	    		<label class="question">How many business locations do you have ?</label>
	    		<input type="text" id="bi_locations" placeholder=". . ." value="<?=$business->locations?>">
	    	</div>
	    	<div class="slider-information-child step-4 hide" data-title="GENERAL BUSINESS PROFILE">
	    		<label class="question">What are addresses of these business locations ?</label>
	    		<div class="clearfix"></div>
	    		<ul id="bi_list_address">
	    			<?php 
	    				$business_locations = BusinessOption::findAll(['business_id'=>$business->id, 'tag'=>'locations', 'active'=>GlobalConstants::TRUE]);
	    				if($business->locations && $business_locations){
	    					foreach ($business_locations as $business_location) {
	    						echo '<li><input type="text" data-id="'.$business_location->id.'" value="'.$business_location->content.'" placeholder=". . ."></li>';
	    					}
	    					if(count($business_locations) < $business->locations)
	    						for($i = 0; $i < $business->locations-count($business_locations); $i++)
	    							echo '<li><input type="text" data-id="0" placeholder=". . ."></li>';	
	    				}else if($business->locations && !$business_locations)
	    					for($i = 0; $i < $business->locations; $i++)
	    						echo '<li><input type="text" data-id="0" placeholder=". . ."></li>';
	    				else
	    					echo '<li><input type="text" data-id="0" placeholder=". . ."></li>';
	    			?>
	    		</ul>	    	
	    	</div>
	    	<div class="slider-information-child step-5 hide" data-title="GENERAL BUSINESS PROFILE">
	    		<label class="question">What is your business hour ?</label>
	    		<div class="clearfix"></div>
	    		<ul id="bi_list_hour" class="<?=($business->always_open==GlobalConstants::TRUE)?'hide':''?>">
	    			<li>
	    				<?php
	    					$mon = BusinessHour::findOne(['business_id'=>$business->id, 'day'=>'Mon', 'active'=>GlobalConstants::TRUE]);	    					
	    				?>
	    				<strong>Mon</strong>
	    				<input type="text" class="time_open" value="<?=($mon && $mon->time_open)?$mon->time_open:$time_open?>" readonly>
	    				<i class="fa fa-long-arrow-right"></i>
	    				<input type="text" class="time_close" value="<?=($mon && $mon->time_close)?$mon->time_close:$time_close?>" readonly>
	    				<div class="ui-checkbox white clear">
			    			<input type="checkbox" id="chk-close-1" <?=($mon && $mon->status==GlobalConstants::TRUE)?'checked':''?>>
			    			<label for="chk-close-1">Close</label>
			    		</div>
	    			</li>
	    			<li>
	    				<?php
	    					$tue = BusinessHour::findOne(['business_id'=>$business->id, 'day'=>'Tue', 'active'=>GlobalConstants::TRUE]);	    					
	    				?>
	    				<strong>Tue</strong>
	    				<input type="text" class="time_open" value="<?=($tue && $tue->time_open)?$tue->time_open:$time_open?>" readonly>
	    				<i class="fa fa-long-arrow-right"></i>
	    				<input type="text" class="time_close" value="<?=($tue && $tue->time_close)?$tue->time_close:$time_close?>" readonly>
	    				<div class="ui-checkbox white clear">
			    			<input type="checkbox" id="chk-close-2" <?=($tue && $tue->status==GlobalConstants::TRUE)?'checked':''?>>
			    			<label for="chk-close-2">Close</label>
			    		</div>
	    			</li>
	    			<li>
	    				<?php
	    					$wed = BusinessHour::findOne(['business_id'=>$business->id, 'day'=>'Wed', 'active'=>GlobalConstants::TRUE]);	    					
	    				?>
	    				<strong>Wed</strong>
	    				<input type="text" class="time_open" value="<?=($wed && $wed->time_open)?$wed->time_open:$time_open?>" readonly>
	    				<i class="fa fa-long-arrow-right"></i>
	    				<input type="text" class="time_close" value="<?=($wed && $wed->time_close)?$wed->time_close:$time_close?>" readonly>
	    				<div class="ui-checkbox white clear">
			    			<input type="checkbox" id="chk-close-3" <?=($wed && $wed->status==GlobalConstants::TRUE)?'checked':''?>>
			    			<label for="chk-close-3">Close</label>
			    		</div>
	    			</li>
	    			<li>
	    				<?php
	    					$thu = BusinessHour::findOne(['business_id'=>$business->id, 'day'=>'Thu', 'active'=>GlobalConstants::TRUE]);	    					
	    				?>
	    				<strong>Thu</strong>
	    				<input type="text" class="time_open" value="<?=($thu && $thu->time_open)?$thu->time_open:$time_open?>" readonly>
	    				<i class="fa fa-long-arrow-right"></i>
	    				<input type="text" class="time_close" value="<?=($thu && $thu->time_close)?$thu->time_close:$time_close?>" readonly>
	    				<div class="ui-checkbox white clear">
			    			<input type="checkbox" id="chk-close-4" <?=($thu && $thu->status==GlobalConstants::TRUE)?'checked':''?>>
			    			<label for="chk-close-4">Close</label>
			    		</div>
	    			</li>
	    			<li>
	    				<?php
	    					$fri = BusinessHour::findOne(['business_id'=>$business->id, 'day'=>'Fri', 'active'=>GlobalConstants::TRUE]);	    					
	    				?>
	    				<strong>Fri</strong>
	    				<input type="text" class="time_open" value="<?=($fri && $fri->time_open)?$fri->time_open:$time_open?>" readonly>
	    				<i class="fa fa-long-arrow-right"></i>
	    				<input type="text" class="time_close" value="<?=($fri && $fri->time_close)?$fri->time_close:$time_close?>" readonly>
	    				<div class="ui-checkbox white clear">
			    			<input type="checkbox" id="chk-close-5" <?=($fri && $fri->status==GlobalConstants::TRUE)?'checked':''?>>
			    			<label for="chk-close-5">Close</label>
			    		</div>
	    			</li>
	    			<li>
	    				<?php
	    					$sat = BusinessHour::findOne(['business_id'=>$business->id, 'day'=>'Sat', 'active'=>GlobalConstants::TRUE]);	    					
	    				?>
	    				<strong>Sat</strong>
	    				<input type="text" class="time_open" value="<?=($sat && $sat->time_open)?$sat->time_open:$time_open?>" readonly>
	    				<i class="fa fa-long-arrow-right"></i>
	    				<input type="text" class="time_close" value="<?=($sat && $sat->time_close)?$sat->time_close:$time_close?>" readonly>
	    				<div class="ui-checkbox white clear">
			    			<input type="checkbox" id="chk-close-6" <?=($sat && $sat->status==GlobalConstants::TRUE)?'checked':''?>>
			    			<label for="chk-close-6">Close</label>
			    		</div>
	    			</li>
	    			<li>
	    				<?php
	    					$sun = BusinessHour::findOne(['business_id'=>$business->id, 'day'=>'Sun', 'active'=>GlobalConstants::TRUE]);	    					
	    				?>
	    				<strong>Sun</strong>
	    				<input type="text" class="time_open" value="<?=($sun && $sun->time_open)?$sun->time_open:$time_open?>" readonly>
	    				<i class="fa fa-long-arrow-right"></i>
	    				<input type="text" class="time_close" value="<?=($sun && $sun->time_close)?$sun->time_close:$time_close?>" readonly>
	    				<div class="ui-checkbox white clear">
			    			<input type="checkbox" id="chk-close-7" <?=($sun && $sun->status==GlobalConstants::TRUE)?'checked':''?>>
			    			<label for="chk-close-7">Close</label>
			    		</div>
	    			</li>
	    		</ul>
	    		<center>
		    		<div class="ui-checkbox white clear">
		    			<input type="checkbox" id="chk-always-open" <?=($business->always_open==GlobalConstants::TRUE)?'checked':''?>>
		    			<label for="chk-always-open">Always open</label>
		    		</div>
	    		</center><br>
	    	</div>
	    	<div class="slider-information-child step-6 hide" data-title="GENERAL BUSINESS PROFILE">
	    		<label class="question">What is the slogan of your business (if any) ?</label>
	    		<input type="text" id="bi_slogan" placeholder=". . ." value="<?=$business->slogan?>">
	    	</div>
	    	<div class="slider-information-child step-7 hide" data-title="GENERAL BUSINESS PROFILE">
	    		<label class="question">
	    			What are the  USPs of your business ?
	    			<span class="description">USP stands for Unique Selling Point which is the differential between your business from other rivals and communicates with customers that how your products or services are unique</span>
	    		</label>	    		
	    		<ul id="bi_list_usp">
	    			<?php
	    				$business_usp = BusinessOption::findAll(['business_id'=>$business->id, 'tag'=>'usp', 'active'=>GlobalConstants::TRUE]);
	    				if($business_usp) foreach ($business_usp as $usp) {
	    					echo '<li><input type="text" value="'.$usp->content.'" placeholder=". . ."></li>';
	    				}else{
	    			?>	    			
		    			<li><input type="text" placeholder=". . ."></li>
		    			<li><input type="text" placeholder=". . ."></li>
		    			<li><input type="text" placeholder=". . ."></li>
	    			<?php }?>
	    		</ul>
	    		<center><button class="btn btn-addmore-usp">Add more USP</button></center><br>
	    	</div>
	    	<div class="slider-information-child step-8 hide" data-title="GENERAL BUSINESS PROFILE">
	    		<label class="question">Please attach your business logo and/or banner (if any) in here</label>
	    		<div class="clearfix"></div><br><br>
	    		<img src="<?=$business->logo?>" id="bi_image_logo" class="<?=($business->logo)?$business->logo:'hide'?>"></img>
	    		<input type="file" id="bi_upload_logo"><label for="bi_upload_logo" class="btn btn-default">Upload Logo</label>	    		
	    		<img src="<?=$business->banner?>" id="bi_image_banner" class="<?=($business->banner)?$business->banner:'hide'?>"></img>
	    		<input type="file" id="bi_upload_banner"><label for="bi_upload_banner" class="btn btn-default">Upload Banner</label>
	    	</div>
	    	<div class="slider-information-child step-9 hide" data-title="GENERAL BUSINESS PROFILE">
	    		<label class="question">What is your business advertising budget annually ?</label>
	    		<input type="text" placeholder=". . ." id="bi_budget" value="<?=$business->budget?>">
	    	</div>
	    	<div class="slider-information-child step-10 hide" data-title="SERVICE PROFILE">
	    		<label class="question">Please write down primary services that your business offers with their average price respectively.</label>
	    		<table id="bi_primary_services">
	    			<thead>
	    				<tr>
	    					<th class="col-1">Primary services</th>
	    					<th class="col-2">Average price ($)</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				<?php 
	    					$primary_services = BusinessOption::findAll(['business_id'=>$business->id, 'tag'=>'primary_services', 'active'=>GlobalConstants::TRUE]);
	    					if($primary_services) foreach ($primary_services as $primary_service) {
		    					echo '<tr>
				    					<td class="col-1"><input type="text" value="'.$primary_service->name.'" placeholder="..."></td>
				    					<td class="col-2"><input type="text" value="'.$primary_service->content.'" placeholder="..."></td>
				    				</tr>';
		    				}else{
	    				?>
		    				<tr>
		    					<td class="col-1"><input type="text" placeholder="..."></td>
		    					<td class="col-2"><input type="text" placeholder="..."></td>
		    				</tr>
		    				<tr>
		    					<td class="col-1"><input type="text" placeholder="..."></td>
		    					<td class="col-2"><input type="text" placeholder="..."></td>
		    				</tr>
		    				<tr>
		    					<td class="col-1"><input type="text" placeholder="..."></td>
		    					<td class="col-2"><input type="text" placeholder="..."></td>
		    				</tr>
	    				<?php }?>
	    			</tbody>
	    		</table>
	    		<center><button class="btn btn-addmore-primary-services">Add more primary services</button></center><br>
	    	</div>
	    	<div class="slider-information-child step-11 hide" data-title="SERVICE PROFILE">
	    		<label class="question">What is the most in-demand service of your business ?</label>
	    		<input type="text" id="bi_in_demand_service" placeholder=". . ." value="<?=$business->in_demand_service?>">
	    	</div>
	    	<div class="slider-information-child step-12 hide" data-title="SERVICE PROFILE">
	    		<label class="question">Please indicate percentage between walk-in versus appointment</label>
	    		<ul>
	    			<li>Walk-in
	    				<div class="ui-input-format" data-format="%"><input type="number" id="bi_walk_in" placeholder="..." value="<?=$business->walk_in?>" required></div>
	    			</li>
	    			<li>Appointment
	    				<div class="ui-input-format" data-format="%"><input type="number" id="bi_appointment" placeholder="..." value="<?=$business->appointment?>" required></div>
	    			</li>
	    		</ul>	    		
	    	</div>
	    	<div class="slider-information-child step-13 hide" data-title="SERVICE PROFILE">
	    		<label class="question">
	    			Please indicate how busy your business is in percentage through each month of a year.
	    			<span class="description">
	    				0% - your business attracts no customers.<br>
	    				100% - your business can’t take any more customers
	    			</span>
	    		</label>
	    		<ul id="bi_list_percent_each_month">
	    			<?php 
	    				$business_questions = BusinessQuestion::findAll(['category_id'=> GlobalConstants::INDICATE_THE_DEMAND, 'active'=>GlobalConstants::TRUE]);	    				
	    				foreach ($business_questions as $index=>$business_question) {
	    					$business_has_question = BusinessHasQuestion::findOne(['question_id'=>$business_question->id, 'business_id'=>$business->id, 'active'=>GlobalConstants::TRUE]);
	    			?>
	    					<li>
    							<div class="col-1"><?=$business_question->name?></div>
    							<div class="col-2"><input type="text" data-id="<?=$business_question->id?>" placeholder="..." value="<?=($business_has_question)?$business_has_question->answer:''?>"><span>%</span></div>
    						</li>
    				<?php } ?>
	    		</ul>	    		
	    	</div>
	    	<div class="slider-information-child step-14 hide" data-title="SERVICE PROFILE">
	    		<label class="question">Do you currently have any marketing, advertising campaign or promotion program ?</label>
	    		<br><br>
	    		<center>
	    			<div class="ui-checkbox white">
		    			<input type="radio" id="bi_is_promotion_yes" name="chk-step14" <?=($business->is_promotion == GlobalConstants::TRUE)?'checked':''?>>
		    			<label for="bi_is_promotion_yes">Yes</label>
		    		</div>
		    		<div class="ui-checkbox white clear">
		    			<input type="radio" id="bi_is_promotion_no" name="chk-step14" <?=($business->is_promotion == GlobalConstants::FALSE)?'checked':''?>>
		    			<label for="bi_is_promotion_no">No</label>
		    		</div>	    		
		    		<div class="clearfix"></div><br>
		    		<div class="step14-enabled <?=($business->is_promotion == GlobalConstants::FALSE)?'hide':''?>">
		    			14.1: In a short description, please tell us about the current  campaigns with the percentage of discounts, terms and target customers. 
		    			<textarea><?=$business->promotion_description?></textarea>
	    			</div>
	    		</center>
	    	</div>
	    	<div class="slider-information-child step-15 hide" data-title="SERVICE PROFILE">
	    		<label class="question">Please select the most profitable holidays of your business.</label>
	    		<ul id="bi_list_holidays">
	    			<?php 
	    				$business_questions = BusinessQuestion::findAll(['category_id'=> GlobalConstants::PROFITABLE_HOLIDAYS, 'active'=>GlobalConstants::TRUE]);	    				
	    				foreach ($business_questions as $index=>$business_question) {
	    					$business_has_question = BusinessHasQuestion::findOne(['question_id'=>$business_question->id, 'business_id'=>$business->id, 'active'=>GlobalConstants::TRUE]);
	    			?>
	    					<li>
    							<div class="col-1"><?=$business_question->name?></div>
    							<div class="col-2">
    								<div class="ui-checkbox clear">
						    			<input type="checkbox" id="chk-step15-<?=$index?>" data-id="<?=$business_question->id?>" <?=($business_has_question && $business_has_question->answer == GlobalConstants::TRUE)?'checked':''?>>
						    			<label for="chk-step15-<?=$index?>"></label>
						    		</div>    								
    							</div>
    						</li>
    				<?php } ?>
	    		</ul>	    		
	    	</div>
	    	<div class="slider-information-child step-16 hide" data-title="CUSTOMERS PROFILE">
	    		<label class="question">What is the percentage of each gender of your target customer</label>
	    		<ul>
	    			<li>Male
	    				<div class="ui-input-format" data-format="%"><input type="number" id="bi_male" placeholder="..." value="<?=$business->male?>"></div>
	    			</li>
	    			<li>Female
	    				<div class="ui-input-format" data-format="%"><input type="number" id="bi_female" placeholder="..." value="<?=$business->female?>"></div>
	    			</li>
	    		</ul>	    		
	    	</div>
	    	<div class="slider-information-child step-17 hide" data-title="CUSTOMERS PROFILE">
	    		<label class="question">What is the percentage of each age group of your target customer ?</label>
	    		<ul id="bi_target_customers">
	    			<?php 
	    				$business_questions = BusinessQuestion::findAll(['category_id'=> GlobalConstants::TARGET_CUSTOMER, 'active'=>GlobalConstants::TRUE]);	    				
	    				foreach ($business_questions as $index=>$business_question) {
	    					$business_has_question = BusinessHasQuestion::findOne(['question_id'=>$business_question->id, 'business_id'=>$business->id, 'active'=>GlobalConstants::TRUE]);
	    			?>
	    					<li><?=$business_question->name?>
	    						<div class="ui-input-format" data-format="%"><input type="number" data-id="<?=$business_question->id?>" value="<?=($business_has_question)?$business_has_question->answer:''?>" placeholder="..."></div>
							</li>
					<?php } ?>
	    		</ul>	    		
	    	</div>
	    	<div class="slider-information-child step-18 hide" data-title="CUSTOMERS PROFILE">
	    		<label class="question">What is the percentage of each customer relationship status in your business ?</label>
	    		<ul id="bi_customer_relationships">
	    			<?php 
	    				$business_questions = BusinessQuestion::findAll(['category_id'=> GlobalConstants::CUSTOMER_RELATIONSHIP, 'active'=>GlobalConstants::TRUE]);	    				
	    				foreach ($business_questions as $index=>$business_question) {
	    					$business_has_question = BusinessHasQuestion::findOne(['question_id'=>$business_question->id, 'business_id'=>$business->id, 'active'=>GlobalConstants::TRUE]);
	    			?>
	    					<li><?=$business_question->name?>
	    						<div class="ui-input-format" data-format="%"><input type="number" data-id="<?=$business_question->id?>" value="<?=($business_has_question)?$business_has_question->answer:''?>" placeholder="..."></div>
							</li>
					<?php } ?>
	    		</ul>	    		
	    	</div>
	    	<div class="slider-information-child step-19 hide" data-title="CUSTOMERS PROFILE">
	    		<label class="question">In the business industry, what is your customer segment level ?</label>
	    		<ul>
	    			<li>
	    				<div class="ui-radio white">
			    			<input type="radio" id="chk-step19-1" value="1" name="bi_segment_level" <?=($business->segment_level == 1)?'checked':''?>>
			    			<label for="chk-step19-1">High-end customer</label>
			    		</div>
	    			</li>
	    			<li>
	    				<div class="ui-radio white">
			    			<input type="radio" id="chk-step19-2" value="2" name="bi_segment_level" <?=($business->segment_level == 2)?'checked':''?>>
			    			<label for="chk-step19-2">Medium-end customer</label>
			    		</div>
	    			</li>
	    			<li>
	    				<div class="ui-radio white">
			    			<input type="radio" id="chk-step19-3" value="3" name="bi_segment_level" <?=($business->segment_level == 3)?'checked':''?>>
			    			<label for="chk-step19-3">Low-end customer</label>
			    		</div>
	    			</li>
	    		</ul>	    		
	    	</div>
	    	<div class="slider-information-child step-20 hide" data-title="CUSTOMERS PROFILE">
	    		<label class="question">What is major purchasing behavior of your target customers (if any) ?</label>
	    		<textarea id="bi_purchasing_behavior"><?=$business->purchasing_behavior?></textarea>
	    	</div>
	    	<div class="slider-information-child step-21 hide" data-title="INDUSTRY SPECIFY">
	    		<label class="question">This is list other questions. But we will ask you in the future :)</label>
	    	</div>
	    	<div class="slider-information-child step-22 hide" data-title="CUSTOMERS PROFILE">
	    		<div>
	    			<h1>THANK YOU !!!</h1>
	    			<p>This is the end of the Business Profile Questionnaire.</p>
					<p>Once again, we promise to protect your privacy and the information as confidential.</p>
					<p>Thank you very much for your kind cooperation.</p>
					<button>Go to NIM Marketing Dashboard</button>
	    		</div>
	    	</div>
	    	<div class="clearfix"></div><br>
	    	<div class="alert"><p></p></div>
	    </div>
    </div>
</body>
