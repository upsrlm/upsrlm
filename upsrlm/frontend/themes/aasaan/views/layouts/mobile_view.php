<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AasaanAppAsset;
use app\assets\AdminAsset;
use kartik\widgets\AlertBlock;
use app\models\UserModel;

$bundle = app\assets\MobileAppAsset::register($this);
AdminAsset::register($this);
$arg = explode('/', Yii::$app->request->url);
$url = explode('/', Yii::$app->request->url);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="utf-8" />
        <title>End Poverty</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>
    <body class="no-skin" >
        <?php $this->beginBody() ?>
        <header id="topnav">
  
        </header>
        <div class="wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">

                        <div class="content">
                            <?= $content ?>                                  
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->

            </div>
        </div>
        <!-- end wrapper -->

        <?php $this->endBody() ?>



    </body>
</html>
<?php $this->endPage(); ?>

