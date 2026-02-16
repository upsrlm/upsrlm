<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\FieldAppAsset;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;
use common\models\master\MasterRole;

/* @var $this \yii\web\View */
/* @var $content string */

FieldAppAsset::register($this);
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
                    <h2 style="color: #F79520;"> Admin Portal</h2>
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
                            <!--                            <li>
                                                            <a href="/"  style="padding-bottom: -20px">
                                                                <small>
                                                                    <img class="logo" src="/images/fieldata-logo.png" alt="Fieldata">                       
                                                                </small>
                                                            </a>
                                                        </li>-->

                            <?php if (!Yii::$app->user->isGuest) { ?>
                                <li class="blue">
                                    <a  class="dropdown-toggless" href="#">
                                        <span class="">&nbsp;</span>
                                    </a>   
                                </li>     

                                <li class="blue">
                                    <a  class="dropdown-toggles" href="/dashboard">
                                        <i class="ace-icon fa fa-dashboard"></i>
                                        <span class="">Dashboard</span>
                                    </a>  
                                </li>
                                <li class="blue">
                                    <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                        <i class="mdi mdi-view-list fa fa-users"></i> <span>Users</span> 
                                        <i class="ace-icon fa fa-caret-down"></i>
                                    </a>
                                    <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">
                                        <li>
                                            <a href="/user/bmmu" title="BMMU" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">BMMU</span></a>
                                        </li>
                                        <li>
                                            <a href="/user/dmmu" title="DMMU" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">DMMU</span></a>
                                        </li>
                                        <li>
                                            <a href="/user/smmu" title="SMMU" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">SMMU</span></a>
                                        </li>
                                        <li>
                                            <a href="/user/cbo" title="CBO User" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">CBO User</span></a>
                                        </li>
                                        <li>
                                            <a href="/user/dm" title="District Magistrate" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">District Magistrate</span></a>
                                        </li>
                                        <li>
                                            <a href="/user/dcnrlm" title="DC NRLM" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">DC NRLM </span></a>
                                        </li>
                                        <li>
                                            <a href="/user/dc" title="Divisional Commissioner" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Divisional Commissioner </span></a>
                                        </li>
                                        <li>
                                            <a href="/user/yp" title="Verifiers" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Verifiers (Young professional)</span></a>
                                        </li>
                                        <li>
                                            <a href="/user/rsethis" title="RSETI" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">RSETI</span></a>
                                        </li>
                                        <li>
                                            <a href="/user/nodalbank" title="RSETI Nodal Bank" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">RSETI Nodal Bank</span></a>
                                        </li>
                                        <li>
                                            <a href="/user/supportunit" title="Support Unit" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Support Unit</span></a>
                                        </li>
                                        <li>
                                            <a href="/user/bankdu" title="Bank/ FI partner agencies" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Bank/ FI partner agencies</span></a>
                                        </li>
                                        <li>
                                            <a href="/user/bankfipdnodal" title="Bank/FI Partner District Nodal" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Bank/FI Partner District Nodal</span></a>
                                        </li>
                                        <li>
                                            <a href="/user" title="Users" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">List</span></a>
                                        </li>
                                         <li>
                                            <a href="/user/deleted" title="Deleted user List" style="padding-left: 10px;"> <i class="ace-icon fa fa-user" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Deleted user List</span></a>
                                        </li>
                                        <?php if (Yii::$app->user->identity->role == MasterRole::ROLE_ADMIN || Yii::$app->user->identity->role == MasterRole::ROLE_CALL_CENTER_ADMIN) { ?>

                                            <li>
                                                <a href="/user/add" title="Add User" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Add New User</span></a>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                </li>
                                <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>             
                                    <li class="blue">
                                        <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                            <i class="mdi mdi-view-list"></i> <span>Master</span> 
                                            <i class="ace-icon fa fa-caret-down"></i>
                                        </a>
                                        <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">
                                            <li class="dropdown-header">
                                                <a href="/master/block/index" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Block List</span> </a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a href="/master/grampanchayat/index" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Gram Panchayat List</span> </a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a href="/master/master-village/index" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Village List</span> </a>
                                            </li>

                                            <li class="dropdown-header">
                                                <a href="/master/master-ulb/index" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">ULB List</span> </a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a href="/master/ward/index" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;"> Ward List</span> </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?> 
                                <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>             
                                    <li class="blue">
                                        <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                            <i class="mdi mdi-view-list"></i> <span>Front</span> 
                                            <i class="ace-icon fa fa-caret-down"></i>
                                        </a>
                                        <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">
                                            <li class="dropdown-header">
                                                <a href="/front/notice" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Notice List</span> </a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a href="/front/go" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Government Order List</span> </a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a href="/front/mediacoverage" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Media Coverage List</span> </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?> 
                                <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>             
                                    <li class="blue">
                                        <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                            <i class="mdi mdi-view-list"></i> <span>BC</span> 
                                            <i class="ace-icon fa fa-caret-down"></i>
                                        </a>
                                        <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">
                                             <li class="dropdown-header">
                                                <a href="/bc/certified" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Certified</span> </a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a href="/bc/notificationtemplate/" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Notification Templates</span> </a>
                                            </li>
                                            <li class="dropdown-header">
                                                <a href="/bc/notificationlog/" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">Notification Log</span> </a>
                                            </li>

                                        </ul>
                                    </li>
                                <?php } ?> 
                                    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>             
                                    <li class="blue">
                                        <a  data-toggle="dropdown" class="dropdown-toggle "  href="#">
                                            <i class="mdi mdi-view-list"></i> <span>CBO</span> 
                                            <i class="ace-icon fa fa-caret-down"></i>
                                        </a>
                                        <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">
                                            <li class="dropdown-header">
                                                <a href="/cbo/clf" style="padding-left: 10px;"> <i class="ace-icon fa fa-copy" style="color: #2b7dbc;"></i><span style="color: #2b7dbc;">CLF's</span> </a>
                                            </li>
                                            

                                        </ul>
                                    </li>
                                <?php } ?>
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
                                (Yii::$app->user->isGuest) ? ['label' => 'UPSRLM', 'url' => '/'] : [
                                    'label' => 'UPSRLM',
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


