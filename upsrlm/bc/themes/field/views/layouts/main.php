<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use bc\assets\FieldAppAsset;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;
use common\models\master\MasterRole;

/* @var $this \yii\web\View */
/* @var $content string */

FieldAppAsset::register($this);
$baseUrl = Yii::$app->request->baseUrl;
$arg = explode('/', Yii::$app->request->url);
$url = explode('/', Yii::$app->request->url);
//print_r($url);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="<?= Yii::$app->charset ?>"/>
        <!--<link rel="shortcut icon" href="/images/favicon.ico">-->
        <link rel="shortcut icon" href="/images/aasaan-fav.png">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!--        <link rel="stylesheet" href="/content/custom.css">-->
    </head>
    <body class="no-skin" ng-app="questionnaireApp">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
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

        <div class="top-head">

            <div class="row">  
                <div class="col-lg-6">
                    <div class="pull-left" style="padding-left: 5px">
                        <div class="col-lg-2">  <img class="logos" src="/images/upsrlm.png" alt="Swachh Bharat Urban Uttar Pradesh" style="padding-left: 1%;height: 60px"> </div>
                        <div class="col-lg-10" style="padding-left: 0px"> <span class="text-center"><h2 style="color: #F79520;margin-top: 2px;margin-bottom: 2px;">&nbsp;&nbsp;&nbsp; Uttar Pradesh State<br/>Rural Livelihood Mission</h2></span></div>
                    </div>
                </div>   
                <div class="col-lg-2">
                    <h2 style="color: #F79520;">BC Sakhi Portal</h2>
                </div>
                <div class="col-lg-4">
                    <div class="pull-right">
