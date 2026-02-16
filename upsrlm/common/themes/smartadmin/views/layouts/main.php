<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\assets\SmartAdminAppAsset;
use yii\widgets\Breadcrumbs;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;

$bundle = SmartAdminAppAsset::register($this);
$arg = explode('/', Yii::$app->request->url);
$url = explode('/', Yii::$app->request->url);
$useCboLayout = Yii::$app->request->baseUrl === '/cbo';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="root-text">
    <head>
        <?php
        if (Yii::$app->params['track_google_analytics'])
            echo kartik\social\GoogleAnalytics::widget([
                'trackerConfig' => [
                    'user_id' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->id : "0",
                ]
                    ]
            );
        ?>
        <meta charset="utf-8" />
        <meta name="description" content="UPSRLM CBO">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= $bundle->baseUrl ?>/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= $bundle->baseUrl ?>/img/favicon/favicon-32x32.png">
        <link rel="mask-icon" href="<?= $bundle->baseUrl ?>/img/favicon/safari-pinned-tab.svg" color="#5bbad5">

        <?= Html::csrfMetaTags() ?>
        <title>CBO: <?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>
    <body class="mod-bg-1 header-function-fixed nav-function-top">
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
        <div class="page-wrapper">
            <div class="page-inner">
                <?php // $this->assetBundles['yii\web\JqueryAsset'] = [];  ?>
                <?=
                $this->render($useCboLayout ? 'left_cbo.php' : 'left.php', ['bundle' => $bundle])
                ?>
                <div class="page-content-wrapper">
                    <?=
                    $this->render($useCboLayout ? 'header_cbo.php' : 'header.php', ['bundle' => $bundle])
                    ?>

                    <?=
                    $this->render('content.php', ['content' => $content, 'bundle' => $bundle])
                    ?>
                </div>
            </div>
        </div> 
        <?php if (!Yii::$app->user->isGuest) { ?>
            <nav class="shortcut-menu d-none d-sm-block">
                <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
                <label for="menu_open" class="menu-open-button ">
                    <span class="app-shortcut-icon d-block"></span>
                </label>
                <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Scroll Top">
                    <i class="fal fa-arrow-up"></i>
                </a>
                <a href="/site/logout" class="menu-item btn" data-method="post" data-toggle="tooltip" data-placement="left" title="Logout">
                    <i class="fal fa-sign-out"></i>
                </a>
<!--                <a href="#" class="menu-item btn" data-action="app-fullscreen" data-toggle="tooltip" data-placement="left" title="Full Screen">
                    <i class="fal fa-expand"></i>
                </a>-->
<!--                <a href="#" class="menu-item btn" data-action="app-print" data-toggle="tooltip" data-placement="left" title="Print page">
                    <i class="fal fa-print"></i>
                </a>-->
                <!--            <a href="#" class="menu-item btn" data-action="app-voice" data-toggle="tooltip" data-placement="left" title="Voice command">
                                <i class="fal fa-microphone"></i>
                            </a>-->
            </nav>
        <?php } ?>
        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage(); ?>

