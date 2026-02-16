<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use common\assets\FioriAsset;

$assetDir = FioriAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />

        <!-- Disable tap highlight on IE -->
        <meta name="msapplication-tap-highlight" content="no">

        <!-- <link rel="stylesheet" href="../themes/fiori/assets/css/base.min.css"> -->

        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

 <div class="app-container app-theme-white">

    <?= $this->render('header',['bu']) ?>

    <?php // $this->render('sidebar_fiori') ?>
   
    <?= $this->render('content', ['content' => $content]) ?>
   

    <!-- Main Footer -->
    
</div>
    <footer class="footer">
        <div class="container-fluid">
            <div class="footer_primary">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="footer_left">
                            <p>Facilitated by Department of Rural Development, </p>
                            <p>Government of Uttar Pradesh</p>
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="footer_right">
                              <p>Total Users: <strong>19,495</strong>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Total Pageviews: <strong>11,64,264</strong></p>
                            <p>Last Updated on : Saturday, <strong> Jan 21 2021 11:30AM</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </footer>
<?php $this->render('footer_fiori') ?>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>