<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\FioriAppAsset;

// \hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
// $this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');
FioriAppAsset::register($this);
$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Language" content="en">
        <meta name="description" content="UPSRLM">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />

        <!-- Disable tap highlight on IE -->
        <meta name="msapplication-tap-highlight" content="no">

        <!-- <link rel="stylesheet" href="../assets/css/base.min.css"> -->

        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php $this->registerCsrfMetaTags() ?>
        <title>UPSRLM : <?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
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
            <?= $this->render('navbar', ['assetDir' => $assetDir]) ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>

            <!-- Content Wrapper. Contains page content -->
            <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <?= $this->render('control-sidebar') ?>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <?= $this->render('footer') ?>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
