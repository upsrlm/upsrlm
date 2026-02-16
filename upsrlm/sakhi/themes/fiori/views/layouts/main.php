<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use common\assets\FiroriAppAsset;

$bundle = FiroriAppAsset::register($this);
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body style="font-size: 1.5rem">
        <?php $this->beginBody() ?>

        <section id="mobile_page">
            <!---App nav starts here--->
<!--            <div class="mobilemenu_section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-3">
                            <div id="mySidenav" class="sidenav">
                                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                                <a href="/site/logout">Logout</a>

                            </div>
                            <span style="font-size:25px;cursor:pointer" onclick="openNav()">&#9776; </span>
                        </div>
                        <div class="col-6">
                            <div class="logo_text">
                                <h4>Upsrlm-C.B.O</h4>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="m_logo">
                                <img src="<?= $bundle->baseUrl ?>/images/logo_up.png" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div> 
            </div>-->
            <?php \sakhi\components\widgets\CarouselmenuWidget::widget(['theme_base_url' => $bundle->baseUrl]) ?>

            <?= $this->render('content', ['content' => $content]) ?>


        </section>
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }
        </script>

        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>