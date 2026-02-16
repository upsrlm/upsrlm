<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use common\assets\Bcsakhi;
$bundle=Bcsakhi::register($this);
// use kartik\icons\FontAwesomeAsset;
// FontAwesomeAsset::register($this)

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Language" content="en">
        <meta name="description" content="BC Sakhi">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />

        <!-- Disable tap highlight on IE -->
        <meta name="msapplication-tap-highlight" content="no">

        <!-- <link rel="stylesheet" href="../assets/css/base.min.css"> -->
        <link rel="icon" href="/images/favicon.ico" />
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php $this->registerCsrfMetaTags() ?>
        <title>BC Sakhi : <?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body >
      
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->
        <?php
        if (isset(Yii::$app->params['track_google_analytics']) and Yii::$app->params['track_google_analytics'])
            echo kartik\social\GoogleAnalytics::widget([
                'trackerConfig' => [
                    'user_id' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->id : "0",
                ]
                    ]
            );
        ?>
        <?php $this->beginBody() ?>

        <div class="app-container app-theme-white">

            <!-- Navbar -->
            <?= $this->render('header', ['bundle' => $bundle]) ?>
            <?= $this->render('menu', ['bundle' => $bundle]) ?>

            <!-- Content Wrapper. Contains page content -->
            <?= $this->render('content', ['content' => $content, 'bundle' => $bundle]) ?>
            <?= $this->render('footer', ['bundle' => $bundle]) ?>

        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
