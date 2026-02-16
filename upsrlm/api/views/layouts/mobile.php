<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\assets\FioriAsset;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;
use common\models\master\MasterRole;

/* @var $this \yii\web\View */
/* @var $content string */

$bundel = FioriAsset::register($this);
$bundelbc = bc\assets\FioriAsset::register($this);
$arg = explode('/', Yii::$app->request->url);
$url = explode('/', Yii::$app->request->url);
//print_r($url);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Disable tap highlight on IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>

    <body>
        <?php $this->beginBody() ?>  
        <div class="app-container app-theme-white app-fluid-container">

            <div class="app-main">
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="app-inner-layout app-inner-layout-page">

                            <div class="app-inner-layout__wrapper">

                                <div class="app-inner-layout__content">

                                    <div class="tab-content">
                                        <div class="container fiori-container">

                                            <?= $content ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="container fiori-container">
                                <div class="app-footer__inner">
                                    <div class="app-footer-left">

                                    </div>
                                    <div class="app-footer-right">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>

        </div>

        <div class="app-drawer-overlay d-none animated fadeIn"></div><!--DRAWER END-->


        <?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>