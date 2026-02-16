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
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
        <meta name="description" content="This is an example dashboard created using build-in elements and components.">
        <!-- Disable tap highlight on IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <link href="https://fonts.googleapis.com/css2?family=Grenze:wght@400&display=swap" rel="stylesheet">

        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <section id="mobile_page">

            <!---App login here--->
            <section class="home_page">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="login_page">
                                <div class="logo_content">
                                    <h3>UTTAR PRADESH STATE RURAL LIVELIHOOD MISSION</h3>
                                </div>
                                <div class="home_logo d-flex justify-content-between">
                                    <div class="logo">
                                        <img src="<?=$bundle->baseUrl?>/images/logo.png" class="img-fluid" alt="upslrm">
                                    </div>
                                    <div class="logo_content">
                                        <h5>Department of Rural Development</h5>
                                        <p>Goverment Of Uttar pradesh</p>
                                    </div>
                                    <div class="logo">
                                        <img src="<?=$bundle->baseUrl?>/images/logo_up.png" class="img-fluid" alt="upslrm">
                                    </div>
                                </div>

                                <?= $this->render('content', ['content' => $content]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>

        <?php $this->endBody() ?>


    </body>
</html>
<?php $this->endPage() ?>
