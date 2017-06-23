<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Ticket;
use app\models\TicketRelationship;

$this->title = 'Support Detail';
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-support.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div class="ticket-detail">
                <div class="title">
                    <h1><?=$modal->name?></h1>
                    <div class="clearfix"></div>
                    <strong><?=$modal->getAuthor()->firstname.' '.$modal->getAuthor()->lastname?></strong> opened this issue on <?=Date('d/m/Y', strtotime($modal->create_date))?> at <?=Date('g:i A', strtotime($modal->create_date))?> - 3 comments
                    <span class="status <?=($modal->status == GlobalConstants::TRUE)?'':'closed'?>"><?=($modal->status == GlobalConstants::TRUE)?'Open Ticket':'Close Ticket'?></span>
                </div>
                <ul class="list-comments">
                    <?php $ticket_list = TicketRelationship::findAll(['ticket_id'=>$modal->id, 'active'=>GlobalConstants::TRUE]);
                        foreach ($ticket_list as $key => $item) {?>
                            <li>
                                <div class="avatar"><?=$item->getUser()->firstname[0]?>
                                    <?php if($item->getUser()->avatar) echo '<img src="images/avatar.png" alt="">'?>                                    
                                </div>
                                <?=$item->content?>
                                <div class="clearfix"></div>
                                <span class="datetime"><strong><?=$item->getUser()->firstname.' '.$item->getUser()->lastname?></strong> commented on <?=Date('d/m/Y', strtotime($modal->create_date))?>, at <?=Date('g:i A', strtotime($modal->create_date))?></span>
                            </li>
                    <?php }?>
                </ul>
                <div class="box-comment">
                    <form id="form-reply-feedback">
                        <input type="hidden" name="id" value="<?=$modal->id?>">
                        <textarea class="form-control" id="ticket-content" required></textarea>
                        <div class="clearfix"></div><br>
                        <button class="btn btn-send" type="submit">Send</button>
                        <div class="alert"><p></p></div>
                    </form>                    
                </div>
                <script src="<?=Yii::getAlias('@web')?>/lib/ckeditor/ckeditor.js" type="text/javascript"></script>       
                <script type="text/javascript">    
                    if (typeof (CKEDITOR.instances.text) != "undefined") {
                        CKEDITOR.instances.Content.destroy();
                        
                        var ticket_editor = CKEDITOR.replace('ticket-content',
                        { customConfig: 'lib/ckeditor/config.js',            
                            language: 'en'
                        });
                    }else {
                        var ticket_editor = CKEDITOR.replace('ticket-content',
                        { customConfig: 'lib/ckeditor/config.js',
                            language: 'en'
                        });
                    }
                </script>
            </div><!-- /ticket-detail -->
        </div>
    </div>
    <!-- /CONTENT -->
    <a href="/superadmin/support" class="btn-right-side" data-text="Back to Support"><i class="fa fa-undo" style="font-size: 28px"></i></a>
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>