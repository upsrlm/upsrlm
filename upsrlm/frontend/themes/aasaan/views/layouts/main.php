<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AasaanAppAsset;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;
use app\models\UserModel;
use app\models\master\MasterRole;

$bundle = AasaanAppAsset::register($this);
AdminAsset::register($this);
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
        <meta content="End Poverty : Civil Society Organizations (CSO) engagement for conducting IEC and thereby facilitate citizen-level accomplishments." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>
    <body class="no-skin" >
        <?php $this->beginBody() ?>
        <header id="topnav">
            <div class="topbar-main al-topbar">
                <div class="d-flex justify-content-around align-items-center">

                    <a href="/" class="p-2 logo">
                        <img src="/images/upg-sm-logo.png" alt="" height="26" class="logo-small">
                        <img src="/images/upg-sm-logo.png" alt="" height="100%" class="logo-large">
                    </a>
                    <!-- End Logo container-->
                    <div class="flex-grow-1 top-heading text-left">
                        <h1>पंचायती राज एवं ग्राम विकास विभाग, उत्तर प्रदेश शासन</h1>
                        <span>&nbsp;</span>
                    </div>
                    <div class="flex-grow-1 top-heading text-right">
                        <h1></h1>
                    </div>
                    <div class="p-2 right-logo">
                        <img src="" />
                    </div>


                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->
            <div class="nav-container d-flex justify-content-around align-items-center">
                <div class="navbar-custom al-nav-bar flex-grow-1">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_YOUNG_PROFESSIONAL]))) { ?>
                                <li class="">
                                    <a  class="dropdown-toggless" href="#">
                                        <span class="">&nbsp;</span>
                                    </a>   
                                </li>     
                                <li class="">
                                    <a  class="dropdown-toggless" href="#">
                                        <span class="">&nbsp;</span>
                                    </a>   
                                </li>     
                                <li class="">
                                    <a  class="dropdown-toggless" href="#">
                                        <span class="">&nbsp;</span>
                                    </a>   
                                </li>     



                                <li class="has-submenu">  
                                    <a   href="#"><i class="mdi mdi-view-list"></i> 
                                        <span>SHG</span> 

                                    </a>
                                    <ul class="submenu">
                                        <li class="">
                                            <a href="/shg/shg/index" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">List</span> </a>
                                        </li>
                                        <li class="">
                                            <a href="/shg/shg/create" style="padding-left: 10px;"><i class="fa fa-dashboard"></i><span> Add </span> </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php } if (!Yii::$app->user->isGuest && !(in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BMMU]))) { ?>

                                <li class="">
                                    <a href="/nfsaSurvey/dashboard" style="padding-left: 10px;"><span> NFSA Survey </span> </a>
                                </li>
                                <?php if (Yii::$app->user->identity->role == MasterRole::ROLE_ADMIN) { ?>
                                    <li class="has-submenu">
                                        <a href="#"><i class="mdi mdi-view-list"></i> <span> SRLM - BC Selection </span> </a>
                                        <ul class="submenu">
                                            <li class="">
                                                <a href="/srlm/" style="padding-left: 10px;"><i class="fa fa-dashboard"></i><span> Dashboard </span> </a>
                                            </li>
                                            <li class="">
                                                <a href="/srlm/bcselection/registereduser" style="padding-left: 10px;"><i class="fa fa-users"></i><span> Registered user </span> </a>
                                            </li>
                                            <li class="">
                                                <a href="/srlm/bcselection/district" style="padding-left: 10px;"><i class="fa fa-globe"></i><span> District </span> </a>
                                            </li>
                                            <li class="">
                                                <a href="/srlm/bcselection/block" style="padding-left: 10px;"><i class="fa fa-globe"></i><span> Block </span> </a>
                                            </li>
                                            <li class="">
                                                <a href="/srlm/bcselection/grampanchayat" style="padding-left: 10px;"><i class="fa fa-globe"></i><span> GP </span> </a>
                                            </li>
                                            <li class="">
                                                <a href="/srlm/bcselection/registration" style="padding-left: 10px;"><i class="fa fa-globe"></i><span> No Registration </span> </a>
                                            </li>
                                            <li class="">
                                                <a href="/srlm/bcselection/districtgp" style="padding-left: 10px;"><i class="fa fa-globe"></i><span> District GP</span> </a>
                                            </li>
                                            <li class="">
                                                <a href="/srlm/bcselection/downloadcsvgp" style="padding-left: 10px;"><i class="fa fa-download"></i><span> Download GP report</span> </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN, MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) { ?>             
                                    <li class="">
                                        <a href="/nfsaSurvey/map" style="padding-left: 10px;"><i class="fa fa-globe"></i><span> Map </span> </a>
                                    </li>
                                    <li class="">
                                        <a href="#" style="padding-left: 10px;"><span> &nbsp; </span> </a>
                                    </li>
                                    <li class="">
                                        <a href="/admin" style="padding-left: 10px;"><i class="mdi mdi-home"></i> <span> Home </span> </a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN, MasterRole::ROLE_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_BDO, MasterRole::ROLE_GP_ADHIKARI, MasterRole::ROLE_GP_SAACHIV, MasterRole::ROLE_MC, MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR])) { ?>             
                                    <li class="has-submenu">
                                        <a href="#"><i class="mdi mdi-view-list"></i> <span> Master </span> </a>
                                        <ul class="submenu">
                                            <li class="">
                                                <a href="/admin/master/block/index"><i class="fa fa-table"></i><span>Block List</span> </a>
                                            </li>
                                            <li class="">
                                                <a href="/admin/master/grampanchayat/index"><i class="fa fa-table"></i><span>Gram Panchayat List</span> </a>
                                            </li>
                                            <li class="">
                                                <a href="/admin/master/master-village/index"><i class="fa fa-table"></i><span>Village List</span> </a>
                                            </li>
                                            <!--                                    <li class="">
                                                                                    <a href="/admin/master/master-block-bdo/index"><i class="fa fa-table"></i><span>Block BDO List</span> </a>
                                                                                </li>-->
                                            <li class="">
                                                <a href="/admin/master/master-ulb/index"><i class="fa fa-table"></i><span> ULB List</span> </a>
                                            </li>
                                            <li class="">
                                                <a href="/admin/master/ward/index"><i class="fa fa-table"></i><span> Ward List</span> </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?>  
                                <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN, MasterRole::ROLE_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_BDO, MasterRole::ROLE_GP_ADHIKARI, MasterRole::ROLE_GP_SAACHIV, MasterRole::ROLE_MC, MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR])) { ?>             
                                    <li class="has-submenu">
                                        <a href="#"><i class="mdi mdi-view-list"></i> <span> Users </span> </a>
                                        <ul class="submenu">
                                            <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BDO, MasterRole::ROLE_GP_ADHIKARI, MasterRole::ROLE_GP_SAACHIV])) { ?>
                                                <li>
                                                    <a href="/admin/users/gpsen" title="Rural Secondary User" ><span>Rural Secondary User</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_MC, MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR])) { ?>
                                                <li>
                                                    <a href="/admin/users/ursen" title="Urban Primary User" ><span>Urban Secondary User</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (Yii::$app->user->identity->role == MasterRole::ROLE_ADMIN || Yii::$app->user->identity->role == MasterRole::ROLE_CALL_CENTER_ADMIN || Yii::$app->user->identity->role == MasterRole::ROLE_CALL_CENTER_EXECUTIVE) { ?>

                                                <?php
                                                if (Yii::$app->user->identity->role == MasterRole::ROLE_ADMIN || Yii::$app->user->identity->role == MasterRole::ROLE_CALL_CENTER_EXECUTIVE || Yii::$app->user->identity->role == MasterRole::ROLE_CALL_CENTER_ADMIN) {
                                                    ?>
                                                    <li class="has-submenu">
                                                        <a href="#"><i class="mdi mdi-view-list"></i> <span> Users </span> </a>
                                                        <ul class="submenu">
                                                            <li>
                                                                <a href="/admin/users/cdo" title="CDO"> <span>CDO</span> </a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users/dso" title="DSO"> <span>DSO</span> </a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users/dm" title="District Magistrate"> <span>District Magistrate</span> </a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users/divcom" title="Divisional Commissioner"> <span>Divisional Commissioner</span> </a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users/bdo" title="BDO"> <span>BDO</span> </a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users/gpa" title="Rural Primary User" ><span>Rural Primary User</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users/gpsen" title="Rural Secondary User" ><span>Rural Secondary User</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users/urpen" title="Urban Primary User" ><span>Urban Primary User</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users/ursen" title="Urban Primary User" ><span>Urban Secondary User</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users/mc" title="Municipal Commissioner User" ><span>Municipal Commissioner User</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users/callcenter" title="NREGA Call Center Executive" ><span>Call Center Executive</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/admin/users" title="Users" ><span>Users</span></a>
                                                            </li>
                                                            <?php if (Yii::$app->user->identity->role == MasterRole::ROLE_ADMIN || Yii::$app->user->identity->role == MasterRole::ROLE_CALL_CENTER_ADMIN) { ?>

                                                                <li>
                                                                    <a href="/admin/users/add" title="Add User" ><span>Add New User</span></a>
                                                                </li>
                                                            <?php } ?>
                                                            <!--                                    <li class="has-submenu">
                                                                                                    <a href="#"><i class="mdi mdi-view-list"></i><span> Dept Lists </span></a>
                                                                                                    <ul class="submenu">
                                                                                                        <li>
                                                                                                            <a href="admin/master/master-block-bdo/index" title="Dept BDO List">Dept BDO List</span> </a>
                                                                                                        </li>
                                                                                                        <li>
                                                                                                            <a href="/admin/users/deptgpalist" title="Dept Gram Panchayat Adhikari List" ><span>Dept Gram Panchayat Adhikari List</span></a>
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                </li>-->
                                                        </ul>
                                                    </li>

                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                <?php } ?>
                                <!-- End navigation menu -->
                                </div> <!-- end #navigation -->
                                </div> <!-- end navbar-custom -->
                                <div class="menu-extras topbar-custom d-flex justify-content-around align-items-center">
                                    <ul class="list-unstyled topbar-right-menu float-right mb-0">

                                        <li class="menu-item">
                                            <!-- Mobile menu toggle-->
                                            <a class="navbar-toggle nav-link">
                                                <div class="lines">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                            </a>
                                            <!-- End mobile menu toggle-->
                                        </li>
                                    </ul>
                                    <button type="button" class="btn btn-info btn-rounded waves-effect waves-light btn-sm"><i class="mdi mdi-help-circle"></i>    Help</button>
                                    <ul class="list-unstyled topbar-right-menu float-right mb-0">
                                        <?php if (!Yii::$app->user->isGuest) { ?>
                                            <li class="dropdown notification-list">
                                                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                                   aria-haspopup="false" aria-expanded="false">
                                                    <img src="<?= $bundle->baseUrl ?>/images/man.svg" alt="user" class="rounded-circle"> <?= Yii::$app->user->identity->name ?>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                                                    <a href="/changepassword" class="dropdown-item notify-item">
                                                        <i class="ti-power-off m-r-5"></i> Change Password
                                                    </a>
                                                    <a href="/site/logout" class="dropdown-item notify-item">
                                                        <i class="ti-power-off m-r-5"></i> Logout
                                                    </a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                </div>
                                </header>
                                <!-- End Navigation Bar-->
                                <div class="wrapper">
                                    <div class="container-fluid" style="max-width: 99%;">
                                        <!-- Page-Title -->
                                        <div class="row"> 
                                            <div class="col-12">

                                                <div class="page-title">
                                                    <?=
                                                    Breadcrumbs::widget([
                                                        'homeLink' => [
                                                            'label' => 'Home',
                                                            'url' => '/admin',
                                                        ],
                                                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                                    ])
                                                    ?>
                                                </div>
                                            </div>
                                            <!-- end page title end breadcrumb -->
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <?php
                                                echo AlertBlock::widget([
                                                    'useSessionFlash' => true,
                                                    'type' => AlertBlock::TYPE_ALERT,
                                                    'delay' => 0,
                                                ]);
                                                ?>
                                                <div class="content">
                                                    <?= $content ?>                                  
                                                </div>
                                            </div><!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div> 
                                <!-- end wrapper -->
                                <!-- Footer -->
                                <footer class="footer">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12 text-center">
                                            </div>
                                        </div>
                                    </div>
                                </footer>
                                <?php $this->endBody() ?>
                                </body>
                                </html>
                                <?php $this->endPage(); ?>

                                <?php
                                // }?>