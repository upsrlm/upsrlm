<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use sakhi\components\MobileDetect;

$arg = explode('/', Yii::$app->request->url);
$url = explode('/', Yii::$app->request->url);
$mobile = new MobileDetect();
if ($mobile->isAndroidOS()) {
//     echo 'a';
} else {
//    echo 'desktop';
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="description" content="Autofill">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="mod-bg-1 mod-nav-link ">
        <?php $this->beginBody() ?>

        <div class="page-wrapper">
            <div class="page-inner">

                <div class="page-content-wrapper">

                    <main id="js-page-content" role="main" class="page-content">


                        <div class="row">
                            <div class="col-xl-12">


                                <?= $content ?>   
                            </div>
                        </div>
                    </main>
                    <!-- this overlay is activated only when mobile menu is triggered -->



                </div>
            </div>
        </div>
        <!-- END Page Wrapper -->


        <?php $this->endBody() ?>
    </body>
</html>

<?php $this->endPage(); ?>