<!--                        <div class="col-lg-12" style="padding-right: 10px"> <span class="text-right"><h2 style="margin-top: 12px;margin-bottom: 4px;text-align: right">Helpline No. : +919260985122 </h2></span></div>-->
                        <div class="col-lg-3" style="padding-left: 0px"><img class="logos" src="/images/sgrca_logo.png" alt="Swachh Bharat Urban Uttar Pradesh" style="height: 60px;text-align: left"></div>     
                    </div>
                </div>    
            </div>

        </div>

        <!-- #section:basics/navbar.layout -->
        <div id="navbar" class="navbar navbar-default navbar-collapse h-navbar">
            <script type="text/javascript">
                try {
                    ace.settings.check('navbar', 'fixed')
                } catch (e) {
                }
            </script>

            <div class="navbar-container" id="navbar-container">

                <div class="navbar-buttons  pull-left " role="navigation" id="right-nav-buttons">

                    <div class="" style="background-color:#333444" id="right-nav-buttons-inner">
                        <ul class="nav ace-nav " id="main-nav-bar-ul">

                            <?php if (!Yii::$app->user->isGuest) { ?>
                                <li class="blue">
                                    <a  class="dropdown-toggless" href="#">
                                        <span class="">&nbsp;</span>
                                    </a>   
                                </li>     
                                <li class="blue">
                                    <a  class="dropdown-toggless" href="#">
                                        <span class="">&nbsp;</span>
                                    </a>   
                                </li>   
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER]))) { ?>
                                    <li class="blue">  
                                        <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                            <i class="mdi mdi-view-list"></i> <span>BC Applications</span> 
                                            <i class="ace-icon fa fa-caret-down"></i>
                                        </a>
                                        <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">
                                            <li class="">
                                                <a href="<?= $baseUrl ?>/selection/dashboard" style="padding-left: 10px;"><i class="fa fa-dashboard"></i><span> Application - Dashboard </span> </a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/district"><i class="fa fa-globe"></i> District Wise Status</a> 
                                            </li>

                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/district"><i class="fa fa-globe"></i> District Wise Status</a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/block"><i class="fa fa-globe"></i> Block Wise Status</a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/grampanchayat"><i class="fa fa-globe"></i> GP Wise Status</a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/registration"><i class="fa fa-globe"></i> GP with No Registration</a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/districtgp"><i class="fa fa-globe"></i> GP with No Registration summary</a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/downloadcsvgp"><i class="fa fa-download"></i> GP wise application reportt</a>
                                            </li>

                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER]))) { ?>
                                    <li class="blue">  
                                        <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                            <i class="mdi mdi-view-list"></i> <span>BC Selection</span> 
                                            <i class="ace-icon fa fa-caret-down"></i>
                                        </a>
                                        <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">
                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/dashboard/report"><i class="fa fa-dashboard"></i> Report</a>
                                            </li>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                                <li class="dropdown-header">
                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/data/application/list"><i class="fa fa-dashboard"></i> BC Sakhi List</a>
                                                </li>
                                                <li class="dropdown-header">
                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/data/application/singleapplication"><i class="fa fa-dashboard"></i> Single application</a>
                                                </li>
                                                <li class="dropdown-header">
                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/data/application/highestscore"><i class="fa fa-dashboard"></i> Person Highest score</a>
                                                </li>
                                                <li class="dropdown-header">
                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/data/application/report"><i class="fa fa-dashboard"></i> Select</a>
                                                </li>
                                            <?php } ?>
                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/dashboard/graph"><i class="fa fa-chart-bar"></i> Graphs</a>
                                            </li>

                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/dashboard/report/selected"><i class="fa fa-users"></i> GP where Selection Completed</a>
                                            </li>

                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_DM, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_VIEWER, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                    <li class="blue">  
                                        <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                            <i class="mdi mdi-view-list"></i> <span>BC Shortlisted</span> 
                                            <i class="ace-icon fa fa-caret-down"></i>
                                        </a>
                                        <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">
                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected">Pre Selected</a>
                                            </li>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                                <li class="dropdown-header">
                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/missing">BC Misplaced</a>
                                                </li>
                                            <?php } ?>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                                <li class="dropdown-header">
                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected/vacantgp">Vacant GP</a>
                                                </li>
                                            <?php } ?> 
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                                <li class="dropdown-header">
                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected/standbydownload">Download 1st Stand By List for Verification</a>
                                                </li>
                                            <?php } ?>   
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DM, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_DIVISIONAL_COMMISSIONER]))) { ?>
                                                <li class="dropdown-header">
                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected/graph">Graph</a>
                                                </li>
                                            <?php } ?>
                                            <li class="dropdown-header">
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected/bcdata">Download List for Verification</a>
                                            </li>

                                        </ul>
                                    </li>
                                <?php } ?>   
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_MD, MasterRole::ROLE_VIEWER, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <li class="blue">  
                                    <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                        <i class="mdi mdi-view-list"></i> <span>RSETIs Training</span> 
                                        <i class="ace-icon fa fa-caret-down"></i>
                                    </a>
                                    <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">

                                        <li class="dropdown-header">
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/dashboard">Dashboard</a>
                                            <?php } ?>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/training/ecalendar">Training e-calendar</a>

                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected">Add training participants/ form batch</a>
                                            <?php } ?>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                                <!--                                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/ineligiblelist">Reason for Ineligible</a>-->
                                            <?php } ?> 
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/educationeligibility">Confirm Education Eligibility</a>
                                            <?php } ?>  
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/unwillinglist">Unwilling</a>
                                            <?php } ?>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/blocked">List of blocked BC</a>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/training/training">View Training List</a>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/training/report">Training Report</a>


                                        </li>


                                    </ul>
                                </li>
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_VIEWER, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <li class="blue">  
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants">
                                        <i class="mdi mdi-view-list"></i> <span>Progress MIS</span> 

                                    </a>
                                </li> 

                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_BMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_VIEWER]))) { ?>
                                <li class="blue">  
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/certified">
                                        <i class="mdi mdi-view-list"></i> <span>Certified BC</span> 

                                    </a>
                                </li> 
                            <?php } ?> 

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_SPM_FI_MF]))) { ?>
                                <li class="blue">  
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/verification">
                                        <i class="mdi mdi-view-list"></i> <span>Verification</span> 

                                    </a>
                                </li> 
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SPM_FINANCE]))) { ?>
                                <li class="blue">  
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/pfmspayment">
                                        <i class="mdi mdi-view-list"></i> <span>PFMS & Payment</span> 

                                    </a>
                                </li> 
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_SPM_FINANCE]))) { ?>
                                <li class="blue">  
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/honorarium">
                                        <i class="mdi mdi-view-list"></i> <span>BC-PFMS & Payment</span> 

                                    </a>
                                </li> 
                            <?php } ?>   
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM]))) { ?>
                                <li class="blue">  
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/bcpfmsmapping">
                                        <i class="mdi mdi-view-list"></i> <span>BC-PFMS mapping</span> 

                                    </a>
                                </li> 
                            <?php } ?>   
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL]))) { ?>
                                <li class="blue">  
                                    <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                        <i class="mdi mdi-view-list"></i> <span>Bank/FI</span> 
                                        <i class="ace-icon fa fa-caret-down"></i>
                                    </a>
                                    <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">

                                        <li class="dropdown-header">
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BANK_DISTRICT_UNIT]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/partneragencies/user">Nodal User</a>
                                            <?php } ?>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BANK_DISTRICT_UNIT]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/partneragencies/planning">Plan Field Operation</a>
                                            <?php } ?>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BANK_DISTRICT_UNIT]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/partneragencies/transaction/report">BC Transaction</a>
                                            <?php } ?>

                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/partneragencies/associates/">Field Associates</a> 
                                            <?php } ?>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_RSETIS_NODAL_BANK]))) { ?>
                                <li class="blue">  
                                    <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                        <i class="mdi mdi-view-list"></i> <span>Report</span> 
                                        <i class="ace-icon fa fa-caret-down"></i>
                                    </a>
                                    <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">

                                        <li class="dropdown-header">
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/cumulative/pendencyd">Pendency Dashboard</a>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/report/dashboard">Dashboard</a>
                                            <?php } ?>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/report/rseti">Rseti Dashboard</a>
                                            <?php } ?>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/report/partneragencies">Partner Bank/FI Dashboard</a>
                                            <?php } ?>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/report/cumulative/district">Cumulative district report </a>
                                            <?php } ?> 

                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN,MasterRole::ROLE_BANK_DISTRICT_UNIT]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/partneragencies/transaction/primaryreport">Transaction _ performance report</a>
                                            <?php } ?>
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/partneragencies/transaction/secondaryreport">Transaction _ thematic report</a>
                                            <?php } ?> 
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/partneragencies/transaction/reportadmin">BC Transaction file upload  report</a>
                                            <?php } ?>   
                                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL]))) { ?>
                                                <a class="dropdown-item" href="<?= $baseUrl ?>/report/bcfeedback">प्रशिक्षण व संवेदिकरण</a>
                                            <?php } ?>   
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER]))) { ?>
                                <li class="blue">  
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/md/validation">
                                        <i class="mdi mdi-view-list"></i> <span>Validation of Deliverables</span> 

                                    </a>
                                </li> 
                            <?php } ?>  
                            <!--
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                                                                                <li class="blue">  
                                                                                                    <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                                                                                        <i class="mdi mdi-view-list"></i> <span>Corona</span> 
                                                                                                        <i class="ace-icon fa fa-caret-down"></i>
                                                                                                    </a>
                                                                                                    <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">
                                                                
                                                                                                        <li class="dropdown-header">
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                                                                                                                                    <a class="dropdown-item" href="/corona"> Report</a> 
                                                                                                                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/corona/report"> Dashboard</a>
                                                                                                                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/corona/report/graph"> Graph</a>
                                <?php } ?>
                                                                
                                                                
                                                                                                        </li>
                                                                
                                                                
                                                                                                    </ul>
                                                                                                </li>
                            <?php } ?>    
                            -->
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT]))) { ?>
                                <li class="blue">   <a class="dropdown-item" href="<?= $baseUrl ?>/training/usermanual">Guideline</a></li>   
                            <?php } ?>

                            <!-- /section:basics/navbar.user_menu -->
                        </ul>


                    </div> <!-- <div> with id="right-nav-buttons-inner"-->

                </div> 
                <?php if (Yii::$app->user->isGuest) { ?>

                <?php } else { ?>

                    <div class="navbar-buttons  pull-right " role="navigation" id="right-nav-buttons">

                        <div class="" style="background-color:#333444" id="right-nav-buttons-inner">

                            <ul class="nav ace-nav " id="main-nav-bar-ul">
                                <!-- #section:basics/navbar.user_menu -->
                                <!-- #section:basics/navbar.user_menu -->
                                <?php
//                                if (\Yii::$app->request->userIP != '127.0.0.1') {
//                                    echo kartik\ipinfo\IpInfo::widget([
//                                        'ip' => \Yii::$app->request->userIP,
//                                        'flagWrapperOptions' => [
//                                            'class' => 'btn btn-lg btn-default'
//                                        ],
//                                    ]);
//                                }
                                ?>
                                <?= common\widgets\SrlmSelectApplication::widget([]) ?>
                                <li class="light-blue">
                                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                        <span class="user-info" style="font-size: 12px">
                                            <small>
                                                <?php
                                                $user_name = 'Welcome,<br> ';
                                                if (Yii::$app->user->identity->name != " ") {
                                                    $user_name .= Yii::$app->user->identity->name . " (" . Yii::$app->user->identity->urole->role_name . ")";
                                                } else {
                                                    $user_name .= Yii::$app->user->identity->username . " (" . Yii::$app->user->identity->urole->role_name . ")";
                                                }
                                                ?>
                                            </small>
                                            <?php echo $user_name; ?>
                                        </span>

                                        <i class="ace-icon fa fa-caret-down"></i>
                                    </a>

                                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

                                        <li>
                                            <a href="<?= Yii::$app->params['app_url']['www'] . '/changepassword' ?>"><i class="ace-icon fa fa-unlock"></i> Change password</a>
                                        </li>
                                        <li>
                                            <a href="<?= Yii::$app->params['app_url']['hr'] . '/profile/view' ?>"><i class="ace-icon fa fa-user-circle-o"></i> Profile</a>
                                        </li>

                                        <li class="divider"></li>

                                        <li>
                                            <a href="<?= Url::to(['/site/logout']) ?>" data-method="post"><i class="ace-icon fa fa-power-off"></i> Logout</a>                  
                                        </li>
                                    </ul>
                                </li>

                                <!-- /section:basics/navbar.user_menu -->
                            </ul>


                        </div> <!-- <div> with id="right-nav-buttons-inner"-->

                    </div> <!--  <div> with id="right-nav-buttons" -->
                <?php } ?>
                <!--                For larger screen size this, login button has been used, for smaller, another menu toggle button
                                defined above-->

                <!--             login section for larger screen-->
                <?php if (Yii::$app->user->isGuest) { ?>
                    <div class="navbar-buttons navbar-header pull-right" role="navigation" id="right-nav-buttons">
                        <ul class="ace ace-nav">
                            <li class="" style="margin-left:-20px">
                                <?= Html::a('<i class="ace-icon fa fa-login"></i>Login', ['/user/login'], ['class' => '', 'style' => '']) ?> 

                            </li>
                        </ul>
                    </div> 
                <?php } ?>  
                <!--            login section for larger screen end-->

                <!-- /section:basics/navbar.dropdown -->
            </div><!-- /.navbar-container -->
        </div>

        <!-- /section:basics/navbar.layout -->
        <div class="main-container" id="main-container">

            <div class="main-content">

                <div class="main-content-inner">

                    <?php
                    $url_temp = Yii::$app->request->url;
                    if ($url_temp != '/' and $url_temp != '/site' and $url_temp != '/site/index' and $url_temp != '/user/login') {
                        ?>

                        <!--<div class="text-left widget-header widget-header-flat widget-header-small ">--->
                        <div class="breadcrumbs">
                            <?php
                            echo Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                'homeLink' =>
                                (Yii::$app->user->isGuest) ? ['label' => 'Fieldata', 'url' => '/'] : [
                                    'label' => 'Jal Mal',
                                    'url' => '/dashboard',
                                    'template' => '<li><a href="/dashboard" ><i class="ace-icon blue fa fa-home home-icon bigger-150"></i></a></li>',
                                        ]
                                    ,
                            ]);
                            ?>
                            <div class="pull-right"><?= date("l, F d Y") ?></div>
                        </div>
                    <?php } ?>

                    <div class="page-content" >
                        <!--<div class="page-header"></div> -->

                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <?php
                                echo AlertBlock::widget([
                                    'useSessionFlash' => true,
                                    'type' => AlertBlock::TYPE_ALERT,
                                    'delay' => 0,
                                ]);
                                ?>
                                <div class="left content">
                                    <?= $content ?>                                  
                                </div>

                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <div class="footer">
                <div class="footer-inner">
                    <!-- #section:basics/footer -->
                    <div class="footer-content">
                        <span class="bigger-8 pull-left" style ='font-size:10px'>
