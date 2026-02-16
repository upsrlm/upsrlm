<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use common\assets\FioriAsset;

$bundle = FioriAsset::register($this);
$app_data = \common\models\ApplicationData::findOne(1);
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

            <?php

            use common\models\master\MasterRole;
            ?>  
            <div class="header_primary">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2 col-12">
                            <div class="header_primary_logo">
                                <a href="#"><img src="<?= $bundle->baseUrl ?>/images/logo.png" class="img-fluid" alt=""> </a>
                            </div>
                        </div>
                        <div class="col-sm-8 col-12">
                            <div class="header_primary_logo_text">
                                <h4>UTTAR PRADESH STATE RURAL LIVELIHOOD MISSION</h4>
                                <h6>Department of Rural Development</h6>
                                <p>Government Of Uttar Pradesh</p>
                            </div>
                        </div>


                        <div class="col-sm-2 col-12">
                            <div class="right_nav">
                                <a href="#"> <img src="<?= $bundle->baseUrl ?>/images/logo_up.png" class="img-fluid" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="app-container app-theme-white">
                                




                              
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        <!-- <section class="home_banner"></section>-->



<?= $this->render('content', ['bundle' => $bundle, 'content' => $content]) ?>




        </div>
        <footer class="footer">
            <!--            <div class="container-fluid">
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
                                            <p>Total Users: <strong><?= isset($app_data->ga_total_users) ? \common\helpers\Utility::numberIndiaStyle($app_data->ga_total_users) : '&nbsp;' ?></strong>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Total Pageviews: <strong><?= isset($app_data->ga_total_pageviews) ? \common\helpers\Utility::numberIndiaStyle($app_data->ga_total_pageviews) : '&nbsp;' ?></strong></p>
                                            <p>Last Updated on : <?= date("l", strtotime($app_data->ga_last_updated_on)) ?>, <strong><?= date("M d Y h:i A", strtotime($app_data->ga_last_updated_on)) ?></strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
        </footer>
        <?php $this->render('footer_fiori') ?>
<?php $this->endBody() ?>


    </body>
</html>
<?php $this->endPage() ?>
