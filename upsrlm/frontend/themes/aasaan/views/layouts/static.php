<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AasaanAppAsset;
use app\assets\StaticAsset;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;

$bundle = AasaanAppAsset::register($this);
StaticAsset::register($this);
$arg = explode('/', Yii::$app->request->url);
$url = explode('/', Yii::$app->request->url);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="utf-8" />
        <title>UP SRLM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="UPSRLM" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>
    <body class="no-skin">
        <?php $this->beginBody() ?>
        <header id="topnav">
            <div class="topbar-main home-topbar">
                <div class="d-flex justify-content-around align-items-center">

                    <a href="/" class="p-2 logo">
                        <img src="/images/upsrlm.png" alt="" height="26" class="logo-small">
                        <img src="/images/upsrlm.png" alt="" height="100%" class="logo-large">
                        <br/><span style="color:#464646;font-size:18px">UPSRLM</span>
                    </a>
                    <!-- End Logo container-->
                    <div class="p-2 flex-grow-1 top-heading">
                        <h1>ग्राम विकास विभाग, उत्तर प्रदेश शासन</h1>
                        <p>&nbsp;&nbsp;&nbsp;</p>
                        <p>&nbsp;&nbsp;&nbsp;</p>
                          <!-- <p>नागरिक सहभागिता सुनिश्चित करने के लिए CSOs से सम्बद्धता की नवीन पहल</p>-->
                    </div>

                    <div class="p-2 right-logo">
                        <img src="/images/upg-logo.png" />
                         <br/><span style="color:#464646;font-size:18px;font-weight:700">&nbsp;&nbsp;&nbsp;DoRD U.P.</span>
                    </div>


                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->
            <div class="nav-bar-small">
                <a class="navbar-toggle nav-link">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
            </div>
            <div class="navbar-custom home-nav-bar">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu" style="text-align:left">
                            <li class="<?php if ($url[1] == 'page' && isset($url[2]) && $url[2] == 'home') echo 'active'; ?>">
                                <a href="/page/home" style="padding-left: 10px;"><i class="mdi mdi-home"></i> <span> Home </span> </a>
                            </li>
<!--                            <li class="<?php if ($url[1] == 'page' && isset($url[2]) && $url[2] == 'about') echo 'active'; ?>">
                                <a href="/page/about"><i class="mdi mdi-earth"></i><span> About </span> </a>
                            </li>
                            <li class="<?php if ($url[1] == 'page' && isset($url[2]) && $url[2] == 'go') echo 'active'; ?>">
                                <a href="/page/go"><i class="mdi mdi-earth"></i><span> Govt Orders </span> </a>
                            </li>
                            <li class="<?php if ($url[1] == 'page' && isset($url[2]) && $url[2] == 'faq') echo 'active'; ?>">
                                <a href="/page/faq"><i class="mdi mdi-information-outline"></i> <span> FAQ </span> </a>
                            </li>-->
                            <li class="<?php if ($url[1] == 'page' && isset($url[2]) && $url[2] == 'contact') echo 'active'; ?>">
                                <a href="/page/contact"><i class="mdi mdi-email"></i><span> Contact </span> </a>
                            </li>
                            <?php if (!Yii::$app->user->isGuest) { ?>
                                <li class="<?php if ($url[1] == 'dashboard' && isset($url[2]) && $url[2] == 'dashboard') echo 'active'; ?>">
                                    <a href="/dashboard"><i class="mdi mdi-email"></i><span> Dashboard </span> </a>
                                </li>
                                <li class="<?php if ($url[1] == 'changepassword' && isset($url[2]) && $url[2] == 'changepassword') echo 'active'; ?>">
                                    <a href="/changepassword"><i class="mdi mdi-email"></i><span> Change Password </span> </a>
                                </li>
                                <li class="<?php if ($url[1] == 'site' && isset($url[2]) && $url[2] == 'changepassword') echo 'active'; ?>">
                                    <a href="/site/logout"><i class="mdi ti-power-off"></i><span> Logout </span> </a>
                                </li>
                                <li style="text-align:right" class="<?php if ($url[1] == 'site' && isset($url[2]) && $url[2] == 'changepassword') echo 'active'; ?>">
                                    <a class=" nav-user" data-toggle="dropdown" href="#" role="button"
                                       aria-haspopup="false" aria-expanded="false">
                                        <img src="<?= $bundle->baseUrl ?>/images/man.svg" alt="user" class="rounded-circle"> <?= Yii::$app->user->identity->name ?>
                                    </a>
                                </li>

                            <?php } ?>   
                        </ul>
                        <!-- End navigation menu -->


                    </div> <!-- end #navigation -->

                </div> <!-- end container -->

            </div> <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->


        <div class="wrapper" >
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <?php if ($this->title !== null) { ?>
                        <div class="col-sm-12">
                            <h4 class="page-title"><?= $this->title ?></h4>
                        </div>
                    <?php } ?>  
                </div>
                <!-- end page title end breadcrumb -->


                <div class="row">
                    <div class="col-12">
                        <div class="content">

                            <?= $content ?>                                  
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->

            </div>
        </div> <!-- end container -->

        <!-- end wrapper -->


        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <span class="black">
                        Facilitated by Department of Rural Development, Government of Uttar Pradesh                         
                    </span>
                </div>
            </div>
        </footer>
        <!-- End Footer -->



        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage(); ?>
