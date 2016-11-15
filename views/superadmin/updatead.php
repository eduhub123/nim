<?php
/* @var $this yii\web\View */
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Ads;

$this->title = 'Update AD';
?>
<body>  
    <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/lib/colorpicker/css/colorpicker.css">
    <script src='<?=Yii::getAlias('@web')?>/lib/colorpicker/js/colorpicker.js'></script>
    <div id="header" class="inner">
        <div class="logo-function"><img src="<?=Yii::getAlias('@web')?>/images/icon-ads.png" alt=""></div>
        <?php include 'header.php';?>
    </div>
    <!-- CONTENT -->
    <div id="content">
        <div class="container">
            <div id="inner">
                <div class="management-box">
                    <div class="title">
                        <h1>Update AD</h1>                        
                    </div>
                    <form method="post" id="update-ad-form" novalidate>
                        <input type="hidden" name="id" id="ad-id" value="<?=$modal->id?>">
                        <ul class="management-form">
                            <li>
                                <label>AD Name</label>
                                <input type="text" name="name" class="form-control" value="<?=$modal->name?>" required/>
                            </li>
                            <li>
                                <label>Parent AD</label>
                                <select class="form-control" name="parent_id">
                                    <option value="">Root</option>
                                    <?php $parents = Ads::findAll(['parent_id'=>'', 'active'=>GlobalConstants::TRUE]);
                                        foreach ($parents as $parent) {
                                            if($parent->id == $modal->parent_id)
                                                echo '<option value="'.$parent->id.'" selected>'.$parent->name.'</option>';
                                            else
                                                echo '<option value="'.$parent->id.'">'.$parent->name.'</option>';
                                        }
                                    ?>
                                </select>
                            </li>
                            <li class="col-4">
                                <label>Color</label>
                                <div class="nim-colorpicker">
                                    <input type="text" id="service-color" name="color" class="form-control" value="<?=$modal->color?>" required/>
                                    <span style="background-color: <?=$modal->color?>"></span>
                                </div>
                            </li>
                            <li>
                                <label>Icon</label>
                                <input type="text" name="icon" class="form-control" value="<?=$modal->icon?>"/>                                
                            </li>
                            <li>
                                <label>AD Description</label>
                                <textarea id="ad-description" name="description" class="form-control"><?=$modal->description?></textarea>
                            </li>
                            <li>
                                <div class="alert"><p></p></div>
                                <button class="btn btn-submit" type="submit">Submit</button>
                            </li>
                        </ul>
                    </form>
                    <script src="<?=Yii::getAlias('@web')?>/lib/ckeditor/ckeditor.js" type="text/javascript"></script>
                    <script type="text/javascript">    
                        if (typeof (CKEDITOR.instances.text) != "undefined") {
                            CKEDITOR.instances.Content.destroy();
                            
                            var ad_editor = CKEDITOR.replace('ad-description',
                            { customConfig: '<?=Yii::getAlias('@web')?>/lib/ckeditor/config.js',            
                                language: 'en'
                            });
                                    }
                                    else {
                                        var ad_editor = CKEDITOR.replace('ad-description',
                            { customConfig: '<?=Yii::getAlias('@web')?>/lib/ckeditor/config.js',
                                language: 'en'
                            });
                        }
                    </script>
                </div>
            </div>
        </div>        
    </div>
    <!-- /CONTENT -->
    <a href="/superadmin/adsmanagement" class="btn-right-side" data-text="Back to Services"><i class="fa fa-undo" style="font-size: 28px"></i></a>
    <a href="/" class="btn-back-home"><i class="fa fa-home"></i></a>
</body>