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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <!-- <link rel="stylesheet" href="../themes/fiori/assets/css/base.min.css"> -->

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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

        <?= $this->render('header', ['bundle' => $bundle]) ?>

        <?php // $this->render('sidebar_fiori')  ?>

        <?= $this->render('content', ['bundle' => $bundle, 'content' => $content]) ?>


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
                            <p>Total Users:
                                <strong><?= isset($app_data->ga_total_users)?\common\helpers\Utility::numberIndiaStyle($app_data->ga_total_users):'&nbsp;'?></strong>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Total
                                Pageviews:
                                <strong><?= isset($app_data->ga_total_pageviews)?\common\helpers\Utility::numberIndiaStyle($app_data->ga_total_pageviews):'&nbsp;'?></strong>
                            </p>
                            <p>Last Updated on : <?=date("l", strtotime($app_data->ga_last_updated_on))?>,
                                <strong><?=date("M d Y h:i A", strtotime($app_data->ga_last_updated_on))?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php $this->render('footer_fiori') ?>
    <?php $this->endBody() ?>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"></script>
     DataTables
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.10.19/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js" crossorigin="anonymous"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js" crossorigin="anonymous"></script>-->


    <script>
    $("#works-carousel").owlCarousel({
        items: 1,
        center: true,
        smartSpeed: 650
    });
    </script>
    <!-- <script>
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        margin: 5,
        responsive: {
            320: {
                items: 1
            },

            575: {
                items: 1
            },

            767: {
                items: 2
            },

            991: {
                items: 3
            },

            1200: {
                items: 6
            }
        }
    });
    </script> -->

    <script>
    $(document).ready(function() {

        $('#mobile-toggle').click(function() {

            $('.mobiele-ne').toggleClass('show');
            $('.custom-cont').toggleClass('custom-cont-2');

        })
    })
    </script>

</body>

</html>
<?php $this->endPage() ?>