<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Ticket;

$this->title = 'Support';
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-support.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div id="inner">
                <div class="tickets-box">
                    <div class="title">
                        <h1>tickets</h1>                        
                        <input class="txt-search" id="txt-ticket-search" name="search" placeholder="Search tickets ..."/>                        
                    </div>
                    <ul id="list-tickets">
                        <?php
                            $tickets = Ticket::find()->where(['client_id'=>Yii::$app->user->identity->current_client, 'active'=>GlobalConstants::TRUE])->limit(0, 10)->all();
                            foreach ($tickets as $key => $ticket) {
                        ?>
                                <li>
                                    <a href="/supperadmin/ticketdetail/<?=$ticket->id?>" title=""><?=$ticket->name?></a>
                                    <div class="clearfix"></div>
                                    <span class="datetime">On <?=Date('d/m/Y', strtotime($ticket->create_date))?> at <?=Date('g:i A', strtotime($ticket->create_date))?></span>
                                    <span class="status <?=($ticket->status == GlobalConstants::TRUE)?'':'closed'?>"><?=($ticket->status == GlobalConstants::TRUE)?'Open Ticket':'Close Ticket'?></span>
                                    <?php if($ticket->respond == GlobalConstants::TRUE)
                                            echo '<span class="respond">Respond</span>';
                                    ?>
                                </li>        
                        <?php }?>                        
                    </ul>
                    <div class="clearfix"></div>
                    <?php                        
                        if($total_ticket && $total_ticket > 10)
                            echo '<button class="btn btn-loadmore-ticket">Load more...</button>';
                    ?>
                    <img class="loading-effect hide" src="<?=Yii::getAlias('@web')?>/images/vnloader-sm.GIF">
                </div>
            </div>
        </div>        
    </div>
    <!-- /CONTENT -->
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>