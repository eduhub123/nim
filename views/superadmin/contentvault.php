<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\ContentVault;

$this->title = 'Content Vault';
?>
<body>  
    <div id="header" class="inner">
        <div class="logo-function"><img src="/images/icon-content-vault.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div class="content-vault">
                <h1 class="big-title">Images <button class="btn btn-open-add-image">Add Image</button></h1>
                <div class="list-images content-vault-images">
                    <?php 
                        $images = ContentVault::find()->where(['client_id'=>Yii::$app->user->identity->current_client, 'type'=> GlobalConstants::IMAGE_TYPE, 'active' => GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->all();
                        foreach ($images as $image) {?>
                            <figure data-id="<?=$image->id?>">
                                <a class="box-img">
                                    <img src="<?=$image->url?>" itemprop="thumbnail" alt="<?=$image->name?>" />
                                </a>
                                <input type="text" value="<?=$image->name?>">
                                <button class="btn-remove">Remove</button>
                            </figure>
                    <?php }?>
                </div>
                <div class="clearfix"></div>
                <h1 class="big-title">Videos <button class="btn btn-open-add-video">Add Video</button></h1>
                <ul class="list-images content-vault-videos">
                    <?php 
                        $videos = ContentVault::find()->where(['client_id'=>Yii::$app->user->identity->current_client, 'type'=> GlobalConstants::VIDEO_TYPE, 'active' => GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->all();
                        foreach ($videos as $video) {                            
                    ?>
                            <li data-id="<?=$video->id?>">                                
                                <div class="box-img video" data-id="<?=$video->url?>" data-time="<?=GlobalFunctions::convertTime($video->url)?>"><img src="http://img.youtube.com/vi/<?=$video->url?>/0.jpg" alt=""></div>
                                <label><?=$video->name?></label>
                                <button class="btn-remove">Remove</button>
                            </li>
                    <?php }?>
                </ul>

                <div class="clearfix"></div>
                <h1 class="big-title">Articles <button class="btn btn-open-add-article">Add Article</button></h1>
                <div class="panel-group faq-accordion content-vault-articles" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php 
                        $articles = ContentVault::find()->where(['client_id'=>Yii::$app->user->identity->current_client, 'type'=> GlobalConstants::ARTICLE_TYPE, 'active' => GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->all();
                        foreach ($articles as $article) {?>
                            <div class="panel panel-default" data-id="<?=$article->id?>">
                                <div class="panel-heading" role="tab" id="heading<?=$article->id?>">
                                  <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$article->id?>" aria-expanded="false" aria-controls="collapse<?=$article->id?>">
                                      <span><?=$article->name?></span>
                                      <button class="btn-remove">Remove</button><button class="btn-edit">Edit</button>
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapse<?=$article->id?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$article->id?>">
                                  <div class="panel-body">
                                    <div class="text-inner">
                                        <?=$article->description?>                                        
                                    </div>
                                  </div>
                                </div>
                            </div>
                    <?php }?>                  
                </div>
            </div>
        </div>      
    </div>
    <!-- /CONTENT -->
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
    <div class="md-modal" id="video-play">
        <span class="close">&times;</span>
        <iframe src="#" allowfullscreen></iframe>
    </div><!-- /video-play -->
    <div class="md-modal" id="modal-image-upload">
        <span class="close">&times;</span>
        <h1 class="title">Add New Image</h1>
        <form id="form-addnew-image" novalidate>
            <ul class="list-form">
                <li>
                    <strong>Image Name</strong>
                    <input class="form-control" name="name" required>
                </li>
                <li>
                    <strong>Image File Upload</strong>
                    <input type="file" name="url" class="form-control" accept=".jpg,.jpge,.png,.gif" required>
                </li>
                <li>
                    <div class="alert"><p></p></div>
                    <center><button type="submit" class="btn">Submit</button></center>
                </li>
            </ul>            
        </form>
    </div><!-- /modal-image-upload -->
    <div class="md-modal" id="modal-video-upload">
        <span class="close">&times;</span>
        <h1 class="title">Add New Video</h1>
        <form id="form-addnew-video" novalidate>
            <ul class="list-form">
                <li>
                    <strong>Youtube Code</strong>
                    <input class="form-control" name="url" required>
                </li>
                <li>
                    <div class="alert"><p></p></div>
                    <center><button type="submit" class="btn">Submit</button></center>
                </li>
            </ul>            
        </form>
    </div><!-- /modal-video-upload -->
    <div class="md-modal" id="modal-article">
        <span class="close">&times;</span>
        <h1 class="title">Add New Article</h1>
        <form id="form-addnew-article" novalidate>
            <ul class="list-form">
                <li>
                    <strong>Title</strong>
                    <input class="form-control" name="name" required>
                    <input type="hidden" name="id">
                </li>
                <li>
                    <strong>Content</strong>
                    <textarea id="article-content"></textarea>
                </li>
                <li>
                    <div class="alert"><p></p></div>
                    <center><button type="submit" class="btn">Submit</button></center>
                </li>
            </ul>            
        </form>
    </div><!-- /modal-article -->
    <div id="darkness"></div>
    <script src="<?=Yii::getAlias('@web')?>/lib/ckeditor/ckeditor.js" type="text/javascript"></script>       
    <script type="text/javascript">    
        if (typeof (CKEDITOR.instances.text) != "undefined") {
            CKEDITOR.instances.Content.destroy();
            
            var article_editor = CKEDITOR.replace('article-content',
            { customConfig: 'lib/ckeditor/config.js',            
                language: 'en'
            });
        }else {
            var article_editor = CKEDITOR.replace('article-content',
            { customConfig: 'lib/ckeditor/config.js',
                language: 'en'
            });
        }
    </script>
</body>