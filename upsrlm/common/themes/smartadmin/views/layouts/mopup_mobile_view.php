<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\assets\SmartAdminSumupAppAsset;
use yii\widgets\Breadcrumbs;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;
use mopup\components\MobileDetect;

$bundle = SmartAdminSumupAppAsset::register($this);
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
<html lang="<?= Yii::$app->language ?>" class="root-text-xl">
    <head>
        <?php
        if (isset(Yii::$app->params['track_google_analytics']) and Yii::$app->params['track_google_analytics'])
            echo kartik\social\GoogleAnalytics::widget([
                'trackerConfig' => [
                    'userId' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->id : "0",
                ]
                    ]
            );
        ?>
        <meta charset="utf-8" />
        <meta name="description" content="UPSRLM SUMUP">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="format-detection" content="telephone=yes">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= $bundle->baseUrl ?>/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= $bundle->baseUrl ?>/img/favicon/favicon-32x32.png">
        <link rel="mask-icon" href="<?= $bundle->baseUrl ?>/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <script type="text/javascript">
//            function showToast(message)
//            {
//                if (typeof AndroidDevice !== "undefined") {
//                    AndroidDevice.showToast(message);
//                }
//            }
            function showCalender(selectedDate, min, max, elementId)
            {
                if (typeof AndroidDevice !== "undefined") {
                    AndroidDevice.showDatePicker(selectedDate, min, max, elementId);
                }
            }
            function setDate(elementId, selectedDate)
            {
                if (typeof AndroidDevice !== "undefined") {
                    document.getElementById(elementId).value = selectedDate;
                }
            }
            function closeScreen(message)
            {
                if (typeof AndroidDevice !== "undefined") {
                    if (message != '')
                        AndroidDevice.showToast(message);
                    AndroidDevice.close();
                }
            }
            function showAndroidform(id)
            {
               
               AndroidDevice.openForm(id);
             
//                if (typeof AndroidDevice !== "undefined") {
//                    AndroidDevice.openForm(id);
//                }
            }
            function downloadPdf(url)
            {
               
               AndroidDevice.downloadPdf(url);
            
            }
        </script>  
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>
    <body class="mod-bg-1 mod-bigger-font">
        <p id="js-color-profile" class="d-none">
            <span class="color-primary-50"></span>
            <span class="color-primary-100"></span>
            <span class="color-primary-200"></span>
            <span class="color-primary-300"></span>
            <span class="color-primary-400"></span>
            <span class="color-primary-500"></span>
            <span class="color-primary-600"></span>
            <span class="color-primary-700"></span>
            <span class="color-primary-800"></span>
            <span class="color-primary-900"></span>
            <span class="color-info-50"></span>
            <span class="color-info-100"></span>
            <span class="color-info-200"></span>
            <span class="color-info-300"></span>
            <span class="color-info-400"></span>
            <span class="color-info-500"></span>
            <span class="color-info-600"></span>
            <span class="color-info-700"></span>
            <span class="color-info-800"></span>
            <span class="color-info-900"></span>
            <span class="color-danger-50"></span>
            <span class="color-danger-100"></span>
            <span class="color-danger-200"></span>
            <span class="color-danger-300"></span>
            <span class="color-danger-400"></span>
            <span class="color-danger-500"></span>
            <span class="color-danger-600"></span>
            <span class="color-danger-700"></span>
            <span class="color-danger-800"></span>
            <span class="color-danger-900"></span>
            <span class="color-warning-50"></span>
            <span class="color-warning-100"></span>
            <span class="color-warning-200"></span>
            <span class="color-warning-300"></span>
            <span class="color-warning-400"></span>
            <span class="color-warning-500"></span>
            <span class="color-warning-600"></span>
            <span class="color-warning-700"></span>
            <span class="color-warning-800"></span>
            <span class="color-warning-900"></span>
            <span class="color-success-50"></span>
            <span class="color-success-100"></span>
            <span class="color-success-200"></span>
            <span class="color-success-300"></span>
            <span class="color-success-400"></span>
            <span class="color-success-500"></span>
            <span class="color-success-600"></span>
            <span class="color-success-700"></span>
            <span class="color-success-800"></span>
            <span class="color-success-900"></span>
            <span class="color-fusion-50"></span>
            <span class="color-fusion-100"></span>
            <span class="color-fusion-200"></span>
            <span class="color-fusion-300"></span>
            <span class="color-fusion-400"></span>
            <span class="color-fusion-500"></span>
            <span class="color-fusion-600"></span>
            <span class="color-fusion-700"></span>
            <span class="color-fusion-800"></span>
            <span class="color-fusion-900"></span>
        </p>
        <?php $this->beginBody() ?>
        <script>
            /**
             *	This script should be placed right after the body tag for fast execution 
             *	Note: the script is written in pure javascript and does not depend on thirdparty library
             **/
            'use strict';

            var classHolder = document.getElementsByTagName("BODY")[0],
                    /** 
                     * Load from localstorage
                     **/
                    themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
                    {},
                    themeURL = themeSettings.themeURL || '',
                    themeOptions = themeSettings.themeOptions || '';
            /** 
             * Load theme options
             **/
            if (themeSettings.themeOptions)
            {
                classHolder.className = themeSettings.themeOptions;
                console.log("%c✔ Theme settings loaded", "color: #148f32");
            } else
            {
                console.log("Heads up! Theme settings is empty or does not exist, loading default settings...");
            }
            if (themeSettings.themeURL && !document.getElementById('mytheme'))
            {
                var cssfile = document.createElement('link');
                cssfile.id = 'mytheme';
                cssfile.rel = 'stylesheet';
                cssfile.href = themeURL;
                document.getElementsByTagName('head')[0].appendChild(cssfile);
            }
            /** 
             * Save to localstorage 
             **/
            var saveSettings = function ()
            {
                themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function (item)
                {
                    return /^(nav|header|mod|display)-/i.test(item);
                }).join(' ');
                if (document.getElementById('mytheme'))
                {
                    themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
                }
                ;
                localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
            }
            /** 
             * Reset settings
             **/
            var resetSettings = function ()
            {
                localStorage.setItem("themeSettings", "");
            }

            localStorage.clear();

        </script>
        <script>
            var message = "<?php Yii::$app->session->getFlash('success'); ?>";

        </script>

        <?php
        if (Yii::$app->session->getFlash('success')) {
            echo "
            <script type=\"text/javascript\">
            
            showToast(message)
            </script>
        ";
        }
        ?>
        <div class="page-wrapper">

            <div class="page-content-wrapper">
                <main id="js-page-content" role="main" class="page-content" style="margin-top: 0px">
                    <?php //\sakhi\components\widgets\CarouselmenuWidget::widget(['theme_base_url' => $bundle->baseUrl]) ?>
                    <div class="row">
                        <div class="col-lg-12 p-0">
                            <?php
                            echo AlertBlock::widget([
                                'useSessionFlash' => true,
                                'type' => AlertBlock::TYPE_GROWL,
                                'delay' => 0,
                                'options' => [
                                    'bsVersion' => '4.x',
                                ]
                            ]);
                            ?>

                            <?= $content ?>                                  

                        </div><!-- end col -->
                    </div>
                </main>
            </div>
        </div>        
        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage(); ?>