<!--                            <span class="blue" >
                                &COPY; <?php echo date("Y"); ?><?php echo Html::a(' Triline Infotech Pvt. Ltd.', 'http://triline.in/', ['style' => 'text-decoration:none;', 'target' => '_blank']); ?></span>
                            All Rights Reserved. Users are advised to read Terms and Conditions carefully.
                        </span>-->
                            <span class="bigger-100 pull-right">
                                <span class="black">
                                    Facilitated by Department of Rural Development, Government of Uttar Pradesh                         
                                </span>
                                &nbsp; &nbsp;
                                </div>

                                <!-- /section:basics/footer -->
                                </div>
                                </div>

                                <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                                    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
                                </a>
                                </div><!-- /.main-container -->
                                <!-- inline scripts related to this page -->


                                <?php $this->endBody() ?>

                                <script>

                                    $(document).ready(function () {
                                        ////                var l = $(location).attr('href');
                                        ////                alert(l);
                                        //                $(window).resize(function () {
                                        //                    $("#a").text(($(window).width() + '  ' + $(window).height()));
                                        //                });
                                        var w_width = $(window).width();

                                        var from = 760;
                                        var upto = 991;
                                        if (w_width >= from && w_width < upto) {
                                            if (!$('#navbar').hasClass('top-menu-adjust')) {
                                                $('#navbar').addClass('top-menu-adjust');
                                                $('#navbar').css({"z-index": 10});
                                            }
                                            $('#navbar').removeClass('navbar-collapse').addClass('navbar-collapsed');
                                            $('#menu-button-toggler').addClass('btn  btn-primary btn-xs');
                                            if (!$('ul.nav.nav-list').hasClass('hide')) {
                                                $('ul.nav.nav-list').addClass('hide');
                                            }
                                            $('#menu-button-toggler').click(function () {
                                                if ($('ul.nav.nav-list').hasClass('hide')) {
                                                    $('ul.nav.nav-list').removeClass('hide')
                                                } else {
                                                    $('ul.nav.nav-list').addClass('hide')
                                                }
                                            })

                                        }



                                        $(window).resize(function () {
                                            var w_width = $(window).width();
                                            var from = 760;
                                            var upto = 991;
                                            if (w_width >= from && w_width <= upto) {
                                                $('#navbar').removeClass('navbar-collapse').addClass('navbar-collapsed');
                                                $('#menu-button-toggler').addClass('btn  btn-primary btn-xs');
                                                if (!$('ul.nav.nav-list').hasClass('hide')) {
                                                    $('ul.nav.nav-list').addClass('hide');
                                                }
                                                $('#menu-button-toggler').click(function () {
                                                    if ($('ul.nav.nav-list').hasClass('hide')) {
                                                        $('ul.nav.nav-list').removeClass('hide');
                                                    } else {
                                                        $('ul.nav.nav-list').addClass('hide');
                                                    }
                                                })
                                                if (!$('#navbar').hasClass('top-menu-adjust')) {
                                                    $('#navbar').addClass('top-menu-adjust');
                                                    $('#navbar').css({"z-index": 10});
                                                }
                                            } else {

                                                if ($('#navbar').hasClass('navbar-collapsed')) {
                                                    $('#navbar').removeClass('navbar-collapsed').addClass('navbar-collapse');
                                                }
                                                if ($('#menu-button-toggler').hasClass('btn')) {
                                                    $('#menu-button-toggler').removeClass('btn  btn-primary btn-xs');
                                                }
                                                if ($('ul.nav.nav-list').hasClass('hide')) {
                                                    $('ul.nav.nav-list').removeClass('hide')
                                                }
                                                if ($('#navbar').hasClass('top-menu-adjust')) {
                                                    $('#navbar').removeClass('top-menu-adjust');
                                                    $('#navbar').css({"z-index": ""});
                                                }
                                                //                         $('#menu-button-toggler').click(function () {
                                                //                            if ($('ul.nav.nav-list').hasClass('hide')) {
                                                //                                $('ul.nav.nav-list').removeClass('hide');
                                                //                            }
                                                //                            else {
                                                //                                $('ul.nav.nav-list').addClass('hide');
                                                //                            }
                                                //                        })
                                            }
                                        });
                                    })
                                </script>

                                <script>



                                            ;/**
                                             <b>Widget boxes</b>
                                             */
                                    (function ($, undefined) {

                                        var Widget_Box = function (box, options) {
                                            this.$box = $(box);
                                            var that = this;
                                            //this.options = $.extend({}, $.fn.widget_box.defaults, options);

                                            this.reload = function () {
                                                var $box = this.$box;
                                                var $remove_position = false;
                                                if ($box.css('position') == 'static') {
                                                    $remove_position = true;
                                                    $box.addClass('position-relative');
                                                }
                                                $box.append('<div class="widget-box-overlay"><i class="' + ace.vars['icon'] + 'loading-icon fa fa-spinner fa-spin fa-2x white"></i></div>');

                                                $box.one('reloaded.ace.widget', function () {
                                                    $box.find('.widget-box-overlay').remove();
                                                    if ($remove_position)
                                                        $box.removeClass('position-relative');
                                                });
                                            }

                                            this.close = function () {
                                                var $box = this.$box;
                                                var closeSpeed = 300;
                                                $box.fadeOut(closeSpeed, function () {
                                                    $box.trigger('closed.ace.widget');
                                                    $box.remove();
                                                }
                                                )
                                            }

                                            this.toggle = function (type, button) {
                                                var $box = this.$box;
                                                var $body = $box.find('.widget-body').eq(0);
                                                var $icon = null;

                                                var event_name = typeof type !== 'undefined' ? type : ($box.hasClass('collapsed') ? 'show' : 'hide');
                                                var event_complete_name = event_name == 'show' ? 'shown' : 'hidden';

                                                if (typeof button === 'undefined') {
                                                    button = $box.find('> .widget-header a[data-action=collapse]').eq(0);
                                                    if (button.length == 0)
                                                        button = null;
                                                }

                                                if (button) {
                                                    $icon = button.find(ace.vars['.icon']).eq(0);

                                                    var $match
                                                    var $icon_down = null
                                                    var $icon_up = null
                                                    if (($icon_down = $icon.attr('data-icon-show'))) {
                                                        $icon_up = $icon.attr('data-icon-hide')
                                                    } else if ($match = $icon.attr('class').match(/fa\-(.*)\-(up|down)/)) {
                                                        $icon_down = 'fa-' + $match[1] + '-down'
                                                        $icon_up = 'fa-' + $match[1] + '-up'
                                                    }
                                                }

                                                var expandSpeed = 250;
                                                var collapseSpeed = 200;

                                                if (event_name == 'show') {
                                                    if ($icon)
                                                        $icon.removeClass($icon_down).addClass($icon_up);

                                                    $body.hide();
                                                    $box.removeClass('collapsed');
                                                    $body.slideDown(expandSpeed, function () {
                                                        $box.trigger(event_complete_name + '.ace.widget')
                                                    })
                                                } else {
                                                    if ($icon)
                                                        $icon.removeClass($icon_up).addClass($icon_down);
                                                    $body.slideUp(collapseSpeed, function () {
                                                        $box.addClass('collapsed')
                                                        $box.trigger(event_complete_name + '.ace.widget')
                                                    }
                                                    );
                                                }
                                            }

                                            this.hide = function () {
                                                this.toggle('hide');
                                            }
                                            this.show = function () {
                                                this.toggle('show');
                                            }


                                            this.fullscreen = function () {
                                                var $icon = this.$box.find('> .widget-header a[data-action=fullscreen]').find(ace.vars['.icon']).eq(0);
                                                var $icon_expand = null
                                                var $icon_compress = null
                                                if (($icon_expand = $icon.attr('data-icon1'))) {
                                                    $icon_compress = $icon.attr('data-icon2')
                                                } else {
                                                    $icon_expand = 'fa-expand';
                                                    $icon_compress = 'fa-compress';
                                                }


                                                if (!this.$box.hasClass('fullscreen')) {
                                                    $icon.removeClass($icon_expand).addClass($icon_compress);
                                                    this.$box.addClass('fullscreen');

                                                    applyScrollbars(this.$box, true);
                                                } else {
                                                    $icon.addClass($icon_expand).removeClass($icon_compress);
                                                    this.$box.removeClass('fullscreen');

                                                    applyScrollbars(this.$box, false);
                                                }

                                                this.$box.trigger('fullscreened.ace.widget')
                                            }

                                        }

                                        $.fn.widget_box = function (option, value) {
                                            var method_call;

                                            var $set = this.each(function () {
                                                var $this = $(this);
                                                var data = $this.data('widget_box');
                                                var options = typeof option === 'object' && option;

                                                if (!data)
                                                    $this.data('widget_box', (data = new Widget_Box(this, options)));
                                                if (typeof option === 'string')
                                                    method_call = data[option](value);
                                            });

                                            return (method_call === undefined) ? $set : method_call;
                                        };


                                        $(document).on('click.ace.widget', '.widget-header a[data-action]', function (ev) {
                                            ev.preventDefault();

                                            var $this = $(this);
                                            var $box = $this.closest('.widget-box');
                                            if ($box.length == 0 || $box.hasClass('ui-sortable-helper'))
                                                return;

                                            var $widget_box = $box.data('widget_box');
                                            if (!$widget_box) {
                                                $box.data('widget_box', ($widget_box = new Widget_Box($box.get(0))));
                                            }

                                            var $action = $this.data('action');
                                            if ($action == 'collapse') {
                                                var event_name = $box.hasClass('collapsed') ? 'show' : 'hide';

                                                var event
                                                $box.trigger(event = $.Event(event_name + '.ace.widget'))
                                                if (event.isDefaultPrevented())
                                                    return

                                                $widget_box.toggle(event_name, $this);
                                            } else if ($action == 'close') {
                                                var event
                                                $box.trigger(event = $.Event('close.ace.widget'))
                                                if (event.isDefaultPrevented())
                                                    return

                                                $widget_box.close();
                                            } else if ($action == 'reload') {
                                                $this.blur();
                                                var event
                                                $box.trigger(event = $.Event('reload.ace.widget'))
                                                if (event.isDefaultPrevented())
                                                    return

                                                $widget_box.reload();
                                            } else if ($action == 'fullscreen') {
                                                var event
                                                $box.trigger(event = $.Event('fullscreen.ace.widget'))
                                                if (event.isDefaultPrevented())
                                                    return

                                                $widget_box.fullscreen();
                                            } else if ($action == 'settings') {
                                                $box.trigger('setting.ace.widget')
                                            }

                                        });


                                        function applyScrollbars($widget, enable) {
                                            var $main = $widget.find('.widget-main').eq(0);
                                            $(window).off('resize.widget.scroll');

                                            //IE8 has an unresolvable issue!!! re-scrollbaring with unknown values?!
                                            var nativeScrollbars = ace.vars['old_ie'] || ace.vars['touch'];

                                            if (enable) {
                                                var ace_scroll = $main.data('ace_scroll');
                                                if (ace_scroll) {
                                                    $main.data('save_scroll', {size: ace_scroll['size'], lock: ace_scroll['lock'], lock_anyway: ace_scroll['lock_anyway']});
                                                }

                                                var size = $widget.height() - $widget.find('.widget-header').height() - 10;//extra paddings
                                                size = parseInt(size);

                                                $main.css('min-height', size);
                                                if (!nativeScrollbars) {
                                                    if (ace_scroll) {
                                                        $main.ace_scroll('update', {'size': size, 'mouseWheelLock': true, 'lockAnyway': true});
                                                    } else {
                                                        $main.ace_scroll({'size': size, 'mouseWheelLock': true, 'lockAnyway': true});
                                                    }
                                                    $main.ace_scroll('enable').ace_scroll('reset');
                                                } else {
                                                    if (ace_scroll)
                                                        $main.ace_scroll('disable');
                                                    $main.css('max-height', size).addClass('overflow-scroll');
                                                }


                                                $(window)
                                                        .on('resize.widget.scroll', function () {
                                                            var size = $widget.height() - $widget.find('.widget-header').height() - 10;//extra paddings
                                                            size = parseInt(size);

                                                            $main.css('min-height', size);
                                                            if (!nativeScrollbars) {
                                                                $main.ace_scroll('update', {'size': size}).ace_scroll('reset');
                                                            } else {
                                                                $main.css('max-height', size).addClass('overflow-scroll');
                                                            }
                                                        });
                                            } else {
                                                $main.css('min-height', '');
                                                var saved_scroll = $main.data('save_scroll');
                                                if (saved_scroll) {
                                                    $main
                                                            .ace_scroll('update', {'size': saved_scroll['size'], 'mouseWheelLock': saved_scroll['lock'], 'lockAnyway': saved_scroll['lock_anyway']})
                                                            .ace_scroll('enable')
                                                            .ace_scroll('reset');
                                                }

                                                if (!nativeScrollbars) {
                                                    if (!saved_scroll)
                                                        $main.ace_scroll('disable');
                                                } else {
                                                    $main.css('max-height', '').removeClass('overflow-scroll');
                                                }
                                            }
                                        }

                                    })(window.jQuery);
                                    ;



                                </script>

                                <script>
                                    //                                    const observer = lozad('.lozad', {
                                    //                                        load: function (el) {
                                    //                                            console.log('loading element');
                                    //                                            el.src = el.getAttribute('data-src');
                                    //                                            // Custom implementation to load an element
                                    //                                            // e.g. el.src = el.getAttribute('data-src');
                                    //
                                    //
                                    //                                            $(function () {
                                    //                                                $('.popb').elevateZoom({
                                    //                                                    scrollZoom: true,
                                    //                                                    responsive: true,
                                    //                                                    zoomWindowOffetx: -600
                                    //                                                });
                                    //                                                $('.popbc').click(function () {
                                    //                                                    $('#imagecontent').html('');
                                    //                                                    $('#modal').modal('show')
                                    //                                                            .find('#imagecontent')
                                    //                                                            .load($(this).attr('value'));
                                    //                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
                                    //                                                });
                                    //                                            });
                                    //
                                    //                                        }
                                    //                                    }); // lazy loads elements with default selector as '.lozad'
                                    //                                    observer.observe();
                                </script>
                                </body>
                                </html>
                                <?php $this->endPage() ?>


