<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Ads;
use app\models\AdAssignment;
use app\models\AdsType;

$this->title = 'Marketing Calendar';
?>
<body>  
    <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/css/bootstrap-datetimepicker.min.css">
    <script src="<?=Yii::getAlias('@web')?>/js/moment.min.js" type="text/javascript"></script>
    <script src="<?=Yii::getAlias('@web')?>/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-marketing-calendar.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <div id="content">
        <div class="container-fluid">
            <br><br>
            <div class="row marketing-calendar">
                <div class="col-md-6">
                    <div class="ui-calendar management" data-date="<?=date('m/d/Y')?>">
                        <div class="calendar-bar">
                            <button class="arrow previous"><i class="fa fa-angle-left"></i></button>                            
                            <center><strong>N/A</strong></center>
                        </div>
                        <div class="clearfix"></div>
                        <ul class="calendar-header">
                            <li>Sun</li>
                            <li>Mon</li>
                            <li>Tues</li>
                            <li>Wed</li>
                            <li>Thu</li>
                            <li>Fri</li>
                            <li>Sat</li>                    
                        </ul>
                        <div class="clearfix"></div>
                        <ul class="calendar-content">
                            <li class="clear-left"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>

                            <li class="clear-left">
                            </li>                   
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>

                            <li class="clear-left"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>

                            <li class="clear-left"></li>
                            <li></li>
                            <li class="up"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>

                            <li class="clear-left"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>

                            <li class="clear-left"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div><!-- /ui-calendar -->
                </div>
                <div class="col-md-6 clear">
                    <div class="ui-calendar management" data-date="<?=date('m/d/Y', strtotime('+1 month'))?>">
                        <div class="calendar-bar">                          
                            <button class="arrow next"><i class="fa fa-angle-right"></i></button>
                            <center><strong>N/A</strong><!-- <span>2016</span> --></center>
                        </div>
                        <div class="clearfix"></div>
                        <ul class="calendar-header">
                            <li>Sun</li>
                            <li>Mon</li>
                            <li>Tues</li>
                            <li>Wed</li>
                            <li>Thu</li>
                            <li>Fri</li>
                            <li>Sat</li>                    
                        </ul>
                        <div class="clearfix"></div>
                        <ul class="calendar-content">
                            <li class="clear-left"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>

                            <li class="clear-left">
                            </li>                   
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>

                            <li class="clear-left"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>

                            <li class="clear-left"></li>
                            <li></li>
                            <li class="up"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>

                            <li class="clear-left"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>

                            <li class="clear-left"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div><!-- /ui-calendar -->
                </div>
            </div>
        </div>
    </div>
    <div class="md-modal" id="addnew-calendar">
        <h1>Choise Ad Type or Marketing Activities</h1>
        <i class="fa fa-trash-o btn-remove-plan hide" title="Remove Plan to Calendar"></i>
        <ul class="list-form">
            <li>
                <select class="select-type-marketing">
                    <?php
                        $ads_types = AdsType::findAll(['active'=>GlobalConstants::TRUE]);
                        foreach ($ads_types as $index => $ads_type) {
                    ?>                
                        <option value="<?=$ads_type->id?>"><?=$ads_type->name?></option>
                    <?php }?>
                </select>
            </li>
            <li class="col-2"><span>Start Date:</span> <input type="text" class="input-datepicker start_date" value="<?=date('m-d-Y')?>"></li>
            <li class="col-2"><span>End Date:</span> <input type="text" class="input-datepicker end_date" value="<?=date('m-d-Y')?>"></li>
            <li>
                <div class="ad-autocomplete">
                    <input class="form-control" placeholder="Type in Ad Name / Marketing Activities"/>
                    <ul></ul>
                </div>
            </li>
        </ul>        
        <ul class="list-add"></ul>
        <div class="alert"><p>Opps</p></div><br>
        <div class="md-footer">
            <button class="btn btn-submit">Submit</button>
            <button class="btn btn-cancel">Cancel</button>
        </div>
    </div><!-- /video-play -->
    <div id="darkness"></div>
    <a href="#" class="btn-right-side addnew-calendar-plan" data-text="Add new"><span class="fi">+</span></a>
    <a href="/" class="btn-back-home active"><i class="fa fa-home"></i></a>
</body>