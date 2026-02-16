<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\assets\SmartAdminRishtaAppAsset;
use yii\widgets\Breadcrumbs;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;
use sakhi\components\MobileDetect;

$bundle = SmartAdminRishtaAppAsset::register($this);
$baseUrl = Yii::$app->request->baseUrl;
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
        <!-- DOC: script to save and load page settings -->
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

        </script>
        <!-- BEGIN Page Wrapper -->
        <div class="page-wrapper">
            <div class="page-inner">
                <!-- BEGIN Left Aside -->
                <aside class="page-sidebar">
                    <div class="page-logo">
                        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                            <img src="<?= $bundle->baseUrl ?>/img/logo_70.png" alt="" aria-roledescription="logo">
                            <span class="page-logo-text mr-1"></span>
                            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
<!--                            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>-->
                        </a>
                    </div>
                    <?php if (!Yii::$app->user->isGuest) { 
                        $cbo_member = \common\models\CboMembers::find()->where(['user_id' => Yii::$app->user->identity->id, 'suggest_wada_sakhi' => 1])->one()
                        
                        ?>
                        <!-- BEGIN PRIMARY NAVIGATION -->
                        <nav id="js-primary-nav" class="primary-nav" role="navigation">

                            <div class="info-card">
                                <?php if (isset(Yii::$app->user->identity->cboprofile->profile_photo)) { ?>
                                    <img src="<?= Yii::$app->user->identity->cboprofile->profile_photo_url ?>" class="profile-image rounded-circle" alt="">
                                <?php } ?>
                                <div class="info-card-text">
                                    <a href="#" class="d-flex align-items-center text-white">
                                        <span class="text-truncate text-truncate-sm d-inline-block">
                                            <?= Yii::$app->user->identity->name ?>
                                        </span>
                                    </a>
                                    <span class="d-inline-block text-truncate text-truncate-sm"><?= isset(Yii::$app->user->identity->cboprofile->address) ? Yii::$app->user->identity->cboprofile->address : '' ?></span>
                                </div>

                            </div>
                            <ul id="js-nav-menu" class="nav-menu">
                                <?php if (isset($cbo_member)) { ?>
                                    <li>
                                        <a href="<?= $baseUrl ?>/shg/application/form?shgid=<?= $cbo_member->cbo_id ?>" title="समूह सखी आवेदन प्रपत्र" data-filter-tags="application-change-pin">
                                            <span class="nav-link-text" data-i18n="nav.application_intel_introduction">समूह सखी आवेदन प्रपत्र</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (isset(Yii::$app->user->identity->cboprofile->srlm_bc_application_id)) { ?>
                                    <li>
                                        <a href="<?= $baseUrl ?>/bc/default/view?bcid=<?= Yii::$app->user->identity->cboprofile->srlm_bc_application_id ?>" title="बीसी सखी प्रोफाइल" data-filter-tags="application-change-pin">
                                            <span class="nav-link-text" data-i18n="nav.application_intel_introduction">बीसी सखी प्रोफाइल</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a href="<?= $baseUrl ?>/user/default/changepin?userid=<?= Yii::$app->user->identity->id ?>" title="पिन बदलें" data-filter-tags="application-change-pin">
                                        <span class="nav-link-text" data-i18n="nav.application_intel_introduction">पिन बदलें</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $baseUrl ?>/site/logout" title="लॉग आउट" data-filter-tags="application-log-out">
                                        <span class="nav-link-text" data-i18n="nav.application_intel_introduction">लॉग आउट</span>
                                    </a>
                                </li>


                            </ul>
                            <div class="filter-message js-filter-message bg-success-600"></div>
                        </nav>
                        <!-- END PRIMARY NAVIGATION -->
                    <?php } ?>
                </aside>
                <!-- END Left Aside -->
                <div class="page-content-wrapper">
                    <!-- BEGIN Page Header -->
                    <header class="page-header" role="banner">
                        <!-- we need this logo when user switches to nav-function-top -->
                        <div class="page-logo">
                            <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                                <img src="<?= $bundle->baseUrl ?>/img/logo_70.png" alt="" aria-roledescription="logo">
                                <span class="page-logo-text mr-1"></span>
                                <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>

                            </a>
                        </div>
                        <!-- DOC: nav menu layout change shortcut -->
                        <div class="hidden-md-down dropdown-icon-menu position-relative">
                            <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Hide Navigation">
                                <i class="ni ni-menu"></i>
                            </a>

                        </div>
                        <!-- DOC: mobile button appears during mobile width -->
                        <div class="hidden-lg-up">
                            <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
                                <i class="ni ni-menu"></i>
                            </a>
                        </div>

                        <div class="ml-auto d-flex">


                            <!-- app notification -->
                            <!--                            <div>
                                                            <a href="#" class="header-icon" data-toggle="dropdown" title="You got 11 notifications">
                                                                <i class="fal fa-bell"></i>
                                                                <span class="badge badge-icon">11</span>
                                                            </a>
                            
                                                        </div>-->

                        </div>
                    </header>
                    <!-- END Page Header -->
                    <!-- BEGIN Page Content -->
                    <!-- the #js-page-content id is needed for some plugins to initialize -->
                    <main id="js-page-content" role="main" class="page-content">


                        <div class="row">
                            <div class="col-xl-12">
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
                            </div>
                        </div>
                    </main>
                    <!-- this overlay is activated only when mobile menu is triggered -->
                    <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
                    <!-- BEGIN Page Footer -->
                    <footer class="page-footer" role="contentinfo">
                        <div class="d-flex align-items-center flex-1 text-muted">

                        </div>
                        <div>

                        </div>
                    </footer>
                    <!-- END Page Footer -->
                    <!-- BEGIN Color profile -->
                    <!-- this area is hidden and will not be seen on screens or screen readers -->
                    <!-- we use this only for CSS color refernce for JS stuff -->
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
                    <!-- END Color profile -->
                </div>
            </div>
        </div>
        <!-- END Page Wrapper -->


        <?php
//        $css = <<<cs
// .page-logo {
//    height: 7.125rem !important;
//}
//cs;
//        $this->registerCss($css);
        ?>
        <?php $this->endBody() ?>
    </body>
</html>

<?php $this->endPage(); ?>